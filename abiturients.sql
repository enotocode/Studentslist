-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Сен 09 2016 г., 10:13
-- Версия сервера: 5.7.9
-- Версия PHP: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `studentslist`
--

-- --------------------------------------------------------

--
-- Структура таблицы `abiturients`
--

DROP TABLE IF EXISTS `abiturients`;
CREATE TABLE IF NOT EXISTS `abiturients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `lastName` varchar(80) NOT NULL,
  `gender` enum('GENDER_MALE','GENDER_FEMALE') NOT NULL,
  `groupNum` varchar(10) NOT NULL,
  `email` varchar(63) NOT NULL,
  `egePoints` varchar(3) NOT NULL,
  `dateOfBirth` year(4) NOT NULL,
  `registry` enum('REGISTRY_LOCAL','REGISTRY_NOT_LOCAL') NOT NULL,
  `userPassword` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `abiturients`
--

INSERT INTO `abiturients` (`id`, `name`, `lastName`, `gender`, `groupNum`, `email`, `egePoints`, `dateOfBirth`, `registry`, `userPassword`) VALUES
(12, 'Николай', 'Пушкин', 'GENDER_MALE', 'АТБ-7', 'nikola@mail.ru', '345', 1990, 'REGISTRY_LOCAL', 'pass_12345\r'),
(2, 'Сергей', 'Плюшкин', 'GENDER_MALE', 'ПК-12-2', 'sergey@mail.ru', '243', 1991, 'REGISTRY_NOT_LOCAL', 'pass_12346\r'),
(3, 'Александр', 'Коротышкин', 'GENDER_MALE', 'АТБ-7', 'alex@mail.ru', '365', 1991, 'REGISTRY_NOT_LOCAL', 'pass_12347\r'),
(4, 'Светлана', 'Долговязова', 'GENDER_FEMALE', 'ПК-12-2', 'sveta@mail.ru', '375', 1991, 'REGISTRY_LOCAL', 'pass_12348\r'),
(5, 'Виктория', 'Дубина', 'GENDER_FEMALE', 'ТМ-2', 'vika@mail.ru', '300', 1990, 'REGISTRY_NOT_LOCAL', 'pass_12349\r'),
(6, 'Сергей', 'Березовский', 'GENDER_MALE', 'ЩР-69', 'serj@mail.ru', '289', 1992, 'REGISTRY_NOT_LOCAL', 'pass_12340\r'),
(7, 'Евгений', 'Науменко', 'GENDER_MALE', 'СТН-666', 'evg01@mail.ru', '380', 1989, 'REGISTRY_LOCAL', 'pass_21841\r'),
(8, 'Кальзубек', 'Кыгыров', 'GENDER_MALE', 'ПАЕА-08', 'kalzubek@mail.ru', '245', 1991, 'REGISTRY_NOT_LOCAL', 'pass_12341\r'),
(9, 'Александра', 'Цветкова', 'GENDER_FEMALE', 'ИТБ-12-2', 'alexandra@mail.ru', '256', 1991, 'REGISTRY_NOT_LOCAL', 'pass_12342\r'),
(10, 'Ротимир', 'Колбасов', 'GENDER_MALE', 'ПК-12-2', 'rotimir@mail.ru', '360', 1991, 'REGISTRY_LOCAL', 'pass_12343\r'),
(11, 'Евгенйи', 'Ройзман', 'GENDER_MALE', 'ИТБ-12-2', 'evg777@mail.ru', '246', 1991, 'REGISTRY_LOCAL', 'pass_12344\r'),
(13, 'Александр', 'Ширяев', 'GENDER_MALE', 'ПАЕА-08', 'aaa666@mail.ru', '227', 1990, 'REGISTRY_NOT_LOCAL', 'pass_12351\r'),
(14, 'Светлана', 'Ли', 'GENDER_FEMALE', 'ТМ-2', 'svetlana@mail.ru', '245', 1991, 'REGISTRY_NOT_LOCAL', 'pass_12352\r'),
(15, 'Семен', 'Голубцов', 'GENDER_MALE', 'ТМ-2', 'semen@mail.ru', '365', 1990, 'REGISTRY_NOT_LOCAL', 'pass_12353\r'),
(16, 'Дмитрий', 'Рюриков', 'GENDER_MALE', 'ИТБ-12-2', 'dmr@mail.ru', '287', 1992, 'REGISTRY_LOCAL', 'pass_12354\r'),
(17, 'Виктория', 'Кац', 'GENDER_FEMALE', 'ПК-12-2', 'kacv@mail.ru', '400', 1991, 'REGISTRY_LOCAL', 'pass_12355\r'),
(18, 'Алексей', 'Цыганков', 'GENDER_MALE', 'ЩР-69', 'cia@mail.ru', '150', 1991, 'REGISTRY_NOT_LOCAL', 'pass_12356\r'),
(19, 'Василий', 'Руковичкин', 'GENDER_MALE', 'ИГН-1', 'vasya@mail.ru', '321', 1991, 'REGISTRY_LOCAL', 'pass_57557'),
(20, 'Богдан', 'Титомиров', 'GENDER_MALE', 'АТБ-2', 'bogdan@mail.ru', '400', 1989, 'REGISTRY_LOCAL', 'pass_47203'),
(21, 'Марк', 'Шевцов', 'GENDER_MALE', 'ИТР-3', 'mark@mail.ru', '198', 1991, 'REGISTRY_NOT_LOCAL', 'd390ff78e92316db295f4f0391221b86');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
