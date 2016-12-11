-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas generowania: 11 Gru 2016, 18:18
-- Wersja serwera: 5.7.16-0ubuntu0.16.04.1
-- Wersja PHP: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `warsztaty2`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Tweets`
--

CREATE TABLE `Tweets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tweet` varchar(140) NOT NULL,
  `creation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `Tweets`
--

INSERT INTO `Tweets` (`id`, `user_id`, `tweet`, `creation_date`) VALUES
(1, 19, 'tweet o niczym ale pierwszy', '2016-12-11');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `hashedPassword` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `Users`
--

INSERT INTO `Users` (`id`, `email`, `username`, `hashedPassword`) VALUES
(19, 'mmatyska755@gmail.com', 'Marcin', '$2y$10$c6xoZX6cWS87wTmGLm4AtuGhnx5ZWa770ws27Zmu/Yj2cElRYvEMe'),
(21, 'jan1455@wp.pl', 'Jan', '$2y$10$Rp5Bbkos/D.1LHnsgfTCO.NwbwnGQVhW0tnfxzn/1LRd53BxaE5X2');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `Tweets`
--
ALTER TABLE `Tweets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `email_3` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `Tweets`
--
ALTER TABLE `Tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Tweets`
--
ALTER TABLE `Tweets`
  ADD CONSTRAINT `Tweets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
