-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 26 2018 г., 11:00
-- Версия сервера: 5.6.13
-- Версия PHP: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `elemag`
--
CREATE DATABASE IF NOT EXISTS `elemag` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `elemag`;

-- --------------------------------------------------------

--
-- Структура таблицы `bids`
--

CREATE TABLE IF NOT EXISTS `bids` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dates` date NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` int(10) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `bids`
--

INSERT INTO `bids` (`id`, `dates`, `name`, `address`, `phone`, `email`, `status`) VALUES
(1, '2018-11-22', 'Василий', 'Толстового, 12-23', '234-234-32', 'vas.vas12@yandex.ru', 2),
(2, '2018-11-26', 'Александра', 'ул. Пушкина, 14-23', '223-423-2', 'al@mail.by', 1),
(3, '2018-11-29', 'Соколов В.И.', 'Соколова, 12', '342-32-32', 'sokol@gmail.com', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `bid_products`
--

CREATE TABLE IF NOT EXISTS `bid_products` (
  `bid` int(10) NOT NULL,
  `product` int(10) NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`bid`,`product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bid_products`
--

INSERT INTO `bid_products` (`bid`, `product`, `size`, `quantity`, `price`) VALUES
(1, 1, 1, 1, '400.00'),
(1, 3, 2, 1, '350.00'),
(2, 3, 1, 1, '300.00'),
(3, 1, 3, 1, '400.00');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Верхняя одежда'),
(2, 'Футболки и майки'),
(3, 'Брюки и шорты'),
(4, 'Рубашки, блузки');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `name`, `content`) VALUES
(1, 'О магазине', '<p>Название: Интернет-магазин детской одежды</p>\n<p>Адрес: ул. Такая-то, 000, офис 000, Минск, Беларусь</p>\n<p>Телефон: +375 (00) 000-00-00</p>'),
(2, 'Доставка', '<h3 style="text-align: left;">Доставка по г. Минск</h3>\n<h3 style="text-align: left;">Осуществляется бесплатно при условии стоимости заказа свыше 300 руб.</h3>\n<ul>\n<li>Осуществляется не позднее следующего дня после оформления и согласования заказа</li>\n<li>Время доставки - с 19.00 до 23.00 по будням, если иное не согласовано с менеджером</li>\n</ul>'),
(3, 'Оплата', '<p>В соответствии с законодательством Республики Беларусь расчет за продаваемые товары осуществляется только в белорусских рублях</p>\n<p>Мы предлагаем следующие способы оплаты:</p>\n<ul>\n<li>Наличный расчет (при самовывозе либо доставке курьером)</li>\n<li>Безналичный расчет (для юридических лиц)</li>\n</ul>');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `parent` int(10) NOT NULL,
  `unit` int(10) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `parent`, `unit`, `price`, `image`) VALUES
(1, 'Куртка зимняя', 'Куртка зимняя для мальчика', 1, 1, '75.00', 'aa354fbe2221cf69a1439fd3a44a096a.jpg'),
(2, 'Куртка зимняя', 'Зимняя куртка для девочки (Sport Collection, Китай)', 1, 2, '70.00', 'b84afe44e732e626041e1b896b8e2819.jpg'),
(3, 'Футболка', 'Футболка Мотоцикл (Юлла, Россия)', 3, 1, '8.80', 'fbec1fd31928c868dc62c89112cfe312.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `product_sizes`
--

CREATE TABLE IF NOT EXISTS `product_sizes` (
  `product` int(10) unsigned NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`product`,`size`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_sizes`
--

INSERT INTO `product_sizes` (`product`, `size`, `quantity`) VALUES
(1, 1, 2),
(1, 2, 3),
(2, 1, 2),
(2, 3, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `product_specifications`
--

CREATE TABLE IF NOT EXISTS `product_specifications` (
  `product` int(10) NOT NULL,
  `specification` int(10) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`product`,`specification`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_specifications`
--

INSERT INTO `product_specifications` (`product`, `specification`, `value`) VALUES
(1, 1, 'полиэстер 100%'),
(1, 2, 'полиэстер 100% (флис)'),
(2, 1, 'полиэстер 100%'),
(2, 2, 'полиэстер 100% (флис)'),
(1, 3, 'полиэстер 100% (comorligt)'),
(2, 3, 'полиэстер 100%'),
(3, 4, 'хлопок 100%'),
(3, 5, 'кулирка');

-- --------------------------------------------------------

--
-- Структура таблицы `sizes`
--

CREATE TABLE IF NOT EXISTS `sizes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `sizes`
--

INSERT INTO `sizes` (`id`, `name`) VALUES
(1, '96-104'),
(2, '104-110'),
(3, '110-116'),
(4, '116-122');

-- --------------------------------------------------------

--
-- Структура таблицы `specifications`
--

CREATE TABLE IF NOT EXISTS `specifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `specifications`
--

INSERT INTO `specifications` (`id`, `name`) VALUES
(1, 'Материал верха'),
(2, 'Подклад'),
(3, 'Утеплитель'),
(4, 'Материал'),
(5, 'Ткань'),
(6, 'Цвет');

-- --------------------------------------------------------

--
-- Структура таблицы `status_bids`
--

CREATE TABLE IF NOT EXISTS `status_bids` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `status_bids`
--

INSERT INTO `status_bids` (`id`, `name`) VALUES
(1, 'Принят'),
(2, 'Подтвержден'),
(3, 'Исполнен'),
(4, 'Отменен');

-- --------------------------------------------------------

--
-- Структура таблицы `subcategories`
--

CREATE TABLE IF NOT EXISTS `subcategories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `parent` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `parent`) VALUES
(1, 'Куртки', 1),
(2, 'Пуховики', 1),
(3, 'Футболки', 2),
(4, 'Топы', 2),
(5, 'Джинсы', 3),
(6, 'Рубашки', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `units`
--

CREATE TABLE IF NOT EXISTS `units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `units`
--

INSERT INTO `units` (`id`, `name`) VALUES
(1, 'Для мальчиков'),
(2, 'Для девочек');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(0, 'superadmin', '1'),
(1, 'petrova_gv', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
