
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 15 2015 г., 16:24
-- Версия сервера: 10.0.12-MariaDB
-- Версия PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `u405631617_test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `appartment`
--

CREATE TABLE IF NOT EXISTS `appartment` (
  `id_app` int(11) NOT NULL AUTO_INCREMENT,
  `room_num` text NOT NULL,
  `hostel_num` text NOT NULL,
  `max` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_app`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `appartment`
--

INSERT INTO `appartment` (`id_app`, `room_num`, `hostel_num`, `max`) VALUES
(1, '123', '321', 2),
(2, '223', '3', 3),
(3, '222', '2', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `price_app` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_event`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`id_event`, `description`, `price_app`) VALUES
(1, 'fadssaf', 123),
(2, 'test', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `food`
--

CREATE TABLE IF NOT EXISTS `food` (
  `id_user` int(11) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `food`
--

INSERT INTO `food` (`id_user`, `start`, `end`) VALUES
(3, '2015-06-06', '2015-06-28'),
(1, '2015-06-08', '2015-06-25'),
(2, '2015-06-09', '2015-06-19'),
(5, '2015-06-09', '2015-06-19'),
(6, '2015-06-10', '2015-06-13'),
(7, '2015-06-10', '2015-06-30');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `email` text NOT NULL,
  `mobile_number` int(11) DEFAULT NULL,
  `age` int(11) NOT NULL,
  `sex` text NOT NULL,
  `id_app` int(11) DEFAULT NULL,
  `id_event` int(11) DEFAULT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `first_name`, `last_name`, `middle_name`, `email`, `mobile_number`, `age`, `sex`, `id_app`, `id_event`, `start`, `end`) VALUES
(1, 'Александр', 'Пенко', 'Валерьевич', 'odael.odes@gmail.com', 12432532, 18, 'm', NULL, 2, '0000-00-00', '0000-00-00'),
(2, 'Никита', 'Рогальский', 'ХЗ', 'asf@fasfs.s', 1231289, 20, 'm', 2, 1, '2015-06-08', '2015-06-25'),
(3, 'Мария', 'Сулима', 'Валентиновна', 'ter@ma.ru', 1321412, 17, 'm', 2, 1, '2015-06-08', '2015-06-19'),
(4, 'Максим', 'Чайковский', 'Андреевич', 'fndksl@dsfa.ds', 421089709, 17, 'm', NULL, 1, '0000-00-00', '0000-00-00'),
(5, 'Лолец', 'Лолец', 'Лолецович', 'saa@dsa.s', 1242, 32, 'm', 1, 1, '2015-06-09', '2015-06-20'),
(6, 'Сабир', 'Шайхлисламов', 'Хаиеритдинович', 'sha-sabir@yandex.ru', 2147483647, 23, 'm', 2, 1, '2015-06-10', '2015-06-12'),
(7, 'Игорян', 'Марков', 'Владимирович', 'igoryan@mail.ru', 5235230, 18, 'm', 1, 1, '2015-06-10', '2015-06-30'),
(8, 'Александр', 'Глушко', 'Андреевич', 'авава@re.re', 232323, 17, 'm', NULL, 1, '0000-00-00', '0000-00-00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
