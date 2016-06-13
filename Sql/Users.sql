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
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(10) NOT NULL COMMENT 'ユーザーID',
  `Date` date DEFAULT NULL COMMENT '出席日',
  `Time` int(16) DEFAULT NULL COMMENT '時限目（１〜５）',
  `Type` int(4) DEFAULT NULL COMMENT '出席：0 遅刻：1 欠席：2 就活：3 病欠：4 登校前:8',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--
-- -- --------------------------------------------------------
--
-- --
-- -- テーブルの構造 `FaceTable`
-- --
--
--
CREATE TABLE IF NOT EXISTS `FaceTable` (
  `UserId` varchar(10) NOT NULL COMMENT 'ユーザーID',
  `imagePath` varchar(256) DEFAULT NULL COMMENT '顔面パス',
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --
-- -- テーブルのデータのダンプ `FaceTable`
-- --
--
-- -- --------------------------------------------------------
--
-- --
-- -- テーブルの構造 `SchoolAttendTable`
-- --
--
CREATE TABLE IF NOT EXISTS `SchoolAttendTable` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` varchar(10) NOT NULL COMMENT 'ユーザーID',
  `Time` int(16) NOT NULL COMMENT '登下校時間（unixTime）',
  `Type` int(2) NOT NULL COMMENT '教師＝１、生徒＝０',
  `Checking` int(2) NOT NULL COMMENT '０＝登校、１＝下校、２＝異常下校',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
--
-- --
-- テーブルのデータのダンプ `SchoolAttendTable`
--
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

INSERT INTO `UserTable` (`UserId`, `Name`, `Type`, `Password`) VALUES
("0K01001","秋月",0,SHA1("0K01001")),
("0K1002","芥川　周平",0,SHA1("0K01002")),
("0K1003","円佛　直也",0,SHA1("0K01003")),
("0K1004","古曵　昌俊",0,SHA1("0K01004")),
("0K1005","佐々木　涼太",0,SHA1("0K01005")),
("0K1006","多田　涼太",0,SHA1("0K01006")),
("0K1007","土田　昇平",0,SHA1("0K01007")),
("0K1008","寺口　悟司",0,SHA1("0K01008")),
("0K1009","土居　幸太郎",0,SHA1("0K01009")),
("0K1010","栂野　仁志",0,SHA1("0K01010")),
("0K1011","土肥　侑平",0,SHA1("0K01011")),
("0K1012","長谷川　遼",0,SHA1("0K01012")),
("0K1013","藤井　貴之",0,SHA1("0K01013")),
("0K1014","前田　貴大",0,SHA1("0K01014")),
("0K1015","増澤　優駿",0,SHA1("0K010015")),
("0K1016","松本　祐樹",0,SHA1("0K010016")),
("0K1017","村井　亮哉",0,SHA1("0K010017")),
("0K1018","森本　大佑",0,SHA1("0K010018")),
("0K1019","山口　大貴",0,SHA1("0K010019")),
("0K1020","山中　竣介",0,SHA1("0K010020")),
("0K1021","吉田　朋広",0,SHA1("0K010021")),
("0K1022","川西　望未",0,SHA1("0K010022"));
--
--
CREATE TABLE IF NOT EXISTS `SchoolDayTable` (
  `ident` int NOT NULL AUTO_INCREMENT,
  `Date` DATE NOT NULL COMMENT '20**-**-**',
  `Week` int NOT NULL COMMENT '曜日（0~6））',
  `SchoolDay` int NOT NULL COMMENT '教師＝１、生徒＝０',
  `SchoolStartTime` int NOT NULL COMMENT '０＝登校、１＝下校、２＝異常下校',
  `SchoolEndTime` int NOT NULL COMMENT '０＝登校、１＝下校、２＝異常下校',
  PRIMARY KEY (`ident`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `UserTable`
