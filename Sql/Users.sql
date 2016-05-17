-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2016 年 5 月 16 日 14:35
-- サーバのバージョン: 5.5.49-0ubuntu0.14.04.1
-- PHP のバージョン: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
drop database if exists Users;
create database Users;
use Users;
--
-- データベース: `Users`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `ClassAttendTable`
--

CREATE TABLE IF NOT EXISTS `ClassAttendTable` (
  `UserId` varchar(20) NOT NULL,
  `Date` date DEFAULT NULL,
  `Time` int(16) DEFAULT NULL,
  `Type` int(4) DEFAULT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- テーブルの構造 `FaceTable`
--

CREATE TABLE IF NOT EXISTS `FaceTable` (
  `UserId` varchar(20) NOT NULL,
  `imagePath` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `FaceTable`
--

INSERT INTO `FaceTable` (`UserId`, `imagePath`) VALUES
('teacher', '1');

-- --------------------------------------------------------

--
-- テーブルの構造 `loginTime`
--

CREATE TABLE IF NOT EXISTS `loginTime` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(8) DEFAULT NULL,
  `loginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `SchoolAttendTable`
--

CREATE TABLE IF NOT EXISTS `SchoolAttendTable` (
  `Id` int(8) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(8) NOT NULL,
  `Time` int(16) NOT NULL,
  `Type` int(2) NOT NULL,
  `Checking` int(2) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=365 ;

--
-- テーブルのデータのダンプ `SchoolAttendTable`
--

INSERT INTO `SchoolAttendTable` (`Id`, `UserId`, `Time`, `Type`, `Checking`) VALUES
(322, '0k01001', 12563718, 1, 2),
(323, '0K01001', 1463027607, 1, 2),
(324, '0K01001', 1463027607, 1, 2),
(325, '0K01001', 1463031922, 1, 0),
(326, '0K01001', 1463031979, 1, 2),
(327, '0K01001', 1463032088, 1, 2),
(328, '0K01001', 1463032113, 1, 0),
(329, '0K01001', 1463032161, 1, 2),
(330, '0K01001', 1463032181, 1, 0),
(331, '0K01001', 1463358847, 1, 2),
(332, '0K01001', 1463358870, 1, 0),
(333, '0K01001', 1463359048, 1, 2),
(334, '0K01001', 1463359066, 1, 0),
(335, '0K01001', 1463359106, 1, 2),
(336, '0K01001', 1463359133, 1, 0),
(337, '0K01001', 1463359144, 1, 2),
(338, '0K01001', 1463359248, 1, 0),
(339, '0K01001', 1463359271, 1, 2),
(340, '0K01001', 1463359298, 1, 0),
(341, '0K01001', 1463359388, 1, 2),
(342, '0K01001', 1463359564, 1, 0),
(343, '0K01001', 1463359581, 1, 2),
(344, '0K01001', 1463359611, 1, 0),
(345, '0K01002', 2147483647, 1, 2),
(346, '0K01002', 2147483647, 2, 1),
(347, '0K01001', 1463359772, 1, 2),
(348, '0K01001', 1463359783, 1, 0),
(349, '0K01001', 1463359815, 1, 2),
(350, '0K01001', 1463359825, 1, 0),
(351, '0K01002', 2147483647, 2, 1),
(352, '0K01001', 1463359881, 1, 2),
(353, '0K01001', 1463359893, 1, 0),
(354, '0K01001', 1463360012, 1, 2),
(355, '0K01001', 1463360022, 1, 0),
(356, '0K01001', 1463360106, 1, 2),
(357, '0K01001', 1463360118, 1, 0),
(358, '0K01001', 1463360140, 1, 2),
(359, '0K01001', 1463360150, 1, 0),
(360, '0K01001', 1463360357, 1, 2),
(361, '0K01001', 1463360369, 1, 1),
(362, '0K01001', 1463360391, 1, 2),
(363, '0K01001', 1463360556, 1, 2),
(364, '0K01001', 1463360649, 1, 2);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザID',
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ユーザ名',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'メールアドレス',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'パスワード',
  `role` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL COMMENT '登録日時',
  `modified` datetime NOT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ユーザデータ' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `UserTable`
--

CREATE TABLE IF NOT EXISTS `UserTable` (
  `UserId` varchar(16) NOT NULL,
  `Name` varchar(16) NOT NULL,
  `Type` int(8) NOT NULL,
  `Password` varchar(10) NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `UserTable`
--

INSERT INTO `UserTable` (`UserId`, `Name`, `Type`, `Password`) VALUES
('0K01001', 'aho', 0, '0K01001'),
('teacher', 'teacher', 1, 'teacher');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
