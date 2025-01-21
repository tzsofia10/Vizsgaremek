-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Jan 13. 09:14
-- Kiszolgáló verziója: 10.4.27-MariaDB
-- PHP verzió: 8.2.0

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
-- Tábla szerkezet ehhez a táblához `cms_news`
--

CREATE TABLE `cms_news` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `alias` varchar(32) DEFAULT NULL,
  `ordering` tinyint(3) UNSIGNED NOT NULL,
  `nav_name` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `creation` datetime NOT NULL,
  `updating` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `states` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `cms_news`
--

INSERT INTO `cms_news` (`id`, `alias`, `ordering`, `nav_name`, `content`, `img`, `creation`, `updating`, `description`, `keywords`, `states`) VALUES
(1, 'bemutatkozas', 1, 'Ferkó Farm', '<p><strong>Term&eacute;szetk&ouml;zeli &eacute;s &Aacute;llatbar&aacute;t Gazd&aacute;lkod&aacute;s</strong></p>\r\n\r\n<p><strong><img alt=\"\" src=\"https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcSVLKD3NCrmKNdGPqKys4o3gEywhptKjSW79W7Dyz9PiTIxA0_7JaTy0cjPVAJzz73Q4ZiyadcO0gUcu9i32-ikVQ\" /></strong></p>\r\n\r\n<p>&Uuml;dv&ouml;z&ouml;lj&uuml;k a Ferk&oacute; Farmon, ahol a hagyom&aacute;ny &eacute;s az &aacute;llatj&oacute;l&eacute;t tal&aacute;lkozik! Gazdas&aacute;gunk 50 angus &eacute;s charolais teh&eacute;nből, valamint egy charolais bik&aacute;b&oacute;l &aacute;ll&oacute; &aacute;llom&aacute;nyt tart, melyeket rideg tart&aacute;sban, de &aacute;llatbar&aacute;t k&ouml;r&uuml;lm&eacute;nyek k&ouml;z&ouml;tt gondozunk. C&eacute;lunk, hogy kiv&aacute;l&oacute; minős&eacute;gű, eg&eacute;szs&eacute;ges &aacute;llatokat nevelj&uuml;nk, mik&ouml;zben tiszteletben tartjuk a term&eacute;szet adta lehetős&eacute;geket &eacute;s az &aacute;llatok sz&uuml;ks&eacute;gleteit. A Ferk&oacute; Farmon kiemelt figyelmet ford&iacute;tunk az &aacute;llatok j&oacute;ll&eacute;t&eacute;re: modern &aacute;llatj&oacute;l&eacute;ti l&eacute;tes&iacute;tm&eacute;nyeink biztos&iacute;tj&aacute;k a tehenek k&eacute;nyelm&eacute;t &eacute;s biztons&aacute;g&aacute;t minden időj&aacute;r&aacute;si k&ouml;r&uuml;lm&eacute;ny k&ouml;z&ouml;tt. &Aacute;llom&aacute;nyunkat rendszeresen &aacute;llatorvos ellenőrzi, &iacute;gy garant&aacute;lva az eg&eacute;szs&eacute;ges &eacute;s kiegyens&uacute;lyozott fejlőd&eacute;st. Farmunk szerves r&eacute;sze a fenntarthat&oacute; gazd&aacute;lkod&aacute;s: az &aacute;llatok term&eacute;szetes k&ouml;rnyezet&uuml;kben, stresszmentes k&ouml;r&uuml;lm&eacute;nyek k&ouml;z&ouml;tt nevelkednek, biztos&iacute;tva ezzel az eg&eacute;szs&eacute;ges h&uacute;s elő&aacute;ll&iacute;t&aacute;s&aacute;t. B&uuml;szk&eacute;k vagyunk arra, hogy olyan gazdas&aacute;got műk&ouml;dtet&uuml;nk, amely tiszteletben tartja az &aacute;llatok ig&eacute;nyeit, &eacute;s kiv&aacute;l&oacute; tart&aacute;si k&ouml;r&uuml;lm&eacute;nyeket biztos&iacute;t sz&aacute;mukra. L&aacute;togasson el hozz&aacute;nk, &eacute;s tapasztalja meg, mit jelent a felelős &aacute;llattart&aacute;s &eacute;s a term&eacute;szetk&ouml;zeli gazd&aacute;lkod&aacute;s! A Ferk&oacute; Farmon szeretettel v&aacute;rjuk &Ouml;nt!</p>', 'farm.jpg', '2025-01-11 20:25:07', NULL, 'A Ferkó Farm bemutatása', 'farm, tehenek, borjúk, bika, angusz, charolais', 1),
(3, 'tehenek', 3, 'A tehenek', '<p>A tehenek az emberis&eacute;g t&ouml;rt&eacute;nelm&eacute;ben fontos szerepet j&aacute;tszottak, hiszen gazdas&aacute;gi, mezőgazdas&aacute;gi &eacute;s t&aacute;pl&aacute;lkoz&aacute;si szempontb&oacute;l kiemelkedő jelentős&eacute;gű &aacute;llatok. &Iacute;me n&eacute;h&aacute;ny &eacute;rdekes t&eacute;ny &eacute;s inform&aacute;ci&oacute; a tehenekről:</p>\r\n\r\n<p><em><strong>&Aacute;ltal&aacute;nos Jellemzők</strong></em></p>\r\n\r\n<p>- <strong>Biol&oacute;giai besorol&aacute;s:</strong></p>\r\n\r\n<p>A teh&eacute;n a szarvasmarha (Bos taurus) egyik egyede, amely emlős&aacute;llat &eacute;s a p&aacute;rosujj&uacute; pat&aacute;sok rendj&eacute;be tartozik. - **M&eacute;ret:** Egy &aacute;tlagos teh&eacute;n testt&ouml;mege 500&ndash;800 kg k&ouml;z&ouml;tt mozog, m&iacute;g a bik&aacute;k, vagyis a h&iacute;mek nagyobbak, ak&aacute;r 1 tonn&aacute;t is el&eacute;rhetnek. - **&Eacute;lettartam:** Tehenek &aacute;tlagosan 15-20 &eacute;vig &eacute;lnek, de a haszon&aacute;llatokn&aacute;l gyakran r&ouml;videbb az &eacute;letciklusuk. ### Szerep&uuml;k az Emberis&eacute;g Szolg&aacute;lat&aacute;ban 1. **Tejtermel&eacute;s:** - A tehenek teje fontos alapanyag a tejterm&eacute;kek, p&eacute;ld&aacute;ul a sajt, vaj &eacute;s joghurt elő&aacute;ll&iacute;t&aacute;s&aacute;hoz. Egy fejős teh&eacute;n napi tejtermel&eacute;se fajt&aacute;t&oacute;l f&uuml;ggően ak&aacute;r 25-30 liter is lehet. - A legismertebb tejelő fajta a Holstein-fr&iacute;z, amely nagy tejhozam&aacute;r&oacute;l h&iacute;res. 2. **H&uacute;s:** - A marhah&uacute;s sok kult&uacute;r&aacute;ban alapvető feh&eacute;rjeforr&aacute;s. A h&uacute;stermel&eacute;sben a h&uacute;stermelő fajt&aacute;k, p&eacute;ld&aacute;ul az Angus vagy a Hereford k&uuml;l&ouml;n&ouml;sen fontosak. 3. **Mezőgazdas&aacute;gi Munka:** - Hagyom&aacute;nyosan az &ouml;k&ouml;r, a kasztr&aacute;lt h&iacute;m szarvasmarha seg&iacute;tett a sz&aacute;nt&aacute;sban &eacute;s a neh&eacute;z terhek vontat&aacute;s&aacute;ban. 4. **Tr&aacute;gya:** - A teh&eacute;ntr&aacute;gya term&eacute;szetes műtr&aacute;gya, amelyet vil&aacute;gszerte haszn&aacute;lnak a mezőgazdas&aacute;gban. ### Viselked&eacute;s &eacute;s Intelligencia - A tehenek t&aacute;rsas &aacute;llatok, amelyek szoros kapcsolatot alak&iacute;tanak ki a csorda t&ouml;bbi tagj&aacute;val. - K&eacute;pesek megk&uuml;l&ouml;nb&ouml;ztetni egym&aacute;s hangj&aacute;t, sőt, az embereket is felismerik. - Sz&aacute;mos tanulm&aacute;ny bizony&iacute;totta, hogy a tehenek intelligensek, &eacute;s probl&eacute;mamegold&oacute; k&eacute;pess&eacute;geik vannak. ### Magyarorsz&aacute;gi Teh&eacute;ntart&aacute;s - Magyarorsz&aacute;gon a szarvasmarha-teny&eacute;szt&eacute;s hagyom&aacute;nyosan fontos &aacute;gazat. A hazai fajt&aacute;k k&ouml;z&uuml;l a magyar tarka &eacute;s a sz&uuml;rkemarha a legismertebbek. - A tehenek tart&aacute;sa az &aacute;llatteny&eacute;szt&eacute;si sz&ouml;vetkezetektől a csal&aacute;di gazdas&aacute;gokig terjed. ### &Eacute;rdekess&eacute;gek - Egy teh&eacute;n gyomra n&eacute;gy rekeszből &aacute;ll (bendő, rec&eacute;s, olt&oacute;, &eacute;s leveles), amelyek a k&eacute;rődz&eacute;s folyamat&aacute;ban vesznek r&eacute;szt. - A tehenek k&eacute;pesek &eacute;rz&eacute;kelni a F&ouml;ld m&aacute;gneses mezőj&eacute;t, &eacute;s legel&eacute;s k&ouml;zben &aacute;ltal&aacute;ban &eacute;szak-d&eacute;li ir&aacute;nyban helyezkednek el. Ha szeretn&eacute;l konkr&eacute;t t&eacute;m&aacute;t &eacute;rinteni, p&eacute;ld&aacute;ul a teh&eacute;ntart&aacute;st, teny&eacute;szt&eacute;st vagy egy&eacute;b gazdas&aacute;gi vonatkoz&aacute;sokat, sz&iacute;vesen &iacute;rok r&eacute;szletesebben is! ????</p>', 'farm.jpg', '2025-01-11 20:48:56', NULL, 'tehenek', 'tehenek', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `black` varchar(255) DEFAULT NULL,
  `brown` varchar(255) DEFAULT NULL,
  `white` varchar(255) DEFAULT NULL,
  `spotted` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `colors`
--

INSERT INTO `colors` (`id`, `black`, `brown`, `white`, `spotted`) VALUES
(1, 'Black', NULL, NULL, NULL),
(2, NULL, 'Brown', NULL, NULL),
(3, NULL, NULL, 'White', NULL),
(4, NULL, NULL, NULL, 'Spotted');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cows`
--

CREATE TABLE `cows` (
  `id` int(11) NOT NULL,
  `ear_tag` varchar(255) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `mother_ear_tag` varchar(255) DEFAULT NULL,
  `father_ear_tag` varchar(255) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `vaccination_id` int(11) DEFAULT NULL,
  `birth_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `cows`
--

INSERT INTO `cows` (`id`, `ear_tag`, `gender`, `mother_ear_tag`, `father_ear_tag`, `color_id`, `vaccination_id`, `birth_date`) VALUES
(1, 'HU123460', 'M', 'HU123457', 'HU123458', 2, NULL, '2023-10-01'),
(2, 'HU123461', 'F', 'HU123459', 'HU123458', 1, NULL, '2023-11-01'),
(3, 'HU123462', 'M', 'HU123456', 'HU123457', 2, NULL, '2023-12-01'),
(4, 'HU123463', 'F', 'HU123459', 'HU123456', 1, NULL, '2024-01-01');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `death`
--

CREATE TABLE `death` (
  `id` int(11) NOT NULL,
  `cows_id` int(11) DEFAULT NULL,
  `death_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `cow_id` int(11) DEFAULT NULL,
  `sellers_id` int(11) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

CREATE TABLE `user` (
  `id` tinyint(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `date_time`) VALUES
(1, 'gyula@gmail.com', '$2y$10$v2VbZPJ2xzFWiO2j8I8X5ek.afUOSh1AhAdp1mBalQatuuxptNTJ.', '2025-01-11');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vaccination_types`
--

CREATE TABLE `vaccination_types` (
  `id` int(11) NOT NULL,
  `cows_id` int(11) DEFAULT NULL,
  `vaccination_name` varchar(255) DEFAULT NULL,
  `vaccination_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `cms_news`
--
ALTER TABLE `cms_news`
  ADD PRIMARY KEY (`id`);

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
-- A tábla indexei `death`
--
ALTER TABLE `death`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cows_id` (`cows_id`);

--
-- A tábla indexei `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cow_id` (`cow_id`),
  ADD KEY `sellers_id` (`sellers_id`);

--
-- A tábla indexei `sellers`
--
ALTER TABLE `sellers`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `cows_id` (`cows_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `cms_news`
--
ALTER TABLE `cms_news`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `cows`
--
ALTER TABLE `cows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `death`
--
ALTER TABLE `death`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `id` tinyint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `cows_ibfk_1` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`);

--
-- Megkötések a táblához `death`
--
ALTER TABLE `death`
  ADD CONSTRAINT `death_ibfk_1` FOREIGN KEY (`cows_id`) REFERENCES `cows` (`id`);

--
-- Megkötések a táblához `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`cow_id`) REFERENCES `cows` (`id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`sellers_id`) REFERENCES `sellers` (`id`);

--
-- Megkötések a táblához `vaccination_types`
--
ALTER TABLE `vaccination_types`
  ADD CONSTRAINT `vaccination_types_ibfk_1` FOREIGN KEY (`cows_id`) REFERENCES `cows` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
