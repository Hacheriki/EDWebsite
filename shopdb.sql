-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 11 2023 г., 05:12
-- Версия сервера: 8.0.19
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shopdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(1, 'Футболки', 'Короткие и длинные футболки для повседневной носки'),
(2, 'Джинсы', 'Различные стили джинсов, включая прямые, узкие и рваные'),
(3, 'Платья', 'Платья для вечеринок, коктейльные и повседневные платья'),
(4, 'Куртки', 'Куртки для холодной и теплой погоды, включая пуховики и ветровки'),
(5, 'Спортивная одежда', 'Одежда для занятий спортом и фитнесом'),
(6, 'Рубашки', 'Классические и повседневные рубашки для разных случаев'),
(7, 'Шорты', 'Летние шорты и шорты для занятий спортом'),
(8, 'Юбки', 'Юбки различной длины и стилей, от мини до макси'),
(9, 'Обувь', 'Категория включает в себя разнообразную обувь, от кроссовок до туфель'),
(10, 'Аксессуары', 'Широкий ассортимент аксессуаров: шапки, сумки, ремни и т.д.');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `product_ids` json NOT NULL,
  `overall_price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `product_ids`, `overall_price`) VALUES
(1, '[11]', 2200),
(2, '[11, 2]', 9200);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `category_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `image_url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `category_id`, `quantity`, `image_url`, `is_featured`) VALUES
(1, 'Базовая футболка', 'Простая белая футболка из хлопка', '1200.00', 1, 50, 'https://imgcdn.loverepublic.ru/upload/images/24501/2450104320_50_4.jpg', 0),
(2, 'Джинсы Slim Fit', 'Узкие джинсы темно-синего цвета', '3500.00', 2, 28, 'https://cache-limeshop.cdnvideo.ru/limeshop/aa/744164159ec7ae0342fe211ee9dc200155d011401.jpeg?q=85&w=1536', 1),
(3, 'Вечернее платье', 'Черное коктейльное платье средней длины', '5000.00', 3, 20, 'https://shop-cdn1-2.vigbo.tech/shops/179977/products/21932890/images/3-3db214ed69bee5c3b5a899b2de033ba3.jpg', 1),
(4, 'Кожаная куртка', 'Черная кожаная куртка на молнии', '8000.00', 4, 15, 'https://imageproxy.fh.by/gYDqIAHdUZmzBIJG6QVerRhVLu0V-AasQqsXRYho5Rw/w:894/h:1342/rt:fit/q:95/czM6Ly9maC1wcm9kdWN0aW9uLXJmMy81NzUyNzAvNzY3NzkzZTYtNTNiMS0xMWVkLThiOTItMDA1MDU2ODM2NjFi.jpg', 0),
(5, 'Спортивные леггинсы', 'Черные эластичные леггинсы для фитнеса', '2500.00', 5, 40, 'https://forfitness.com.ua/wp-content/uploads/2019/02/icon-high-rise-leggings-2-min.jpg', 0),
(6, 'Классическая рубашка', 'Белая хлопковая рубашка с длинным рукавом', '3200.00', 6, 35, 'https://estet-men.ru/images/cms/thumbs/33d761249d17445a2dabf880ef918fb807991a83/IMG_4192_500_889_JPG_5_80.jpg', 0),
(7, 'Джинсовые шорты', 'Светлые джинсовые шорты с вышивкой', '2800.00', 7, 25, 'https://imgcdn.loverepublic.ru/upload/images/32564/thumb/600_9999/3256404704_101_4.jpg', 1),
(8, 'Плиссированная юбка', 'Длинная юбка в полоску', '3100.00', 8, 22, 'https://imgcdn.zarina.ru/upload/images/03282/thumb/450_9999/0328205205_63.jpg?t=1632468227', 0),
(9, 'Кеды на платформе', 'Белые кеды на высокой платформе', '4300.00', 9, 30, 'https://static.housebrand.com/media/catalog/product/cache/1200/a4e40ebdc3e371adff845072e1c73f37/6/5/6538P-99X-001-1-494963.jpg', 1),
(10, 'Кожаный ремень', 'Классический черный кожаный ремень', '1500.00', 10, 45, 'https://aws.kiiiosk.store/uploads/shop/146/uploads/product_image/image/663153/_1390974.jpg', 0),
(11, 'Шорты для бега', 'Легкие шорты для занятий бегом', '2200.00', 5, 23, 'https://ae04.alicdn.com/kf/H7cff708dcaec4b69954d933ed722bfefq.jpg_640x640.jpg', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
