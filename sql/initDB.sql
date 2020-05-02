SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `login` varchar(15) NOT NULL,
  `password` varchar(150) NOT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `admin` (`login`, `password`) VALUES
('hilderic', '$2y$10$uHK2t5KH4nbIe7KLhxUpauucS9/TZRHTFddbCcInK1YeWl0yOTpzS'),
('tim', '$2y$10$kG6cQ.oI3KbP0139qtppSOnXrJw6g1kyySXwwCEWDoa2C2/xz54wi');


DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Site` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `SiteName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Title` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` blob NOT NULL,
  `Url` blob NOT NULL,
  `UrlWebsite` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Site` (`id_Site`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `sites`;
CREATE TABLE IF NOT EXISTS `sites` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `fluxURL` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


INSERT INTO `sites` (`ID`, `name`, `fluxURL`) VALUES
(2, 'JeuxVideo.com', 'http://www.jeuxvideo.com/rss/rss.xml');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
