-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Júl 05. 13:24
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `szakdolgozat`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `guests`
--

CREATE TABLE `guests` (
  `guest_id` int(255) NOT NULL,
  `guest_first_name` varchar(255) NOT NULL,
  `guest_last_name` varchar(255) NOT NULL,
  `guest_residence` varchar(255) NOT NULL,
  `guest_email` varchar(255) NOT NULL,
  `guest_phone` varchar(255) NOT NULL,
  `guest_birth_date` date NOT NULL,
  `guest_sex` enum('Férfi','Nő','','') NOT NULL,
  `guest_photo` varchar(255) NOT NULL,
  `guest_card_id` varchar(6) NOT NULL,
  `guest_register_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `guests`
--

INSERT INTO `guests` (`guest_id`, `guest_first_name`, `guest_last_name`, `guest_residence`, `guest_email`, `guest_phone`, `guest_birth_date`, `guest_sex`, `guest_photo`, `guest_card_id`, `guest_register_time`) VALUES
(2, 'Elek', 'Teszt', 'Győr', 'wasd@gmail.com', '06302246561', '2006-01-01', 'Férfi', '2_1782659116.jpg', 'G00001', '2026-06-20 16:25:07'),
(3, 'Teszt', '123', '', '', '', '0000-00-00', 'Férfi', '1783248540_f4ce7aeca24858cfb8c04fd8bc144f2e.jpg', 'G00004', '2026-07-05 10:49:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `keys_`
--

CREATE TABLE `keys_` (
  `keys_id` int(255) NOT NULL,
  `key_number` varchar(6) NOT NULL,
  `guest_card_id` varchar(255) NOT NULL,
  `issued_at` datetime NOT NULL,
  `returned_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `keys_`
--

INSERT INTO `keys_` (`keys_id`, `key_number`, `guest_card_id`, `issued_at`, `returned_at`) VALUES
(1, 'K001', '0', '2026-06-20 18:21:32', '2026-06-20 16:21:08'),
(2, 'K001', '0', '2026-06-20 18:26:51', '2026-06-20 16:26:51'),
(3, 'K001', '0', '2026-06-20 18:34:30', '2026-06-20 16:34:30'),
(4, 'K001', '0', '2026-06-20 18:39:01', '2026-06-20 16:39:01'),
(5, 'K001', '0', '2026-06-20 20:22:14', '2026-06-20 18:22:14'),
(7, '', 'G00001', '2026-06-27 14:32:49', '2026-06-20 18:32:08'),
(8, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-20 18:32:18'),
(9, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 10:08:10'),
(10, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 10:19:07'),
(11, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 10:36:46'),
(12, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 10:41:20'),
(13, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 11:57:58'),
(14, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 11:58:35'),
(15, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 12:13:41'),
(16, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 12:21:50'),
(17, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 12:22:08'),
(18, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 12:22:10'),
(19, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 12:22:13'),
(28, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 12:54:39'),
(29, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 12:54:53'),
(30, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 12:55:27'),
(31, '', 'G00001', '2026-06-27 14:32:49', '2026-06-21 13:04:07'),
(32, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 13:08:19'),
(33, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 13:08:29'),
(34, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 13:33:18'),
(35, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 13:49:24'),
(36, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 13:49:24'),
(37, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 13:51:22'),
(38, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 13:54:08'),
(39, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 13:56:21'),
(40, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 13:56:26'),
(41, '', 'G00001', '2026-06-27 14:32:49', '2026-06-21 14:05:09'),
(42, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 14:05:56'),
(43, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-21 14:07:26'),
(44, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-27 10:47:53'),
(45, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-27 10:54:57'),
(46, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-27 10:55:39'),
(47, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-27 10:56:01'),
(48, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-27 10:57:30'),
(49, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-27 12:15:07'),
(50, '', '', '2026-06-27 14:15:02', NULL),
(51, '', 'G00001', '2026-06-27 14:32:49', '2026-06-27 12:15:18'),
(52, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-27 12:32:07'),
(53, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-27 12:32:44'),
(54, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-27 12:32:47'),
(55, 'K001', 'G00001', '2026-06-27 14:32:49', '2026-06-27 12:32:50');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity_type` varchar(20) NOT NULL,
  `storage` varchar(15) NOT NULL,
  `quantity` mediumint(7) NOT NULL,
  `scoop_volume` tinyint(255) NOT NULL,
  `quantity_price` mediumint(6) NOT NULL,
  `product_number` varchar(6) NOT NULL,
  `product_photo` varchar(255) DEFAULT NULL,
  `indicator_set` mediumint(7) NOT NULL,
  `minimum_order_qty` mediumint(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `products`
--

INSERT INTO `products` (`id`, `manufacturer`, `name`, `quantity_type`, `storage`, `quantity`, `scoop_volume`, `quantity_price`, `product_number`, `product_photo`, `indicator_set`, `minimum_order_qty`) VALUES
(1, 'Teszt', 'Iso Whey Zero', 'gramm', 'T01-01', 691, 30, 15, 'P00001', '1_1782662511.jpg', 454, 454),
(2, 'Teszt', 'Creatine Monohydrate', 'gramm', 'T01-01', 985, 5, 120, 'P00002', NULL, 200, 200);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `product_guest`
--

CREATE TABLE `product_guest` (
  `id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `guest_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(255) NOT NULL,
  `reason` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `product_guest`
--

INSERT INTO `product_guest` (`id`, `product_id`, `guest_id`, `user_id`, `timestamp`, `quantity`, `reason`) VALUES
(1, 1, 2, 1, '2026-07-05 09:38:38', 30, 'fogyás'),
(2, 1, 2, 1, '2026-07-05 09:58:06', 20, 'fogyás'),
(3, 1, 2, 1, '2026-07-05 10:01:10', 100, 'fogyás'),
(4, 1, 2, 1, '2026-07-05 10:10:07', 30, 'fogyás'),
(5, 1, 0, 1, '2026-07-05 10:18:55', 1, 'bevétel'),
(6, 1, 0, 1, '2026-07-05 10:21:54', 1, 'korrekc'),
(7, 1, 0, 1, '2026-07-05 10:24:49', 1, 'selejte'),
(8, 1, 0, 1, '2026-07-05 10:27:05', 1, 'selejte'),
(9, 1, 0, 1, '2026-07-05 10:28:39', 1, 'selejte'),
(10, 1, 0, 1, '2026-07-05 10:31:00', 1, 'Selejte'),
(11, 1, 0, 1, '2026-07-05 10:32:05', 1, 'fogyás'),
(12, 1, 0, 1, '2026-07-05 10:33:10', 1, 'Leltár'),
(13, 1, 0, 1, '2026-07-05 10:33:24', 1, 'Selejt'),
(14, 1, 0, 1, '2026-07-05 10:36:01', 454, 'bevétel'),
(15, 2, 2, 1, '2026-07-05 10:56:52', 5, 'fogyás'),
(16, 1, 2, 1, '2026-07-05 11:10:17', 0, 'fogyás'),
(17, 1, 2, 1, '2026-07-05 11:10:50', 30, 'fogyás'),
(18, 2, 2, 1, '2026-07-05 11:14:32', 0, 'fogyás'),
(19, 2, 2, 1, '2026-07-05 11:15:00', 10, 'fogyás');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `services`
--

CREATE TABLE `services` (
  `service_id` int(255) NOT NULL,
  `service_price` int(7) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `valid_days` smallint(3) DEFAULT NULL,
  `max_entries` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `services`
--

INSERT INTO `services` (`service_id`, `service_price`, `service_name`, `valid_days`, `max_entries`) VALUES
(1, 3500, 'Napi jegy', 1, 1),
(2, 22000, 'Havi bérlet korlátlan', 31, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `service_guest`
--

CREATE TABLE `service_guest` (
  `id` int(255) NOT NULL,
  `guest_id` int(255) NOT NULL,
  `service_id` int(255) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_date` datetime DEFAULT NULL,
  `service_entries` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `service_guest`
--

INSERT INTO `service_guest` (`id`, `guest_id`, `service_id`, `start_date`, `end_date`, `service_entries`) VALUES
(1, 0, 1, '2026-06-19 22:00:00', '2026-06-21 00:00:00', NULL),
(2, 0, 1, '2026-06-19 22:00:00', '2026-06-21 00:00:00', NULL),
(3, 0, 1, '2026-06-19 22:00:00', '2026-06-21 00:00:00', NULL),
(4, 0, 1, '2026-06-19 22:00:00', '2026-06-21 00:00:00', NULL),
(5, 2, 1, '2026-06-20 22:00:00', '2026-06-22 00:00:00', 0),
(6, 2, 1, '2026-06-20 22:00:00', '2026-06-22 00:00:00', 0),
(7, 2, 1, '2026-06-20 22:00:00', '2026-06-22 00:00:00', 0),
(8, 2, 1, '2026-06-20 22:00:00', '2026-06-22 00:00:00', 0),
(9, 2, 1, '2026-06-21 22:00:00', '2026-06-23 00:00:00', 0),
(10, 2, 1, '2026-06-21 22:00:00', '2026-06-23 00:00:00', 1),
(11, 2, 1, '2026-06-20 22:00:00', '2026-06-22 00:00:00', 0),
(12, 2, 1, '2026-06-20 22:00:00', '2026-06-22 00:00:00', 0),
(13, 2, 1, '2026-06-20 22:00:00', '2026-06-22 00:00:00', 0),
(14, 2, 2, '2026-06-20 22:00:00', '2026-06-26 13:00:00', NULL),
(20, 2, 1, '2026-06-26 22:00:00', '2026-06-28 00:00:00', 0),
(21, 2, 2, '2026-06-26 22:00:00', '2026-07-28 00:00:00', 28);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_log` bit(1) NOT NULL DEFAULT b'1',
  `role` enum('admin','user','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `first_log`, `role`) VALUES
(1, 'Kerekes Erik', 'kerekeserik684@gmail.com', '$2y$10$I8hqWIhMlGJ1pRuUFlVz4e9gB1eyiJ7HgZ9G4txAIpxPKS/tmHMxG', b'0', 'admin'),
(2, 'Teszt Teszt', 'wasdwasd@gmail.com', '$2y$10$i8LRQc0Ts3DMQL7SMTCSp.7KGth19Xcwh9udCHcb69cCm7sQs/WBK', b'1', 'user');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`guest_id`);

--
-- A tábla indexei `keys_`
--
ALTER TABLE `keys_`
  ADD PRIMARY KEY (`keys_id`);

--
-- A tábla indexei `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `product_guest`
--
ALTER TABLE `product_guest`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- A tábla indexei `service_guest`
--
ALTER TABLE `service_guest`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `guests`
--
ALTER TABLE `guests`
  MODIFY `guest_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `keys_`
--
ALTER TABLE `keys_`
  MODIFY `keys_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT a táblához `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `product_guest`
--
ALTER TABLE `product_guest`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `service_guest`
--
ALTER TABLE `service_guest`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
