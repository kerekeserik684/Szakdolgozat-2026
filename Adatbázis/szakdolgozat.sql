-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Sze 20. 17:46
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
  `guest_card_id` varchar(6) NOT NULL,
  `issued_at` datetime NOT NULL,
  `returned_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `keys_`
--

INSERT INTO `keys_` (`keys_id`, `key_number`, `guest_card_id`, `issued_at`, `returned_at`) VALUES
(8, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-20 18:32:18'),
(9, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 10:08:10'),
(10, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 10:19:07'),
(11, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 10:36:46'),
(12, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 10:41:20'),
(13, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 11:57:58'),
(14, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 11:58:35'),
(15, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 12:13:41'),
(16, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 12:21:50'),
(17, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 12:22:08'),
(18, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 12:22:10'),
(19, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 12:22:13'),
(28, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 12:54:39'),
(29, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 12:54:53'),
(30, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 12:55:27'),
(32, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 13:08:19'),
(33, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 13:08:29'),
(34, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 13:33:18'),
(35, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 13:49:24'),
(36, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 13:49:24'),
(37, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 13:51:22'),
(38, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 13:54:08'),
(39, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 13:56:21'),
(40, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 13:56:26'),
(42, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 14:05:56'),
(43, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-21 14:07:26'),
(44, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-27 10:47:53'),
(45, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-27 10:54:57'),
(46, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-27 10:55:39'),
(47, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-27 10:56:01'),
(48, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-27 10:57:30'),
(49, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-27 12:15:07'),
(51, '', 'G00001', '2026-09-14 18:03:48', '2026-06-27 12:15:18'),
(52, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-27 12:32:07'),
(53, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-27 12:32:44'),
(54, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-27 12:32:47'),
(55, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-06-27 12:32:50'),
(56, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-07-05 15:00:04'),
(57, 'K001', 'G00001', '2026-09-14 18:03:48', '2026-09-14 16:04:22');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `product_id` varchar(6) NOT NULL,
  `multiplier` tinyint(4) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `status` enum('Rendelni','Rendelve','Beérkezett','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `orders`
--

INSERT INTO `orders` (`order_id`, `product_id`, `multiplier`, `order_date`, `status`) VALUES
(11, 'P00001', 1, '2026-08-16', 'Beérkezett'),
(15, 'P00002', 1, '2026-08-16', 'Beérkezett');

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
  `minimum_order_qty` mediumint(7) NOT NULL,
  `order_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `products`
--

INSERT INTO `products` (`id`, `manufacturer`, `name`, `quantity_type`, `storage`, `quantity`, `scoop_volume`, `quantity_price`, `product_number`, `product_photo`, `indicator_set`, `minimum_order_qty`, `order_price`) VALUES
(1, 'Teszt', 'Iso Whey Zero', 'gramm', 'T01-01', 137, 30, 500, 'P00001', '1_1782662511.jpg', 450, 450, 6000),
(2, 'Teszt', 'Creatine Monohydrate', 'gramm', 'T01-01', 395, 5, 300, 'P00002', NULL, 200, 200, 5500);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `product_guest`
--

CREATE TABLE `product_guest` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `guest_id` int(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(255) NOT NULL,
  `reason` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `product_guest`
--

INSERT INTO `product_guest` (`id`, `user_id`, `product_id`, `guest_id`, `timestamp`, `quantity`, `reason`) VALUES
(12, 1, 1, NULL, '2026-07-05 10:33:10', 1, 'Leltárkorrekció'),
(24, 1, 2, NULL, '2026-08-16 11:41:39', 200, 'Bevétel'),
(25, 1, 1, 2, '2026-08-16 11:45:04', 60, 'fogyás'),
(27, 1, 1, NULL, '2026-09-14 15:56:42', 200, 'Leltárkorrekció'),
(28, 1, 1, 2, '2026-09-14 16:05:10', 30, 'fogyás'),
(29, 1, 1, NULL, '2026-09-20 13:04:32', 33, 'Selejt');

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
(21, 2, 2, '2026-06-26 22:00:00', '2026-07-28 00:00:00', 27),
(22, 2, 1, '2026-09-13 22:00:00', '2026-09-15 00:00:00', 0);

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
(2, 'Teszt Teszt', 'wasdwasd@gmail.com', '$2y$10$a3t/w1IYyU1KMongy51yAek5j5ofj7i23yLCWHsJTQ5M.2zUDn6VK', b'0', 'user');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`guest_id`),
  ADD UNIQUE KEY `guest_card_id` (`guest_card_id`);

--
-- A tábla indexei `keys_`
--
ALTER TABLE `keys_`
  ADD PRIMARY KEY (`keys_id`),
  ADD KEY `guest_card_id` (`guest_card_id`);

--
-- A tábla indexei `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- A tábla indexei `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_number` (`product_number`);

--
-- A tábla indexei `product_guest`
--
ALTER TABLE `product_guest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_id` (`guest_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- A tábla indexei `service_guest`
--
ALTER TABLE `service_guest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_id` (`guest_id`),
  ADD KEY `service_id` (`service_id`);

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
  MODIFY `keys_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT a táblához `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT a táblához `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `product_guest`
--
ALTER TABLE `product_guest`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT a táblához `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `service_guest`
--
ALTER TABLE `service_guest`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `keys_`
--
ALTER TABLE `keys_`
  ADD CONSTRAINT `keys__ibfk_1` FOREIGN KEY (`guest_card_id`) REFERENCES `guests` (`guest_card_id`);

--
-- Megkötések a táblához `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_number`);

--
-- Megkötések a táblához `product_guest`
--
ALTER TABLE `product_guest`
  ADD CONSTRAINT `product_guest_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`guest_id`),
  ADD CONSTRAINT `product_guest_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_guest_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `service_guest`
--
ALTER TABLE `service_guest`
  ADD CONSTRAINT `service_guest_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`guest_id`),
  ADD CONSTRAINT `service_guest_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
