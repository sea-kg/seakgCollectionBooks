-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--                          
-- База данных: `collection_books`
--

-- --------------------------------------------------------

--
-- Структура таблицы `type_of_publisher`
--

CREATE TABLE IF NOT EXISTS `cb000_publishers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `places`
--

CREATE TABLE IF NOT EXISTS `col_book_places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room` varchar(255) NOT NULL,
  `cupboard` varchar(255) NOT NULL,
  `shelf` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE IF NOT EXISTS `cb002_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_publisher` int(11) NOT NULL,  
  `binding` varchar(255) NOT NULL,
  `pages` int(11) DEFAULT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `format` varchar(255) DEFAULT NULL,  
  `language` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `id_place` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY ( `id_publisher` ) REFERENCES cb000_publishers( id ) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY ( `id_place` ) REFERENCES cb001_places( id ) ON DELETE CASCADE ON UPDATE CASCADE,
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
