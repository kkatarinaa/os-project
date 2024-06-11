-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: mysql:3306
-- Время создания: Июн 07 2024 г., 22:56
-- Версия сервера: 8.4.0
-- Версия PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `adaptive_info`
--

CREATE TABLE `adaptive_info` (
  `id` int DEFAULT NULL,
  `background_image` varchar(128) DEFAULT NULL,
  `title_name` varchar(80) DEFAULT NULL,
  `button_color` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `list_of_images`
--

CREATE TABLE `list_of_images` (
  `id` int NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `image` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `list_of_images`
--

INSERT INTO `list_of_images` (`id`, `name`, `image`) VALUES
(1, 'Tomas', '../uploads/prints/1676318851_papik_pro_p_tomas_shel111bi_risunok_karandashom_legkii.png'),
(2, 'Day-Night', '../uploads/prints/day-and-night.png'),
(3, 'Einstein', '../uploads/prints/11-1000x8310.png');

-- --------------------------------------------------------

--
-- Структура таблицы `list_of_products`
--

CREATE TABLE `list_of_products` (
  `id` int NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `front_image` varchar(128) DEFAULT NULL,
  `_2XS` int NOT NULL DEFAULT '0',
  `_XS` int NOT NULL DEFAULT '0',
  `_S` int NOT NULL DEFAULT '0',
  `_M` int NOT NULL DEFAULT '0',
  `_L` int NOT NULL DEFAULT '0',
  `_XL` int NOT NULL DEFAULT '0',
  `_2XL` int NOT NULL DEFAULT '0',
  `_3XL` int NOT NULL DEFAULT '0',
  `_4XL` int NOT NULL DEFAULT '0',
  `_5XL` int NOT NULL DEFAULT '0',
  `_6XL` int NOT NULL DEFAULT '0',
  `border_height` int DEFAULT NULL,
  `border_width` int DEFAULT NULL,
  `border_left` int DEFAULT NULL,
  `border_top` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `list_of_products`
--

INSERT INTO `list_of_products` (`id`, `name`, `front_image`, `_2XS`, `_XS`, `_S`, `_M`, `_L`, `_XL`, `_2XL`, `_3XL`, `_4XL`, `_5XL`, `_6XL`, `border_height`, `border_width`, `border_left`, `border_top`) VALUES
(1, 'Sweater', '../uploads/products/040qqq22-063-5-800x800.png', 0, 0, 100, 999, 1000, 0, 0, 1000, 0, 9, 0, 466, 259, 281, 179),
(2, 'Shorts', '../uploads/products/9rsuq4nu36s18t483p5ltu20f7fbnt8u.p.png', 0, 0, 98, 0, 98, 0, 0, 0, 97, 0, 0, 526, 772, 174, 350);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `ready` tinyint(1) DEFAULT NULL,
  `image` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `prints`
--

CREATE TABLE `prints` (
  `id` int NOT NULL,
  `image_of_print` varchar(32) DEFAULT NULL,
  `positionX` int DEFAULT NULL,
  `positionY` int DEFAULT NULL,
  `ready` tinyint(1) DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `angle_of_inclination` int DEFAULT NULL,
  `width` int DEFAULT NULL,
  `height` int DEFAULT NULL,
  `inscription` varchar(32) DEFAULT NULL,
  `inscription_color` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `type_of_product` varchar(32) DEFAULT NULL,
  `size` varchar(5) DEFAULT NULL,
  `ready` tinyint(1) DEFAULT NULL,
  `order_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `id` int NOT NULL,
  `login` varchar(32) DEFAULT NULL,
  `role` varchar(32) DEFAULT NULL,
  `pass` varchar(32) DEFAULT NULL,
  `work_status` varchar(7) NOT NULL DEFAULT 'offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `list_of_images`
--
ALTER TABLE `list_of_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name_index` (`name`);

--
-- Индексы таблицы `list_of_products`
--
ALTER TABLE `list_of_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name_index` (`name`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ready_index` (`ready`);

--
-- Индексы таблицы `prints`
--
ALTER TABLE `prints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ready_index` (`ready`),
  ADD KEY `order_id_index` (`order_id`),
  ADD KEY `image_of_print` (`image_of_print`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id_index` (`order_id`),
  ADD KEY `type_of_product` (`type_of_product`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_index` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `list_of_images`
--
ALTER TABLE `list_of_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `list_of_products`
--
ALTER TABLE `list_of_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `prints`
--
ALTER TABLE `prints`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
