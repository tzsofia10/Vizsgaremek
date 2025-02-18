-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Feb 18. 08:31
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
(1, 'HU 30688 1202 2', 0, NULL, 2, '2013-01-16', NULL, 'HU 30688 0641 2', NULL, NULL),
(2, 'HU 30688 1209 1', 0, NULL, 3, '2013-02-19', NULL, 'HU 30688 0530 1', NULL, NULL),
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
(72, 'HU 35514 0120 5', 1, NULL, 1, '2024-03-22', NULL, 'HU 34314 0196 9', NULL, NULL);

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
(3, 'tehenek', 3, 'A tehenek', '<p>A tehenek az emberis&eacute;g t&ouml;rt&eacute;nelm&eacute;ben fontos szerepet j&aacute;tszottak, hiszen gazdas&aacute;gi, mezőgazdas&aacute;gi &eacute;s t&aacute;pl&aacute;lkoz&aacute;si szempontb&oacute;l kiemelkedő jelentős&eacute;gű &aacute;llatok. &Iacute;me n&eacute;h&aacute;ny &eacute;rdekes t&eacute;ny &eacute;s inform&aacute;ci&oacute; a tehenekről:</p>\r\n\r\n<p><em><strong>&Aacute;ltal&aacute;nos Jellemzők</strong></em></p>\r\n\r\n<p>- <strong>Biol&oacute;giai besorol&aacute;s:</strong></p>\r\n\r\n<p>A teh&eacute;n a szarvasmarha (Bos taurus) egyik egyede, amely emlős&aacute;llat &eacute;s a p&aacute;rosujj&uacute; pat&aacute;sok rendj&eacute;be tartozik. - **M&eacute;ret:** Egy &aacute;tlagos teh&eacute;n testt&ouml;mege 500&ndash;800 kg k&ouml;z&ouml;tt mozog, m&iacute;g a bik&aacute;k, vagyis a h&iacute;mek nagyobbak, ak&aacute;r 1 tonn&aacute;t is el&eacute;rhetnek. - **&Eacute;lettartam:** Tehenek &aacute;tlagosan 15-20 &eacute;vig &eacute;lnek, de a haszon&aacute;llatokn&aacute;l gyakran r&ouml;videbb az &eacute;letciklusuk. ### Szerep&uuml;k az Emberis&eacute;g Szolg&aacute;lat&aacute;ban 1. **Tejtermel&eacute;s:** - A tehenek teje fontos alapanyag a tejterm&eacute;kek, p&eacute;ld&aacute;ul a sajt, vaj &eacute;s joghurt elő&aacute;ll&iacute;t&aacute;s&aacute;hoz. Egy fejős teh&eacute;n napi tejtermel&eacute;se fajt&aacute;t&oacute;l f&uuml;ggően ak&aacute;r 25-30 liter is lehet. - A legismertebb tejelő fajta a Holstein-fr&iacute;z, amely nagy tejhozam&aacute;r&oacute;l h&iacute;res. 2. **H&uacute;s:** - A marhah&uacute;s sok kult&uacute;r&aacute;ban alapvető feh&eacute;rjeforr&aacute;s. A h&uacute;stermel&eacute;sben a h&uacute;stermelő fajt&aacute;k, p&eacute;ld&aacute;ul az Angus vagy a Hereford k&uuml;l&ouml;n&ouml;sen fontosak. 3. **Mezőgazdas&aacute;gi Munka:** - Hagyom&aacute;nyosan az &ouml;k&ouml;r, a kasztr&aacute;lt h&iacute;m szarvasmarha seg&iacute;tett a sz&aacute;nt&aacute;sban &eacute;s a neh&eacute;z terhek vontat&aacute;s&aacute;ban. 4. **Tr&aacute;gya:** - A teh&eacute;ntr&aacute;gya term&eacute;szetes műtr&aacute;gya, amelyet vil&aacute;gszerte haszn&aacute;lnak a mezőgazdas&aacute;gban. ### Viselked&eacute;s &eacute;s Intelligencia - A tehenek t&aacute;rsas &aacute;llatok, amelyek szoros kapcsolatot alak&iacute;tanak ki a csorda t&ouml;bbi tagj&aacute;val. - K&eacute;pesek megk&uuml;l&ouml;nb&ouml;ztetni egym&aacute;s hangj&aacute;t, sőt, az embereket is felismerik. - Sz&aacute;mos tanulm&aacute;ny bizony&iacute;totta, hogy a tehenek intelligensek, &eacute;s probl&eacute;mamegold&oacute; k&eacute;pess&eacute;geik vannak. ### Magyarorsz&aacute;gi Teh&eacute;ntart&aacute;s - Magyarorsz&aacute;gon a szarvasmarha-teny&eacute;szt&eacute;s hagyom&aacute;nyosan fontos &aacute;gazat. A hazai fajt&aacute;k k&ouml;z&uuml;l a magyar tarka &eacute;s a sz&uuml;rkemarha a legismertebbek. - A tehenek tart&aacute;sa az &aacute;llatteny&eacute;szt&eacute;si sz&ouml;vetkezetektől a csal&aacute;di gazdas&aacute;gokig terjed. ### &Eacute;rdekess&eacute;gek - Egy teh&eacute;n gyomra n&eacute;gy rekeszből &aacute;ll (bendő, rec&eacute;s, olt&oacute;, &eacute;s leveles), amelyek a k&eacute;rődz&eacute;s folyamat&aacute;ban vesznek r&eacute;szt. - A tehenek k&eacute;pesek &eacute;rz&eacute;kelni a F&ouml;ld m&aacute;gneses mezőj&eacute;t, &eacute;s legel&eacute;s k&ouml;zben &aacute;ltal&aacute;ban &eacute;szak-d&eacute;li ir&aacute;nyban helyezkednek el. Ha szeretn&eacute;l konkr&eacute;t t&eacute;m&aacute;t &eacute;rinteni, p&eacute;ld&aacute;ul a teh&eacute;ntart&aacute;st, teny&eacute;szt&eacute;st vagy egy&eacute;b gazdas&aacute;gi vonatkoz&aacute;sokat, sz&iacute;vesen &iacute;rok r&eacute;szletesebben is! ????</p>', 'farm.jpg', '2025-01-11 20:48:56', NULL, 'tehenek', 'tehenek', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

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
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
