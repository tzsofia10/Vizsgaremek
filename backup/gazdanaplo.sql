-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Már 04. 09:04
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `gazdanaplo`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `colors` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `colors`
--

INSERT INTO `colors` (`id`, `colors`) VALUES
(1, 'Black'),
(2, 'Brown'),
(3, 'White'),
(4, 'Spotted');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cows`
--

CREATE TABLE `cows` (
  `id` int(11) NOT NULL,
  `ear_tag` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `cows_parents_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `mother_ear_tag` varchar(255) DEFAULT NULL,
  `father_ear_tag` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `cows`
--

INSERT INTO `cows` (`id`, `ear_tag`, `gender`, `cows_parents_id`, `color_id`, `birthdate`, `death_date`, `mother_ear_tag`, `father_ear_tag`, `picture`) VALUES
(2, 'HU 30688 1209 1', 0, NULL, 2, '2013-02-19', NULL, 'HU 30688 0530 1', '', NULL),
(3, 'HU 30688 1210 9', 0, NULL, 3, '2013-02-19', NULL, 'HU 30688 0943 5', NULL, NULL),
(4, 'HU 30688 1213 0', 0, NULL, 3, '2013-03-17', NULL, 'HU 30688 0575 0', NULL, NULL),
(5, 'HU 30688 1223 1', 0, NULL, 3, '2013-03-19', NULL, 'HU 33000 0373 5', NULL, NULL),
(6, 'HU 30688 1224 8', 0, NULL, 3, '2013-03-20', NULL, 'HU 30688 0456 2', NULL, NULL),
(7, 'HU 30688 1235 6', 0, NULL, 3, '2013-04-27', NULL, 'HU 33000 0345 6', NULL, NULL),
(8, 'HU 30688 1237 0', 0, NULL, 3, '2013-05-02', NULL, 'HU 30688 0509 1', NULL, NULL),
(9, 'HU 30688 1238 7', 0, NULL, 3, '2013-05-15', NULL, 'HU 33000 0365 8', NULL, NULL),
(10, 'HU 30688 1240 2', 0, NULL, 3, '2013-05-20', NULL, 'HU 30688 0493 5', NULL, NULL),
(11, 'HU 30688 1420 6', 0, NULL, 3, '2014-07-02', NULL, 'HU 33000 0365 8', NULL, NULL),
(12, 'HU 30688 1421 3', 0, NULL, 3, '2014-07-02', NULL, 'HU 33000 0365 8', NULL, NULL),
(13, 'HU 30688 1475 6', 0, NULL, 3, '2015-03-01', NULL, 'HU 30688 0944 2', NULL, NULL),
(14, 'HU 30688 1491 0', 0, NULL, 3, '2015-03-17', NULL, 'HU 30688 0552 7', NULL, NULL),
(15, 'HU 30688 1496 5', 0, NULL, 3, '2015-03-21', NULL, 'HU 30688 0368 4', NULL, NULL),
(16, 'HU 30688 1508 3', 0, NULL, 3, '2015-04-02', NULL, 'HU 30688 0575 0', NULL, NULL),
(17, 'HU 30688 1640 4', 0, NULL, 3, '2016-03-10', NULL, 'HU 30688 0946 6', NULL, NULL),
(18, 'HU 30688 1646 6', 0, NULL, 3, '2016-03-16', NULL, 'HU 30015 5611 8', NULL, NULL),
(19, 'HU 30688 1665 1', 0, NULL, 3, '2016-04-07', NULL, 'HU 30688 0941 1', NULL, NULL),
(20, 'HU 30688 1698 5', 0, NULL, 3, '2016-05-19', NULL, 'HU 33000 0233 8', NULL, NULL),
(21, 'HU 30688 1748 3', 0, NULL, 3, '2016-06-26', NULL, 'HU 30688 1238 7', NULL, NULL),
(22, 'HU 30688 1978 2', 0, NULL, 3, '2018-03-10', NULL, 'HU 30688 0531 8', NULL, NULL),
(23, 'HU 30688 2419 7', 0, NULL, 3, '2020-03-15', NULL, 'HU 30688 1224 8', NULL, NULL),
(24, 'HU 30688 2428 1', 0, NULL, 1, '2020-03-16', NULL, 'HU 34314 0196 9', NULL, NULL),
(25, 'HU 30688 2435 1', 0, NULL, 3, '2020-03-24', NULL, 'HU 30688 1665 1', NULL, NULL),
(26, 'HU 30688 2463 0', 0, NULL, 3, '2020-04-02', NULL, 'HU 33000 0365 8', NULL, NULL),
(27, 'HU 30688 2464 7', 0, NULL, 1, '2020-04-22', NULL, 'HU 34314 0188 2', NULL, NULL),
(28, 'HU 30688 2466 1', 0, NULL, 3, '2020-04-06', NULL, 'HU 30688 0944 2', NULL, NULL),
(29, 'HU 30688 2471 7', 0, NULL, 3, '2020-04-25', NULL, 'HU 30688 0531 8', NULL, NULL),
(30, 'HU 30688 2526 0', 0, NULL, 3, '2020-04-28', NULL, 'HU 30688 1421 3', NULL, NULL),
(31, 'HU 30688 2529 1', 0, NULL, 1, '2020-05-15', NULL, 'HU 34314 0187 5', NULL, NULL),
(32, 'HU 35514 0090 9', 1, NULL, 3, '2024-03-10', NULL, 'HU 30688 1646 6', NULL, NULL),
(33, 'HU 35514 0102 7', 1, NULL, 3, '2024-03-13', NULL, 'HU 30688 1224 8', NULL, NULL),
(34, 'HU 35514 0108 9', 1, NULL, 2, '2024-03-15', NULL, 'HU 30688 1202 2', NULL, NULL),
(35, 'HU 35514 0113 5', 1, NULL, 1, '2024-03-16', NULL, 'HU 30688 2464 7', NULL, NULL),
(36, 'HU 35514 0120 5', 1, NULL, 1, '2024-03-22', NULL, 'HU 34314 0196 9', NULL, NULL),
(37, 'HU 30688 1202 2', 0, NULL, 2, '2013-01-16', NULL, 'HU 30688 0641 2', NULL, NULL),
(38, 'HU 30688 1209 1', 0, NULL, 3, '2013-02-19', NULL, 'HU 30688 0530 1', NULL, NULL),
(39, 'HU 30688 1210 9', 0, NULL, 3, '2013-02-19', NULL, 'HU 30688 0943 5', NULL, NULL),
(40, 'HU 30688 1213 0', 0, NULL, 3, '2013-03-17', NULL, 'HU 30688 0575 0', NULL, NULL),
(41, 'HU 30688 1223 1', 0, NULL, 3, '2013-03-19', NULL, 'HU 33000 0373 5', NULL, NULL),
(42, 'HU 30688 1224 8', 0, NULL, 3, '2013-03-20', NULL, 'HU 30688 0456 2', NULL, NULL),
(43, 'HU 30688 1235 6', 0, NULL, 3, '2013-04-27', NULL, 'HU 33000 0345 6', NULL, NULL),
(44, 'HU 30688 1237 0', 0, NULL, 3, '2013-05-02', NULL, 'HU 30688 0509 1', NULL, NULL),
(45, 'HU 30688 1238 7', 0, NULL, 3, '2013-05-15', NULL, 'HU 33000 0365 8', NULL, NULL),
(46, 'HU 30688 1240 2', 0, NULL, 3, '2013-05-20', NULL, 'HU 30688 0493 5', NULL, NULL),
(47, 'HU 30688 1420 6', 0, NULL, 3, '2014-07-02', NULL, 'HU 33000 0365 8', NULL, NULL),
(48, 'HU 30688 1421 3', 0, NULL, 3, '2014-07-02', NULL, 'HU 33000 0365 8', NULL, NULL),
(49, 'HU 30688 1475 6', 0, NULL, 3, '2015-03-01', NULL, 'HU 30688 0944 2', NULL, NULL),
(50, 'HU 30688 1491 0', 0, NULL, 3, '2015-03-17', NULL, 'HU 30688 0552 7', NULL, NULL),
(51, 'HU 30688 1496 5', 0, NULL, 3, '2015-03-21', NULL, 'HU 30688 0368 4', NULL, NULL),
(52, 'HU 30688 1508 3', 0, NULL, 3, '2015-04-02', NULL, 'HU 30688 0575 0', NULL, NULL),
(53, 'HU 30688 1640 4', 0, NULL, 3, '2016-03-10', NULL, 'HU 30688 0946 6', NULL, NULL),
(54, 'HU 30688 1646 6', 0, NULL, 3, '2016-03-16', NULL, 'HU 30015 5611 8', NULL, NULL),
(55, 'HU 30688 1665 1', 0, NULL, 3, '2016-04-07', NULL, 'HU 30688 0941 1', NULL, NULL),
(56, 'HU 30688 1698 5', 0, NULL, 3, '2016-05-19', NULL, 'HU 33000 0233 8', NULL, NULL),
(57, 'HU 30688 1748 3', 0, NULL, 3, '2016-06-26', NULL, 'HU 30688 1238 7', NULL, NULL),
(58, 'HU 30688 1978 2', 0, NULL, 3, '2018-03-10', NULL, 'HU 30688 0531 8', NULL, NULL),
(59, 'HU 30688 2419 7', 0, NULL, 3, '2020-03-15', NULL, 'HU 30688 1224 8', NULL, NULL),
(60, 'HU 30688 2428 1', 0, NULL, 1, '2020-03-16', NULL, 'HU 34314 0196 9', NULL, NULL),
(61, 'HU 30688 2435 1', 0, NULL, 3, '2020-03-24', NULL, 'HU 30688 1665 1', NULL, NULL),
(62, 'HU 30688 2463 0', 0, NULL, 3, '2020-04-02', NULL, 'HU 33000 0365 8', NULL, NULL),
(63, 'HU 30688 2464 7', 0, NULL, 1, '2020-04-22', NULL, 'HU 34314 0188 2', NULL, NULL),
(64, 'HU 30688 2466 1', 0, NULL, 3, '2020-04-06', NULL, 'HU 30688 0944 2', NULL, NULL),
(65, 'HU 30688 2471 7', 0, NULL, 3, '2020-04-25', NULL, 'HU 30688 0531 8', NULL, NULL),
(66, 'HU 30688 2526 0', 0, NULL, 3, '2020-04-28', NULL, 'HU 30688 1421 3', NULL, NULL),
(67, 'HU 30688 2529 1', 0, NULL, 1, '2020-05-15', NULL, 'HU 34314 0187 5', NULL, NULL),
(68, 'HU 35514 0090 9', 1, NULL, 3, '2024-03-10', NULL, 'HU 30688 1646 6', NULL, NULL),
(69, 'HU 35514 0102 7', 1, NULL, 3, '2024-03-13', NULL, 'HU 30688 1224 8', NULL, NULL),
(70, 'HU 35514 0108 9', 1, NULL, 2, '2024-03-15', NULL, 'HU 30688 1202 2', NULL, NULL),
(71, 'HU 35514 0113 5', 1, NULL, 1, '2024-03-16', NULL, 'HU 30688 2464 7', NULL, NULL),
(72, 'HU 35514 0120 5', 1, NULL, 1, '2024-03-22', NULL, 'HU 34314 0196 9', NULL, NULL),
(76, 'HU123460', 0, NULL, 2, '2025-02-07', '2025-02-07', 'HU123460', 'HU123460', 'uploads/4w18zQ_3(1).jpg'),
(77, 'HU123460', 0, NULL, 2, '2025-02-07', '2025-02-07', 'HU123460', 'HU123460', 'uploads/4w18zQ_3(1).jpg'),
(81, '12345ABC', 0, NULL, 2, '2023-01-01', NULL, '54321DEF', 'undefined', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cow_vaccinations`
--

CREATE TABLE `cow_vaccinations` (
  `id` int(11) NOT NULL,
  `cow_id` int(11) DEFAULT NULL,
  `vaccination_id` int(11) DEFAULT NULL,
  `vaccination_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `settlemets_id` int(11) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `house_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `news`
--

CREATE TABLE `news` (
  `id` tinyint(4) NOT NULL,
  `alias` varchar(32) DEFAULT NULL,
  `ordering` tinyint(4) DEFAULT NULL,
  `nav_name` varchar(32) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `creation` datetime DEFAULT NULL,
  `updating` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `states` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `news`
--

INSERT INTO `news` (`id`, `alias`, `ordering`, `nav_name`, `content`, `img`, `creation`, `updating`, `description`, `keywords`, `states`) VALUES
(1, 'bemutatkozas', 1, 'Ferkó Farm', '<p><strong>Term&eacute;szetk&ouml;zeli &eacute;s &Aacute;llatbar&aacute;t Gazd&aacute;lkod&aacute;s</strong></p>\r\n\r\n<p><strong><img alt=\"\" src=\"https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcSVLKD3NCrmKNdGPqKys4o3gEywhptKjSW79W7Dyz9PiTIxA0_7JaTy0cjPVAJzz73Q4ZiyadcO0gUcu9i32-ikVQ\" /></strong></p>\r\n\r\n<p>&Uuml;dv&ouml;z&ouml;lj&uuml;k a Ferk&oacute; Farmon, ahol a hagyom&aacute;ny &eacute;s az &aacute;llatj&oacute;l&eacute;t tal&aacute;lkozik! Gazdas&aacute;gunk 50 angus &eacute;s charolais teh&eacute;nből, valamint egy charolais bik&aacute;b&oacute;l &aacute;ll&oacute; &aacute;llom&aacute;nyt tart, melyeket rideg tart&aacute;sban, de &aacute;llatbar&aacute;t k&ouml;r&uuml;lm&eacute;nyek k&ouml;z&ouml;tt gondozunk. C&eacute;lunk, hogy kiv&aacute;l&oacute; minős&eacute;gű, eg&eacute;szs&eacute;ges &aacute;llatokat nevelj&uuml;nk, mik&ouml;zben tiszteletben tartjuk a term&eacute;szet adta lehetős&eacute;geket &eacute;s az &aacute;llatok sz&uuml;ks&eacute;gleteit. A Ferk&oacute; Farmon kiemelt figyelmet ford&iacute;tunk az &aacute;llatok j&oacute;ll&eacute;t&eacute;re: modern &aacute;llatj&oacute;l&eacute;ti l&eacute;tes&iacute;tm&eacute;nyeink biztos&iacute;tj&aacute;k a tehenek k&eacute;nyelm&eacute;t &eacute;s biztons&aacute;g&aacute;t minden időj&aacute;r&aacute;si k&ouml;r&uuml;lm&eacute;ny k&ouml;z&ouml;tt. &Aacute;llom&aacute;nyunkat rendszeresen &aacute;llatorvos ellenőrzi, &iacute;gy garant&aacute;lva az eg&eacute;szs&eacute;ges &eacute;s kiegyens&uacute;lyozott fejlőd&eacute;st. Farmunk szerves r&eacute;sze a fenntarthat&oacute; gazd&aacute;lkod&aacute;s: az &aacute;llatok term&eacute;szetes k&ouml;rnyezet&uuml;kben, stresszmentes k&ouml;r&uuml;lm&eacute;nyek k&ouml;z&ouml;tt nevelkednek, biztos&iacute;tva ezzel az eg&eacute;szs&eacute;ges h&uacute;s elő&aacute;ll&iacute;t&aacute;s&aacute;t. B&uuml;szk&eacute;k vagyunk arra, hogy olyan gazdas&aacute;got műk&ouml;dtet&uuml;nk, amely tiszteletben tartja az &aacute;llatok ig&eacute;nyeit, &eacute;s kiv&aacute;l&oacute; tart&aacute;si k&ouml;r&uuml;lm&eacute;nyeket biztos&iacute;t sz&aacute;mukra. L&aacute;togasson el hozz&aacute;nk, &eacute;s tapasztalja meg, mit jelent a felelős &aacute;llattart&aacute;s &eacute;s a term&eacute;szetk&ouml;zeli gazd&aacute;lkod&aacute;s! A Ferk&oacute; Farmon szeretettel v&aacute;rjuk &Ouml;nt!</p>', 'farm.jpg', '2025-01-11 20:25:07', NULL, 'A Ferkó Farm bemutatása', 'farm, tehenek, borjúk, bika, angusz, charolais', 1),
(3, 'tehenek', 3, 'A tehenek', '<p>A tehenek az emberis&eacute;g t&ouml;rt&eacute;nelm&eacute;ben fontos szerepet j&aacute;tszottak, hiszen gazdas&aacute;gi, mezőgazdas&aacute;gi &eacute;s t&aacute;pl&aacute;lkoz&aacute;si szempontb&oacute;l kiemelkedő jelentős&eacute;gű &aacute;llatok. &Iacute;me n&eacute;h&aacute;ny &eacute;rdekes t&eacute;ny &eacute;s inform&aacute;ci&oacute; a tehenekről:</p>\r\n\r\n<p><em><strong>&Aacute;ltal&aacute;nos Jellemzők</strong></em></p>\r\n\r\n<p>- <strong>Biol&oacute;giai besorol&aacute;s:</strong></p>\r\n\r\n<p>A teh&eacute;n a szarvasmarha (Bos taurus) egyik egyede, amely emlős&aacute;llat &eacute;s a p&aacute;rosujj&uacute; pat&aacute;sok rendj&eacute;be tartozik. - **M&eacute;ret:** Egy &aacute;tlagos teh&eacute;n testt&ouml;mege 500&ndash;800 kg k&ouml;z&ouml;tt mozog, m&iacute;g a bik&aacute;k, vagyis a h&iacute;mek nagyobbak, ak&aacute;r 1 tonn&aacute;t is el&eacute;rhetnek. - **&Eacute;lettartam:** Tehenek &aacute;tlagosan 15-20 &eacute;vig &eacute;lnek, de a haszon&aacute;llatokn&aacute;l gyakran r&ouml;videbb az &eacute;letciklusuk. ### Szerep&uuml;k az Emberis&eacute;g Szolg&aacute;lat&aacute;ban 1. **Tejtermel&eacute;s:** - A tehenek teje fontos alapanyag a tejterm&eacute;kek, p&eacute;ld&aacute;ul a sajt, vaj &eacute;s joghurt elő&aacute;ll&iacute;t&aacute;s&aacute;hoz. Egy fejős teh&eacute;n napi tejtermel&eacute;se fajt&aacute;t&oacute;l f&uuml;ggően ak&aacute;r 25-30 liter is lehet. - A legismertebb tejelő fajta a Holstein-fr&iacute;z, amely nagy tejhozam&aacute;r&oacute;l h&iacute;res. 2. **H&uacute;s:** - A marhah&uacute;s sok kult&uacute;r&aacute;ban alapvető feh&eacute;rjeforr&aacute;s. A h&uacute;stermel&eacute;sben a h&uacute;stermelő fajt&aacute;k, p&eacute;ld&aacute;ul az Angus vagy a Hereford k&uuml;l&ouml;n&ouml;sen fontosak. 3. **Mezőgazdas&aacute;gi Munka:** - Hagyom&aacute;nyosan az &ouml;k&ouml;r, a kasztr&aacute;lt h&iacute;m szarvasmarha seg&iacute;tett a sz&aacute;nt&aacute;sban &eacute;s a neh&eacute;z terhek vontat&aacute;s&aacute;ban. 4. **Tr&aacute;gya:** - A teh&eacute;ntr&aacute;gya term&eacute;szetes műtr&aacute;gya, amelyet vil&aacute;gszerte haszn&aacute;lnak a mezőgazdas&aacute;gban. ### Viselked&eacute;s &eacute;s Intelligencia - A tehenek t&aacute;rsas &aacute;llatok, amelyek szoros kapcsolatot alak&iacute;tanak ki a csorda t&ouml;bbi tagj&aacute;val. - K&eacute;pesek megk&uuml;l&ouml;nb&ouml;ztetni egym&aacute;s hangj&aacute;t, sőt, az embereket is felismerik. - Sz&aacute;mos tanulm&aacute;ny bizony&iacute;totta, hogy a tehenek intelligensek, &eacute;s probl&eacute;mamegold&oacute; k&eacute;pess&eacute;geik vannak. ### Magyarorsz&aacute;gi Teh&eacute;ntart&aacute;s - Magyarorsz&aacute;gon a szarvasmarha-teny&eacute;szt&eacute;s hagyom&aacute;nyosan fontos &aacute;gazat. A hazai fajt&aacute;k k&ouml;z&uuml;l a magyar tarka &eacute;s a sz&uuml;rkemarha a legismertebbek. - A tehenek tart&aacute;sa az &aacute;llatteny&eacute;szt&eacute;si sz&ouml;vetkezetektől a csal&aacute;di gazdas&aacute;gokig terjed. ### &Eacute;rdekess&eacute;gek - Egy teh&eacute;n gyomra n&eacute;gy rekeszből &aacute;ll (bendő, rec&eacute;s, olt&oacute;, &eacute;s leveles), amelyek a k&eacute;rődz&eacute;s folyamat&aacute;ban vesznek r&eacute;szt. - A tehenek k&eacute;pesek &eacute;rz&eacute;kelni a F&ouml;ld m&aacute;gneses mezőj&eacute;t, &eacute;s legel&eacute;s k&ouml;zben &aacute;ltal&aacute;ban &eacute;szak-d&eacute;li ir&aacute;nyban helyezkednek el. Ha szeretn&eacute;l konkr&eacute;t t&eacute;m&aacute;t &eacute;rinteni, p&eacute;ld&aacute;ul a teh&eacute;ntart&aacute;st, teny&eacute;szt&eacute;st vagy egy&eacute;b gazdas&aacute;gi vonatkoz&aacute;sokat, sz&iacute;vesen &iacute;rok r&eacute;szletesebben is! ????</p>', 'farm.jpg', '2025-01-11 20:48:56', NULL, 'tehenek', 'tehenek', 1),
(4, 'balatakarok', 4, 'Bálatakarók', '<p><strong>Bálatakarók használata a gazdaságban</strong></p><p>A családi gazdaságunkban kiemelten fontosnak tartjuk, hogy szarvasmarháink számára a lehető legjobb minőségű takarmányt biztosítsuk. Az állatok egészsége és teljesítménye szoros összefüggésben áll azzal, hogy milyen tápanyagokhoz jutnak hozzá, ezért kiemelt figyelmet fordítunk a széna és szalma megfelelő tárolására. Ennek érdekében idén 3 új bálatakarót szereztünk be, amely jelentősen hozzájárul a takarmány minőségének megőrzéséhez.</p><p>A hagyományos műanyag fóliák és ponyvák gyakran csapdába ejtik a nedvességet, ami penészedéshez és minőségromláshoz vezethet. A Ferkó Gazdaságban kiemelten fontos, hogy az etetésre szánt takarmány friss és tápanyagban gazdag maradjon, ezért olyan megoldást kerestünk, amely védi a bálákat az időjárás viszontagságaitól, ugyanakkor biztosítja a megfelelő szellőzést.</p><p>A beszerzett zöld lélegző bálatakaró éppen ezt a célt szolgálja. Vízlepergető, UV-álló és légáteresztő, így a bálák védve vannak az esőtől és a túlzott napsugárzástól, miközben a pára távozni tud belőlük. Ez megakadályozza a befülledést és a gombásodást, amely különösen a téli takarmányozási időszakban jelentene komoly problémát.</p><p>A jószágok jóléte és teljesítménye elsődleges szempont, ezért minden olyan technológiai fejlesztést és korszerűsítést támogatunk, amely segít az állatállomány megfelelő táplálásában. A lélegző bálatakaróval biztosak lehetünk abban, hogy a téli hónapokban is kiváló minőségű takarmányhoz jutnak szarvasmarháink, így egészségesek és produktívak maradnak.</p><p>A jövőben is törekszünk arra, hogy olyan modern megoldásokat vezessünk be, amelyek a fenntartható gazdálkodást és az állatok jólétét szolgálják. Az új bálatakaró beszerzése csak egy lépés ezen az úton, de már most látható, hogy jelentős előnyökkel jár a gazdaság és az állatok számára egyaránt.</p>', 'balatakarok.jpg', '2025-02-24 11:44:51', NULL, 'Bálatakarók a Ferkó Farmon', 'bálatakaró, takarmány, szarvasmarha, gazdálkodás', 1),
(5, 'uj-bika', 1, 'Új Charolais Tenyészbika került ', '<p>A Ferk&oacute; Gazdas&aacute;g ism&eacute;t fontos l&eacute;p&eacute;st tett a szarvasmarha-&aacute;llom&aacute;ny fejleszt&eacute;se &eacute;rdek&eacute;ben: &uacute;j Charolais teny&eacute;szbik&aacute;t szerezt&uuml;nk be a J&aacute;szd&oacute;zsai gazdas&aacute;gb&oacute;l, amely m&eacute;lt&aacute;n h&iacute;res kiv&aacute;l&oacute; genetikai h&aacute;tterű &aacute;llatair&oacute;l. A j&aacute;szd&oacute;zsai teny&eacute;szet &eacute;vek &oacute;ta kimagasl&oacute; eredm&eacute;nyeket &eacute;r el k&uuml;l&ouml;nf&eacute;le mezőgazdas&aacute;gi &eacute;s teny&eacute;sz&aacute;llat-ki&aacute;ll&iacute;t&aacute;sokon, ahol Charolais bik&aacute;ik t&ouml;bb d&iacute;jat is nyertek.</p>\r\n\r\n<p>A teny&eacute;szbika kiv&aacute;laszt&aacute;sakor sok gazdas&aacute;g a lehető legnagyobb, legrobosztusabb &aacute;llatot keresi, mi m&aacute;s megk&ouml;zel&iacute;t&eacute;st alkalmazunk. Sz&aacute;munkra az egyik legfontosabb c&eacute;l az, hogy az Angus &eacute;s Charolais tehenek k&ouml;nnyen, komplik&aacute;ci&oacute;mentesen vil&aacute;gra tudj&aacute;k hozni borjaikat.</p>\r\n\r\n<p>Ezt a c&eacute;lt azzal biztos&iacute;thatjuk, ha nem a legnagyobb testű, neh&eacute;z csontozat&uacute; bik&aacute;t v&aacute;lasztjuk, hanem egy olyan egyedet, amely kev&eacute;sb&eacute; robosztus testfel&eacute;p&iacute;t&eacute;sű, ami megk&ouml;nny&iacute;ti a borjak vil&aacute;gra j&ouml;tt&eacute;t, de ugyanakkor kiv&aacute;l&oacute; genetikai h&aacute;tt&eacute;rrel rendelkezik, biztos&iacute;tva a j&ouml;vőbeli &aacute;llom&aacute;ny eg&eacute;szs&eacute;g&eacute;t &eacute;s termel&eacute;kenys&eacute;g&eacute;t.</p>\r\n\r\n<p>A szarvasmarha-teny&eacute;szt&eacute;s egyik legkritikusabb szakasza az ell&eacute;s. A neh&eacute;zell&eacute;s nemcsak az &aacute;llatok eg&eacute;szs&eacute;g&eacute;t vesz&eacute;lyezteti, hanem komoly &aacute;llateg&eacute;szs&eacute;g&uuml;gyi beavatkoz&aacute;sokat is ig&eacute;nyelhet, ami hossz&uacute; t&aacute;von stresszt &eacute;s gazdas&aacute;gi vesztes&eacute;geket okozhat.</p>\r\n\r\n<p>Az &uacute;j teny&eacute;szbika &eacute;ppen ez&eacute;rt nem csup&aacute;n a k&uuml;llem&eacute;vel, hanem &ouml;r&ouml;k&iacute;thető tulajdons&aacute;gaival is hozz&aacute;j&aacute;rul ahhoz, hogy a Ferk&oacute; Gazdas&aacute;g &aacute;llat&aacute;llom&aacute;nya eg&eacute;szs&eacute;gesebb &eacute;s probl&eacute;mamentesebb legyen.</p>\r\n\r\n<p>A k&ouml;vetkező h&oacute;napokban figyelemmel k&iacute;s&eacute;rj&uuml;k, hogyan illeszkedik be az &uacute;j Charolais teny&eacute;szbika az &aacute;llom&aacute;nyba, &eacute;s b&iacute;zunk benne, hogy hamarosan eg&eacute;szs&eacute;ges &eacute;s kiv&aacute;l&oacute; genetikai adotts&aacute;gokkal rendelkező borjak sz&uuml;letnek tőle.</p>', NULL, '2025-02-24 11:59:21', NULL, 'Új Charolais Tenyészbika került idén is beszerzésre', 'Charolais, szarvasmarha, Charolais tenyészbika, gazdasági hatékonyság', 1),
(6, 'biogazdalkodas', 4, 'Biogazdálkodás', '<p><strong>A Ferkó Gazdaság csatlakozott a Biogazdálkodási Programhoz</strong></p>\r\n<p>Az utóbbi években egyre nagyobb figyelmet kap Magyarországon a fenntartható mezőgazdaság és a biogazdálkodás, amely nemcsak a környezet védelmét, hanem az egészségesebb élelmiszerek előállítását is szolgálja. A Ferkó Gazdaság mindig is elkötelezett volt az innováció és a fenntartható fejlődés iránt, ezért csatlakozott az országos biogazdálkodási programhoz, amely néhány éve indult el hazánkban.</p>\r\n<p>A modern mezőgazdasági technológiák gyakran intenzív vegyszerhasználattal és ipari termelési módszerekkel járnak, amelyek hosszú távon kimeríthetik a talajt és csökkenthetik az élelmiszerek természetes minőségét. A Ferkó Gazdaság célja viszont az, hogy:</p>\r\n<ul>\r\n<li>Vegyszermentesen termesszünk takarmánynövényeket és gondozzuk állatállományunkat.</li>\r\n<li>Hosszú távon fenntartható módszereket alkalmazzunk, amelyek megőrzik a föld termőképességét.</li>\r\n<li>Természetes, egészségesebb élelmiszereket biztosítsunk a fogyasztók számára.</li>\r\n</ul>\r\n<p>A programhoz való csatlakozás egy átfogó átállási folyamatot jelentett számunkra. A biogazdálkodásra való áttérés szigorú ellenőrzési és tanúsítási folyamatot igényelt, amely biztosítja, hogy minden előírásnak megfelelően, valóban ökológiai módon gazdálkodjunk.</p>\r\n<p><strong>A biogazdálkodási program részeként bevezetett új szabályok és módszerek:</strong></p>\r\n<ol>\r\n<li><strong>Vegyszermentes földművelés</strong> – Nem használunk műtrágyát vagy szintetikus növényvédő szereket, helyette természetes trágyázási és növényvédelem technológiákat alkalmazunk.</li>\r\n<li><strong>Természetes állattartás</strong> – Az állatok takarmányozása ökológiai termesztésű takarmányból történik, és nagyobb figyelmet fordítunk a jóléti előírásokra.</li>\r\n<li><strong>Talajmegőrzési technikák</strong> – Vetésforgót, zöldtrágyázást és komposztálást alkalmazunk a talaj termőképességének hosszú távú megőrzése érdekében.</li>\r\n<li><strong>Fenntartható gazdálkodási eszközök</strong> – Minimalizáljuk a gépi beavatkozást, csökkentve a szén-dioxid-kibocsátást és az eróziót.</li>\r\n</ol>\r\n<p>A Ferkó Gazdaság számára ez az átállás egy új korszak kezdetét jelenti, amelyben a természetes termelési folyamatokat és az egészséges állattartást helyezzük előtérbe. Célunk, hogy hosszú távon is példát mutassunk, és bebizonyítsuk, hogy a fenntartható mezőgazdaság nemcsak környezetbarát, hanem gazdaságilag is életképes megoldás.</p>', 'farm.jpg', '2025-02-25 08:20:24', NULL, 'A Ferkó Gazdaság biogazdálkodási programhoz csatlakozása', 'biogazdálkodás, fenntarthatóság, természetes termelés', 1),
(7, 'szuletesszabalyozas', 5, 'Születésszabályozás', '<p><strong>Születésszabályozás a Ferkó Gazdaságban</strong></p>\r\n<p>A Ferkó Gazdaságban a szarvasmarha-tenyésztés egyik legfontosabb stratégiai eleme a születések megfelelő időzítése. Nem mindegy, hogy a borjak melyik évszakban születnek, hiszen az időjárási körülmények közvetlen hatással vannak a borjak túlélési esélyeire, különösen ridegtartás esetén.</p>\r\n<p>A téli hónapok, különösen január és február, rendkívül zordak lehetnek, erős fagyokkal és csapadékkal. A ridegtartásban tartott állatok esetében ez kiemelkedően magas kockázatot jelent a borjak számára.</p>\r\n<ul>\r\n<li>❄ <strong>Erős fagy és hideg szél</strong> – A frissen született borjak hőháztartása még nem stabil, így a nagy hidegben könnyen kihűlhetnek, különösen, ha az ellés után nem tudnak azonnal megszáradni.</li>\r\n<li>❄ <strong>Nedves, csapadékos időjárás</strong> – A szél és a hó kombinációja tovább rontja a túlélési esélyeket. A legyengült borjak nehezebben állnak lábra, és fertőzésveszélynek is jobban ki vannak téve.</li>\r\n<li>❄ <strong>Korlátozott takarmányellátás</strong> – A téli időszakban a tehenek nem jutnak friss legelőhöz, ami hatással lehet a tejtermelésükre, és így az újszülött borjak fejlődésére is.</li>\r\n</ul>\r\n<p>A Ferkó Gazdaságban tudatos szaporítási stratégiával szabályozzuk a borjak világra jövetelét. Ennek érdekében:</p>\r\n<ul>\r\n<li>🐂 <strong>A tenyészbikát májusban helyezzük ki</strong> a tehenekhez, hogy az első fedezések a melegebb hónapokban történjenek.</li>\r\n<li>🐂 <strong>Ősszel, szeptember-októberben a bikát behajtjuk</strong> és elkülönítjük, ezzel biztosítva, hogy az ellések ne tolódjanak ki a téli időszakra.</li>\r\n<li>🐂 <strong>Célunk a február végi, március eleji születések</strong>, amikor az időjárás már kellemesebb, enyhébb, így a borjak könnyebben alkalmazkodnak a környezethez.</li>\r\n</ul>\r\n<p><strong>A megfelelő időzítés előnyei:</strong></p>\r\n<ul>\r\n<li>✔ <strong>Kisebb borjúelhullás</strong> – A tavaszi születésű borjak jobb túlélési eséllyel indulnak, mivel az időjárás kedvezőbb.</li>\r\n<li>✔ <strong>Erősebb fejlődés</strong> – A márciusi borjak korábban kikerülhetnek a friss legelőkre, így hamarabb erősödnek és gyorsabb növekedési ütemet érnek el.</li>\r\n<li>✔ <strong>Kevesebb egészségügyi kockázat</strong> – Az enyhébb időben az ellések kevesebb komplikációval járnak, és a borjak könnyebben szopnak és mozgékonyabbak.</li>\r\n</ul>\r\n<p>A születési időszak tudatos szabályozása nem csupán az állatok jólétére van hatással, hanem gazdasági szempontból is előnyös. Egy jól időzített borjúnevelési ciklus hatékonyabb tartást és jobb piaci értékesítést eredményez, hiszen a tavaszi születésű borjak megfelelő kondícióban érik el a választási kort.</p>\r\n<p>A Ferkó Gazdaság tehát továbbra is ragaszkodik a tenyésztési ciklus gondos megtervezéséhez, amely garantálja, hogy az állomány egészséges maradjon, a borjak erőteljes fejlődést mutassanak, és a gazdaság fenntartható módon működhessen a jövőben is.</p>', 'calf.jpg', '2025-02-25 08:26:46', NULL, 'A Ferkó Gazdaság születésszabályozási stratégiája', 'szarvasmarha, születésszabályozás, állattenyésztés', 1),
(8, 'uj-borjak-erkezese', 4, 'Új Borjak Érkezése', '<p>A borjak sz&uuml;let&eacute;se a gazdas&aacute;g sz&aacute;m&aacute;ra mindig &ouml;r&ouml;mteli esem&eacute;ny, ugyanakkor sz&aacute;mos kih&iacute;v&aacute;st is rejt mag&aacute;ban. A sz&uuml;let&eacute;sszab&aacute;lyoz&aacute;snak k&ouml;sz&ouml;nhetően a tehenek gyakran febru&aacute;r v&eacute;g&eacute;től kezdenek elleni, &eacute;s b&aacute;r az ell&eacute;sek t&ouml;bbs&eacute;ge z&ouml;kkenőmentes, előfordulhat, hogy az &uacute;jsz&uuml;l&ouml;tt nem tud azonnal szopni az anyj&aacute;t&oacute;l. Ilyenkor a megfelelő elők&eacute;sz&uuml;letek &eacute;s az azonnali beavatkoz&aacute;s kulcsfontoss&aacute;g&uacute; az &eacute;letben marad&aacute;s &eacute;s a borj&uacute; eg&eacute;szs&eacute;ges fejlőd&eacute;se szempontj&aacute;b&oacute;l. Az anyatej első cseppje, a kolosztrum, olyan t&aacute;panyagokat &eacute;s immunol&oacute;giai &ouml;sszetevőket tartalmaz, amelyek elengedhetetlenek az &uacute;jsz&uuml;l&ouml;tt v&eacute;delm&eacute;hez &eacute;s n&ouml;veked&eacute;s&eacute;hez. Az ide&aacute;lis időablak az első 8&ndash;12 &oacute;ra, amikor a borj&uacute; szervezete a legfog&eacute;konyabb az immunanyagok felsz&iacute;v&aacute;s&aacute;ra. Ha ez az időszak elmarad, a fertőz&eacute;sekkel &eacute;s egy&eacute;b eg&eacute;szs&eacute;g&uuml;gyi komplik&aacute;ci&oacute;kkal szembeni v&eacute;delem jelentősen cs&ouml;kken, ami ak&aacute;r a hal&aacute;loz&aacute;shoz is vezethet. &Eacute;ppen ez&eacute;rt rendk&iacute;v&uuml;l fontos, hogy mindig legyen k&eacute;zn&eacute;l magas minős&eacute;gű, kolosztrum tartalm&uacute; tejpor, melyet nagyobb kiszerel&eacute;sben szok&aacute;s beszerezni, &iacute;gy felk&eacute;sz&uuml;lve arra az esetre, ha az anyatej nem &eacute;rhető el vagy iker ell&eacute;s eset&eacute;n sz&uuml;ks&eacute;g van a kieg&eacute;sz&iacute;t&eacute;sre. A piacon el&eacute;rhető sz&aacute;mos tejport&iacute;pus k&ouml;z&uuml;l a minős&eacute;g a legfontosabb szempont. A legmegb&iacute;zhat&oacute;bb m&aacute;rk&aacute;k biztos&iacute;tj&aacute;k azt a t&aacute;p&eacute;rt&eacute;ket, amely n&eacute;lk&uuml;l&ouml;zhetetlen az &uacute;jsz&uuml;l&ouml;tt borj&uacute; sz&aacute;m&aacute;ra. B&aacute;r ezek a pr&eacute;mium term&eacute;kek magasabb &aacute;ron &eacute;rhetők el, hossz&uacute; t&aacute;von a borj&uacute; t&uacute;l&eacute;l&eacute;s&eacute;t &eacute;s eg&eacute;szs&eacute;ges fejlőd&eacute;s&eacute;t tekintve megfizethetetlen &eacute;rt&eacute;ket k&eacute;pviselnek. Sp&oacute;rolni ilyenkor nem &eacute;rdemes, hiszen a nem megfelelő t&aacute;pszer az &eacute;letvesz&eacute;lyes komplik&aacute;ci&oacute;k egyik fő oka lehet. Az ell&eacute;s sor&aacute;n felmer&uuml;lő v&aacute;ratlan esem&eacute;nyekre is fel kell k&eacute;sz&uuml;ln&uuml;nk. Az egyik ilyen kulcsfontoss&aacute;g&uacute; int&eacute;zked&eacute;s a kalcium injekci&oacute;k beszerz&eacute;se. A kalcium szerepe kiemelkedően fontos a tehenek regener&aacute;ci&oacute;j&aacute;ban, k&uuml;l&ouml;n&ouml;sen akkor, ha az ell&eacute;s sor&aacute;n b&aacute;rmelyik anya megs&eacute;r&uuml;l, vagy hirtelen kalciumhi&aacute;ny alakul ki. &Eacute;ppen ez&eacute;rt a gazdas&aacute;g rakt&aacute;r&aacute;ban mindig legyenek k&eacute;szleten kalcium injekci&oacute;k, hogy sz&uuml;ks&eacute;g eset&eacute;n azonnal beavatkozhassunk. Ezen fel&uuml;l rendelkez&uuml;nk fertőtlen&iacute;tőszerekkel &eacute;s sebtapaszokkal is. Az ell&eacute;s ut&aacute;ni higi&eacute;niai int&eacute;zked&eacute;sek elengedhetetlenek a fertőz&eacute;sek megelőz&eacute;se &eacute;rdek&eacute;ben. Az ell&eacute;s sor&aacute;n a k&ouml;r&uuml;ltekintő fel&uuml;gyelet seg&iacute;t a korai beavatkoz&aacute;sban, ha b&aacute;rmilyen komplik&aacute;ci&oacute; ad&oacute;dna. Rendszeresen konzult&aacute;lunk a gazdas&aacute;g &aacute;llatorvos&aacute;val, aki biztos&iacute;tja sz&aacute;munka, hogy az alkalmazott m&oacute;dszereik megfeleljenek a leg&uacute;jabb szakmai ir&aacute;nyelveknek. A borjak eg&eacute;szs&eacute;ges &eacute;rkez&eacute;se nem csup&aacute;n az anyatejhez jut&aacute;s k&eacute;rd&eacute;se, hanem az &aacute;tfog&oacute;, j&oacute;l megtervezett elők&eacute;sz&uuml;letek eredm&eacute;nye. A legjobb minős&eacute;gű kolosztrum tartalm&uacute; tejpor, a sz&uuml;ks&eacute;ges higi&eacute;niai eszk&ouml;z&ouml;k, valamint a rakt&aacute;ron tartott kalcium injekci&oacute;k mind hozz&aacute;j&aacute;rulnak ahhoz, hogy az ell&eacute;s &eacute;s az &uacute;jsz&uuml;l&ouml;ttek ell&aacute;t&aacute;sa z&ouml;kkenőmentes legyen. A gondos elők&eacute;sz&uuml;letek seg&iacute;tenek megőrizni a gazdas&aacute;g siker&eacute;t &eacute;s biztos&iacute;tj&aacute;k, hogy a legfiatalabb gener&aacute;ci&oacute;k a lehető legjobb ell&aacute;t&aacute;sban r&eacute;szes&uuml;ljenek. Egy j&oacute;l szervezett ell&eacute;si folyamat hossz&uacute; t&aacute;von is megt&eacute;r&uuml;l, hiszen az eg&eacute;szs&eacute;ges borjak biztos&iacute;tj&aacute;k a gazdas&aacute;g j&ouml;vőj&eacute;t. Mindig a leg&uacute;jabb tudom&aacute;nyos eredm&eacute;nyeket &eacute;s szakmai tan&aacute;csokat igyeksz&uuml;nk k&ouml;vetni, hogy a lehető legoptim&aacute;lisabb k&ouml;r&uuml;lm&eacute;nyeket teremts&uuml;k meg az &uacute;j &eacute;let kezdet&eacute;hez.&nbsp;</p>', 'kolstrum.jpg', '2025-02-25 08:43:24', NULL, 'Az újszülött borjak egészséges fejlődésének támogatása kolosztrummal', 'borjak, kolosztrum, állattenyésztés, farm', 1),
(11, 'uj-borjak-erkezese', 9, 'Új Borjak Érkezése', '<p>A borjak sz&uuml;let&eacute;se a gazdas&aacute;g sz&aacute;m&aacute;ra mindig &ouml;r&ouml;mteli esem&eacute;ny, ugyanakkor sz&aacute;mos kih&iacute;v&aacute;st is rejt mag&aacute;ban. A sz&uuml;let&eacute;sszab&aacute;lyoz&aacute;snak k&ouml;sz&ouml;nhetően a tehenek gyakran febru&aacute;r v&eacute;g&eacute;től kezdenek elleni, &eacute;s b&aacute;r az ell&eacute;sek t&ouml;bbs&eacute;ge z&ouml;kkenőmentes, előfordulhat, hogy az &uacute;jsz&uuml;l&ouml;tt nem tud azonnal szopni az anyj&aacute;t&oacute;l. Ilyenkor a megfelelő elők&eacute;sz&uuml;letek &eacute;s az azonnali beavatkoz&aacute;s kulcsfontoss&aacute;g&uacute; az &eacute;letben marad&aacute;s &eacute;s a borj&uacute; eg&eacute;szs&eacute;ges fejlőd&eacute;se szempontj&aacute;b&oacute;l.</p>\r\n\r\n<p>Az anyatej első cseppje, a kolosztrum, olyan t&aacute;panyagokat &eacute;s immunol&oacute;giai &ouml;sszetevőket tartalmaz, amelyek elengedhetetlenek az &uacute;jsz&uuml;l&ouml;tt v&eacute;delm&eacute;hez &eacute;s n&ouml;veked&eacute;s&eacute;hez. Az ide&aacute;lis időablak az első 8&ndash;12 &oacute;ra, amikor a borj&uacute; szervezete a legfog&eacute;konyabb az immunanyagok felsz&iacute;v&aacute;s&aacute;ra. Ha ez az időszak elmarad, a fertőz&eacute;sekkel &eacute;s egy&eacute;b eg&eacute;szs&eacute;g&uuml;gyi komplik&aacute;ci&oacute;kkal szembeni v&eacute;delem jelentősen cs&ouml;kken, ami ak&aacute;r a hal&aacute;loz&aacute;shoz is vezethet. &Eacute;ppen ez&eacute;rt rendk&iacute;v&uuml;l fontos, hogy mindig legyen k&eacute;zn&eacute;l magas minős&eacute;gű, kolosztrum tartalm&uacute; tejpor, melyet nagyobb kiszerel&eacute;sben szok&aacute;s beszerezni, &iacute;gy felk&eacute;sz&uuml;lve arra az esetre, ha az anyatej nem &eacute;rhető el vagy iker ell&eacute;s eset&eacute;n sz&uuml;ks&eacute;g van a kieg&eacute;sz&iacute;t&eacute;sre.</p>\r\n\r\n<p>A piacon el&eacute;rhető sz&aacute;mos tejport&iacute;pus k&ouml;z&uuml;l a minős&eacute;g a legfontosabb szempont. A legmegb&iacute;zhat&oacute;bb m&aacute;rk&aacute;k biztos&iacute;tj&aacute;k azt a t&aacute;p&eacute;rt&eacute;ket, amely n&eacute;lk&uuml;l&ouml;zhetetlen az &uacute;jsz&uuml;l&ouml;tt borj&uacute; sz&aacute;m&aacute;ra. B&aacute;r ezek a pr&eacute;mium term&eacute;kek magasabb &aacute;ron &eacute;rhetők el, hossz&uacute; t&aacute;von a borj&uacute; t&uacute;l&eacute;l&eacute;s&eacute;t &eacute;s eg&eacute;szs&eacute;ges fejlőd&eacute;s&eacute;t tekintve megfizethetetlen &eacute;rt&eacute;ket k&eacute;pviselnek. Sp&oacute;rolni ilyenkor nem &eacute;rdemes, hiszen a nem megfelelő t&aacute;pszer az &eacute;letvesz&eacute;lyes komplik&aacute;ci&oacute;k egyik fő oka lehet.</p>\r\n\r\n<p>Az ell&eacute;s sor&aacute;n felmer&uuml;lő v&aacute;ratlan esem&eacute;nyekre is fel kell k&eacute;sz&uuml;ln&uuml;nk. Az egyik ilyen kulcsfontoss&aacute;g&uacute; int&eacute;zked&eacute;s a kalcium injekci&oacute;k beszerz&eacute;se. A kalcium szerepe kiemelkedően fontos a tehenek regener&aacute;ci&oacute;j&aacute;ban, k&uuml;l&ouml;n&ouml;sen akkor, ha az ell&eacute;s sor&aacute;n b&aacute;rmelyik anya megs&eacute;r&uuml;l, vagy hirtelen kalciumhi&aacute;ny alakul ki. &Eacute;ppen ez&eacute;rt a gazdas&aacute;g rakt&aacute;r&aacute;ban mindig legyenek k&eacute;szleten kalcium injekci&oacute;k, hogy sz&uuml;ks&eacute;g eset&eacute;n azonnal beavatkozhassunk.</p>\r\n\r\n<p>Ezen fel&uuml;l rendelkez&uuml;nk fertőtlen&iacute;tőszerekkel &eacute;s sebtapaszokkal is. Az ell&eacute;s ut&aacute;ni higi&eacute;niai int&eacute;zked&eacute;sek elengedhetetlenek a fertőz&eacute;sek megelőz&eacute;se &eacute;rdek&eacute;ben. Az ell&eacute;s sor&aacute;n a k&ouml;r&uuml;ltekintő fel&uuml;gyelet seg&iacute;t a korai beavatkoz&aacute;sban, ha b&aacute;rmilyen komplik&aacute;ci&oacute; ad&oacute;dna. Rendszeresen konzult&aacute;lunk a gazdas&aacute;g &aacute;llatorvos&aacute;val, aki biztos&iacute;tja sz&aacute;munka, hogy az alkalmazott m&oacute;dszereik megfeleljenek a leg&uacute;jabb szakmai ir&aacute;nyelveknek.</p>\r\n\r\n<p>A borjak eg&eacute;szs&eacute;ges &eacute;rkez&eacute;se nem csup&aacute;n az anyatejhez jut&aacute;s k&eacute;rd&eacute;se, hanem az &aacute;tfog&oacute;, j&oacute;l megtervezett elők&eacute;sz&uuml;letek eredm&eacute;nye. A legjobb minős&eacute;gű kolosztrum tartalm&uacute; tejpor, a sz&uuml;ks&eacute;ges higi&eacute;niai eszk&ouml;z&ouml;k, valamint a rakt&aacute;ron tartott kalcium injekci&oacute;k mind hozz&aacute;j&aacute;rulnak ahhoz, hogy az ell&eacute;s &eacute;s az &uacute;jsz&uuml;l&ouml;ttek ell&aacute;t&aacute;sa z&ouml;kkenőmentes legyen. A gondos elők&eacute;sz&uuml;letek seg&iacute;tenek megőrizni a gazdas&aacute;g siker&eacute;t &eacute;s biztos&iacute;tj&aacute;k, hogy a legfiatalabb gener&aacute;ci&oacute;k a lehető legjobb ell&aacute;t&aacute;sban r&eacute;szes&uuml;ljenek.</p>\r\n\r\n<p>Egy j&oacute;l szervezett ell&eacute;si folyamat hossz&uacute; t&aacute;von is megt&eacute;r&uuml;l, hiszen az eg&eacute;szs&eacute;ges borjak biztos&iacute;tj&aacute;k a gazdas&aacute;g j&ouml;vőj&eacute;t. Mindig a leg&uacute;jabb tudom&aacute;nyos eredm&eacute;nyeket &eacute;s szakmai tan&aacute;csokat igyeksz&uuml;nk k&ouml;vetni, hogy a lehető legoptim&aacute;lisabb k&ouml;r&uuml;lm&eacute;nyeket teremts&uuml;k meg az &uacute;j &eacute;let kezdet&eacute;hez.</p>', 'kolstrum.jpg', '2025-02-25 08:53:09', NULL, 'Az újszülött borjak egészséges', 'borjak, kolosztrum, állattenyésztés, farm', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `cow_id` int(11) DEFAULT NULL,
  `sellers_id` int(11) DEFAULT NULL,
  `sales_date` date DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `settlements`
--

CREATE TABLE `settlements` (
  `id` int(11) NOT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `register_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `register_date`) VALUES
(1, NULL, '$2y$10$v2VbZPJ2xzFWiO2j8I8X5ek.afUOSh1AhAdp1mBalQatuuxptNTJ.', 'gyula@gmail.com', '2025-01-11');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vaccination_types`
--

CREATE TABLE `vaccination_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cows`
--
ALTER TABLE `cows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `color_id` (`color_id`);

--
-- A tábla indexei `cow_vaccinations`
--
ALTER TABLE `cow_vaccinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cow_id` (`cow_id`),
  ADD KEY `vaccination_id` (`vaccination_id`);

--
-- A tábla indexei `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settlemets_id` (`settlemets_id`);

--
-- A tábla indexei `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cow_id` (`cow_id`),
  ADD KEY `sellers_id` (`sellers_id`);

--
-- A tábla indexei `settlements`
--
ALTER TABLE `settlements`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `vaccination_types`
--
ALTER TABLE `vaccination_types`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `cows`
--
ALTER TABLE `cows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT a táblához `cow_vaccinations`
--
ALTER TABLE `cow_vaccinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `news`
--
ALTER TABLE `news`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT a táblához `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `settlements`
--
ALTER TABLE `settlements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `vaccination_types`
--
ALTER TABLE `vaccination_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `cows`
--
ALTER TABLE `cows`
  ADD CONSTRAINT `cows_ibfk_1` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE SET NULL;

--
-- Megkötések a táblához `cow_vaccinations`
--
ALTER TABLE `cow_vaccinations`
  ADD CONSTRAINT `cow_vaccinations_ibfk_1` FOREIGN KEY (`cow_id`) REFERENCES `cows` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cow_vaccinations_ibfk_2` FOREIGN KEY (`vaccination_id`) REFERENCES `vaccination_types` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`settlemets_id`) REFERENCES `settlements` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`cow_id`) REFERENCES `cows` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`sellers_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
