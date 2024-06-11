import subprocess
import pymysql
import socket
import docker
import os

# Объявление функций для поиска свободных портов
def nginx_port(start_port, end_port):
    client = docker.from_env()

    used_ports = set()
    for container in client.containers.list(all=True):
        ports = container.attrs['HostConfig']['PortBindings']
        for port in ports:
            if ports[port] is not None:
                for binding in ports[port]:
                    used_ports.add(int(binding['HostPort']))

    for port in range(start_port, end_port+1):
        if port not in used_ports:
            try:
                with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
                    s.bind(("localhost", port))
                    s.listen(1)
            except OSError:
                continue
            return port

    return None
    
def mysql_port(start_port, end_port):
    client = docker.from_env()

    used_ports = set()
    for container in client.containers.list(all=True):
        ports = container.attrs['HostConfig']['PortBindings']
        for port_bindings in ports.values():
            if port_bindings is not None:
                for port_binding in port_bindings:
                    used_ports.add(int(port_binding['HostPort']))

    for port in range(start_port, end_port+1):
        if port not in used_ports:
            sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
            result = sock.connect_ex(('localhost', port))
            sock.close()
            if result != 0:
                return port

    return None

conn = pymysql.connect(host='172.24.0.5', user='root', password='root', database='project_os')
cur = conn.cursor()

# Удаление точек
cur.execute("SELECT name_location, client_id FROM places WHERE TIMESTAMPDIFF(SECOND, CONVERT_TZ(NOW(), '+00:00', '+03:00'), date_shutdown) < -86400")
deleting_places = cur.fetchall()

if deleting_places:
    for row in deleting_places:
        name_of_place = row[0].replace(" ", "-")

        cur.execute(f"SELECT login FROM clients WHERE id = '{row[1]}'")
        name_of_client = cur.fetchall()

        if name_of_client:
            client_name = name_of_client[0][0].replace(" ", "-")

        full_place_path = f"/home/artem_gladkov/service/CRM/Places/{client_name}/{name_of_place}"
        command = f"cd {full_place_path} && docker compose down"
        subprocess.run(command, shell=True)
	
        full_client_path = f"/home/artem_gladkov/service/CRM/Places/{client_name}" 
        command = f"cd {full_client_path} && rm -rf {name_of_place}"
        subprocess.run(command, shell=True)

        # удаление папки клиента, если она пустая
        subfolders = [f.name for f in os.scandir(full_client_path) if f.is_dir()]
        if not subfolders:
            cmd = f"rm -r {full_client_path}"
            subprocess.run(cmd, shell=True)
        
        # удаление точки из базы данных
        cur.execute(f"DELETE FROM places WHERE name_location = '{row[0]}'")
        conn.commit()
        
        # редактирование .conf файла общего nginx
        main_nginx_path = '/home/artem_gladkov/service/main-nginx/nginx.conf'
        with open(main_nginx_path, "r") as file:
            file_lines = file.readlines()
        
        updated_file_lines = []

        delete_block = False
        lines_to_delete = 6
        
        for line in file_lines:
            if delete_block:
                lines_to_delete -= 1
                if lines_to_delete == 0:
                    delete_block = False
            elif line.strip() == f"location /{client_name}/{name_of_place} {{":
                delete_block = True
            else:
                updated_file_lines.append(line)

        with open(main_nginx_path, "w") as file:
            file.writelines(updated_file_lines)

# Создание точек
cur.execute(
    "SELECT name_location, client_id FROM places WHERE TIMESTAMPDIFF(SECOND, CONVERT_TZ(NOW(), '+00:00', '+03:00'), date_connection) <= 0 AND status LIKE 'agreed'")
working_places = cur.fetchall()

if working_places:
    for row in working_places:
        name_of_place = row[0].replace(" ", "-")
	
        cur.execute(f"SELECT login FROM clients WHERE id = '{row[1]}'")
        name_of_client = cur.fetchall()

        if name_of_client:
            client_name = name_of_client[0][0].replace(" ", "-")
	    
        # Создание папок клиента и конкретной точки
        client_path = f"CRM/Places/{client_name}/"
        
        if not subprocess.run(["ls", client_path], stdout=subprocess.PIPE, stderr=subprocess.PIPE).returncode == 0:
            command = "mkdir " + client_path
            subprocess.run(command, shell=True)
         
        place_path = client_path + name_of_place
        
        if not subprocess.run(["ls", place_path], stdout=subprocess.PIPE, stderr=subprocess.PIPE).returncode == 0:
            command = "mkdir " + place_path
            subprocess.run(command, shell=True)
        else:
            full_place_path = '/home/artem_gladkov/service/' + place_path
            command = f"cd {full_place_path} && docker compose up -d"
            subprocess.run(command, shell=True)
            cur.execute(f"UPDATE places SET status = 'active' WHERE name_location = '{row[0]}'")
            conn.commit()
            continue
     	
     	# Порты
        port = nginx_port(8080, 10000)
        my_port = mysql_port(3306, 4266)

        # создание nginx.conf файла точки
        place_nginx_config = f'''server {{
    listen       80;
    server_name  localhost;

    root   /var/www/html;
    index  index.php index.html index.htm;

    error_page  404 /404.html;
    location = /50x.html {{
        root /var/www/html;
    }}

    location = /database {{
        return 301 http://localhost:{port + 1};
    }}

    location ~ \.php$ {{
        root /var/www/html;
        fastcgi_pass   php:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }}
}}'''
        nginx_place_path = f"/home/artem_gladkov/service/{place_path}/nginx.conf"
        with open(nginx_place_path, 'w') as file:
            file.write(place_nginx_config)

        # создание docker-compose файла
        docker_compose = f'''version: '3'

services:
  php:
    restart: always
    build: 
      context: .
      dockerfile: ../../../Dockerfile
    container_name: {client_name}_{name_of_place}.php
    volumes:
      - "../../../Project:/var/www/html"
      - "./uploads:/var/www/html/uploads"
    depends_on:
      - mysql

  nginx:
    restart: always
    image: nginx:latest
    container_name: {client_name}_{name_of_place}.nginx
    volumes:
      - "../../../Project:/var/www/html"
      - "./uploads:/var/www/html/uploads"
      - "./nginx.conf:/etc/nginx/conf.d/default.conf"
    ports:
      - {port}:80
    depends_on:
      - mysql

  mysql:
    restart: always
    image: mysql:latest
    container_name: {client_name}_{name_of_place}.mysql
    environment:
      MYSQL_DATABASE: project
      MYSQL_USER: user            
      MYSQL_PASSWORD: password
      MYSQL_ROOT_PASSWORD: root
    ports:
      - "{my_port}:3306"
    volumes:
      - "../../../db/:/docker-entrypoint-initdb.d"
      - db_data:/var/lib/mysql 

  phpmyadmin:
    restart: always
    image: phpmyadmin/phpmyadmin
    container_name: {client_name}_{name_of_place}.phpma
    environment:
      - PMA_HOST=mysql
      - PMA_PORT=3306
      - MYSQL_ROOT_PASSWORD=root
    ports: 
      - {port+1}:80
    depends_on:
      - mysql

volumes: 
  db_data:'''

        docker_place_path = '/home/artem_gladkov/service/' + place_path + '/docker-compose.yml'
        with open(docker_place_path, 'w') as docker_file:
            docker_file.write(docker_compose)
            
        full_place_path = '/home/artem_gladkov/service/' + place_path
        command = f"cp -rp /home/artem_gladkov/service/CRM/uploads {full_place_path}/uploads"
        subprocess.run(command, shell=True)
        
        # запуск точки (docker compose up)
        command = f"cd {full_place_path} && docker compose up -d"
        subprocess.run(command, shell=True)

        # Запись в main-nginx.conf
        main_nginx_config = f'''
        location /{client_name}/{name_of_place} {{
            return 301 http://localhost:{port};
        }}
        
        location /{client_name}/{name_of_place}/Service {{
            return 301 http://localhost:{port}/Service/login_page.php;
        }}
'''
        main_nginx_path = '/home/artem_gladkov/service/main-nginx/nginx.conf'

        with open(main_nginx_path, 'r') as file:
            data = file.readlines()

        for i, line in enumerate(data):
            if "}" in line:
                data.insert(i + 1, main_nginx_config)
                break

        with open(main_nginx_path, 'w') as file:
            file.writelines(data)
            
        command = "cd /home/artem_gladkov/service/main-nginx && docker restart main-ng"
        subprocess.run(command, shell=True)

        # Место -> статус:активно
        cur.execute(f"UPDATE places SET status = 'active' WHERE name_location = '{row[0]}'")
        conn.commit()
        
# Обновление данных (active -> time is out)
cur.execute("UPDATE places SET status = 'time is out' WHERE TIMESTAMPDIFF(SECOND, CONVERT_TZ(NOW(), '+00:00', '+03:00'), date_shutdown) < 0 AND status LIKE 'active'")
conn.commit()      

# Остановка точек (stopped) 
cur.execute("SELECT name_location, client_id FROM places WHERE status = 'stopped' OR status = 'time is out'")
stopping_places = cur.fetchall()

if stopping_places:
    for row in stopping_places:
        name_of_place = row[0].replace(" ", "-")
        
        cur.execute(f"SELECT login FROM clients WHERE id = '{row[1]}'")
        name_of_client = cur.fetchall()
	
        if name_of_client:
            client_name = name_of_client[0][0].replace(" ", "-")
	    
        full_place_path = f"/home/artem_gladkov/service/CRM/Places/{client_name}/{name_of_place}"
        command = f"cd {full_place_path} && docker compose stop"
        subprocess.run(command, shell=True)
        
cur.close()
conn.close()

