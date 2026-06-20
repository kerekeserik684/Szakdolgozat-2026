-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Jún 20. 20:40
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
(2, 'Elek', 'Teszt', 'Győr', 'wasd@gmail.com', '06302246561', '2006-01-01', 'Férfi', '1781972707_IMG_7686.jpeg', 'G00001', '2026-06-20 16:25:07');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `keys_`
--

CREATE TABLE `keys_` (
  `keys_id` int(255) NOT NULL,
  `key_number` varchar(6) NOT NULL,
  `guest_card_id` varchar(255) NOT NULL,
  `issued_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `returned_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `keys_`
--

INSERT INTO `keys_` (`keys_id`, `key_number`, `guest_card_id`, `issued_at`, `returned_at`) VALUES
(1, 'K001', '0', '2026-06-20 16:21:32', '2026-06-20 16:21:08'),
(2, 'K001', '0', '2026-06-20 16:26:51', '2026-06-20 16:26:51'),
(3, 'K001', '0', '2026-06-20 16:34:30', '2026-06-20 16:34:30'),
(4, 'K001', '0', '2026-06-20 16:39:01', '2026-06-20 16:39:01'),
(5, 'K001', '0', '2026-06-20 18:22:14', '2026-06-20 18:22:14'),
(6, 'K001', '0', '2026-06-20 18:29:13', NULL),
(7, '', 'G00001', '2026-06-20 18:32:08', '2026-06-20 18:32:08'),
(8, 'K001', 'G00001', '2026-06-20 18:32:18', '2026-06-20 18:32:18');

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
(1, 3500, 'Napi jegy', 1, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `service_guest`
--

CREATE TABLE `service_guest` (
  `guest_id` int(255) NOT NULL,
  `service_id` int(255) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_date` datetime DEFAULT NULL,
  `service_entries` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `service_guest`
--

INSERT INTO `service_guest` (`guest_id`, `service_id`, `start_date`, `end_date`, `service_entries`) VALUES
(0, 1, '2026-06-19 22:00:00', '2026-06-21 00:00:00', NULL),
(0, 1, '2026-06-19 22:00:00', '2026-06-21 00:00:00', NULL),
(0, 1, '2026-06-19 22:00:00', '2026-06-21 00:00:00', NULL),
(0, 1, '2026-06-19 22:00:00', '2026-06-21 00:00:00', NULL);

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
-- A tábla indexei `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

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
  MODIFY `guest_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `keys_`
--
ALTER TABLE `keys_`
  MODIFY `keys_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
