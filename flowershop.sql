-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 11 2023 г., 13:42
-- Версия сервера: 5.7.33
-- Версия PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `flowershop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart_products`
--

CREATE TABLE `cart_products` (
  `id_cart_product` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `colors`
--

CREATE TABLE `colors` (
  `id_color` int(11) NOT NULL,
  `color_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `colors`
--

INSERT INTO `colors` (`id_color`, `color_name`) VALUES
(1, 'Красный'),
(2, 'Желтый'),
(3, 'Белый'),
(4, 'Черный'),
(5, 'Фиолетовый'),
(6, 'Розовый'),
(7, 'Коричневый'),
(8, 'Цветной');

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE `countries` (
  `id_country` int(11) NOT NULL,
  `country_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id_country`, `country_name`) VALUES
(1, 'Россия'),
(2, 'Германия'),
(3, 'Бельгия'),
(4, 'Канада'),
(5, 'Франция'),
(6, 'Швейцария');

-- --------------------------------------------------------

--
-- Структура таблицы `order_products`
--

CREATE TABLE `order_products` (
  `id_order_product` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `order_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cancel_message` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_products`
--

INSERT INTO `order_products` (`id_order_product`, `count`, `order_datetime`, `status_id`, `product_id`, `user_id`, `cancel_message`) VALUES
(8, 2, '2023-05-03 13:24:39', 1, 1, 2, NULL),
(9, 4, '2023-05-03 14:14:20', 3, 5, 2, 'нет на складе'),
(10, 2, '2023-05-11 12:25:05', 2, 11, 2, NULL),
(11, 23, '2023-05-11 12:34:32', 1, 3, 2, NULL),
(12, 1, '2023-05-11 13:40:55', 1, 5, 2, NULL),
(13, 480, '2023-05-11 13:40:57', 1, 3, 2, NULL),
(14, 2, '2023-05-11 13:40:59', 1, 4, 2, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id_product`, `image`, `product_name`, `price`, `amount`, `color_id`, `product_type_id`, `country_id`) VALUES
(1, '/source/f_1.jpg', 'Маргаритки красные', 120, 18, 1, 1, 6),
(2, '/source/g_1.jpg', 'Горшок для цветов обычный', 680, 75, 7, 3, 1),
(3, '/source/o_1.jpg', 'Обертка для цветов', 35, 480, 8, 2, 1),
(4, '/source/g_2.jpg', 'Ваза для цветов', 1600, 12, 2, 3, 3),
(5, '/source/f_2.jpg', 'Роза черная', 160, 17, 4, 1, 1),
(11, '/source/1683795877_Без названия.jpg', 'Алфавит русский', 1200, 12, 8, 3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product_types`
--

CREATE TABLE `product_types` (
  `id_product_type` int(11) NOT NULL,
  `product_type_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_types`
--

INSERT INTO `product_types` (`id_product_type`, `product_type_name`) VALUES
(1, 'Цветы'),
(2, 'Упаковка'),
(3, 'Дополнительно');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id_role`, `role_name`) VALUES
(1, 'USER'),
(2, 'ADMIN');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id_status` int(11) NOT NULL,
  `status_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id_status`, `status_name`) VALUES
(1, 'Новый'),
(2, 'Завершенный'),
(3, 'Отмененный');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `surname`, `name`, `patronymic`, `email`, `login`, `password`, `role_id`) VALUES
(1, 'Камалов', 'Арслан', 'Рахмиддинович', 'admin@mail.ru', 'admin', 'admin44', 2),
(2, 'Камалов', 'Арслан', 'Рахмиддинович', 'user@mail.ru', 'user', 'user44', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart_products`
--
ALTER TABLE `cart_products`
  ADD PRIMARY KEY (`id_cart_product`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id_color`);

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id_country`);

--
-- Индексы таблицы `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id_order_product`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `product_type_id` (`product_type_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Индексы таблицы `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id_product_type`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id_status`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart_products`
--
ALTER TABLE `cart_products`
  MODIFY `id_cart_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `colors`
--
ALTER TABLE `colors`
  MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id_country` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id_order_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id_product_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart_products`
--
ALTER TABLE `cart_products`
  ADD CONSTRAINT `cart_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id_product`),
  ADD CONSTRAINT `cart_products_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`);

--
-- Ограничения внешнего ключа таблицы `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id_status`),
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id_product`),
  ADD CONSTRAINT `order_products_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`);

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id_color`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`product_type_id`) REFERENCES `product_types` (`id_product_type`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id_country`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
