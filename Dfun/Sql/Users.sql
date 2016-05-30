-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2016 年 5 月 23 日 13:04
-- サーバのバージョン: 5.5.49-0ubuntu0.14.04.1
-- PHP のバージョン: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
create database if not exists Users;
use Users;
--
-- データベース: `Users`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `ClassAttendTable`
--

CREATE TABLE IF NOT EXISTS `ClassAttendTable` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(10) NOT NULL COMMENT 'ユーザーID',
  `Date` date DEFAULT NULL COMMENT '出席日',
  `Time` int(16) DEFAULT NULL COMMENT '時限目（１〜５）',
  `Type` int(4) DEFAULT NULL COMMENT '出席：0 遅刻：1 欠席：2 就活：3 病欠：4',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `FaceTable`
--


CREATE TABLE IF NOT EXISTS `FaceTable` (
  `UserId` varchar(10) NOT NULL COMMENT 'ユーザーID',
  `imagePath` varchar(256) DEFAULT NULL COMMENT '顔面パス',
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `FaceTable`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `SchoolAttendTable`
--

CREATE TABLE IF NOT EXISTS `SchoolAttendTable` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(10) NOT NULL COMMENT 'ユーザーID',
  `Time` int(16) NOT NULL COMMENT '登下校時間（unixTime）',
  `Type` int(2) NOT NULL COMMENT '教師＝１、生徒＝０',
  `Checking` int(2) NOT NULL COMMENT '０＝登校、１＝下校、２＝異常下校',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=378 ;

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
(364, '0K01001', 1463360649, 1, 2),
(365, '0K01001', 279784392, 1, 2),
(366, 'teacher', 1463713374, 1, 2),
(367, 'teacher', 1463713393, 1, 1),
(368, '0K01001', 1463713787, 1, 2),
(369, '0K01001', 1463713798, 1, 1),
(370, '0K01001', 1463714316, 1, 2),
(371, '0K01001', 1463714611, 1, 1),
(372, '0K01001', 1463714807, 1, 2),
(373, '0K01001', 1463715971, 1, 1),
(374, '0K01001', 1463968829, 1, 2),
(375, '0K01001', 1463970765, 1, 1),
(376, '0K01001', 1463970843, 1, 2),
(377, '0K01001', 1463972282, 0, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `UserTable`
--

CREATE TABLE IF NOT EXISTS `UserTable` (
  `UserId` varchar(10) NOT NULL COMMENT 'ユーザーID',
  `Name` varchar(50) CHARACTER SET utf32 NOT NULL COMMENT '名前',
  `Type` int(11) NOT NULL COMMENT '教師＝１、生徒＝０',
  `Password` varchar(100) CHARACTER SET utf32 NOT NULL COMMENT 'パスワード',
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `UserTable`
--

INSERT INTO `UserTable` (`UserId`, `Name`, `Type`, `Password`) VALUES
('0K01001', 'aho', 0, '88fdd585121a4ccb3d1540527aee53a77c77abb8'),
('0K01002', '??T', 0, '88fdd585121a4ccb3d1540527aee53a77c77abb8'),
('0K01003', '川本T', 1, 'teacher'),
('0K01004', 'whi', 0, '52581d723bf830dc9128371e7e7f8bd579d78835'),
('teacher', 'teacher', 1, 'aaf8930c5b4dce6817281a6dd7d13363b8759743');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
