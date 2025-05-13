-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 07:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pickmytrack`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CheckUserResult` (IN `user_id` INT)   BEGIN
    SELECT * FROM results WHERE user_id = user_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteUserResult` (IN `uid` INT)   BEGIN
    DELETE FROM results WHERE user_id = uid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetStudentsByTrack` (IN `track_code` VARCHAR(10))   BEGIN
  SELECT u.name, u.email
  FROM users u
  INNER JOIN results r ON u.id = r.user_id
  WHERE r.specialization = track_code
  ORDER BY u.name;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserByEmail` (IN `user_email` VARCHAR(255))   BEGIN
    SELECT * FROM users WHERE email = user_email;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertResult` (IN `user_id` INT, IN `specialization` VARCHAR(10))   BEGIN
    INSERT INTO results (user_id, specialization) VALUES (user_id, specialization);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateResult` (IN `user_id` INT, IN `specialization` VARCHAR(10))   BEGIN
    UPDATE results SET specialization = specialization WHERE user_id = user_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `specialization` varchar(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Ruffa Anoya', 'ruffa.anoya91@gmail.com', 'Rose123!'),
(2, 'Raiza Austria', 'raiza.austria88@gmail.com', 'Sky456'),
(3, 'Kirsten Barroma', 'kirsten.barroma24@gmail.com', 'Mint789!'),
(4, 'Dan Belda', 'dan.belda17@gmail.com', 'Storm321!'),
(5, 'Johann Beleno', 'johann.beleno42@gmail.com', 'Flame654!'),
(6, 'Carvey Briones', 'carvey.briones09@gmail.com', 'Pine312!'),
(7, 'Daniela Calizo', 'daniela.calizo33@gmail.com', 'Moon008!'),
(8, 'Airajoy Carabeo', 'airajoy.carabeo18@gmail.com', 'Wind915!'),
(9, 'Tanya Ly Castroverde', 'tanya.castroverde73@gmail.com', 'Lake789!'),
(10, 'Ron Cerantes', 'ron.cerantes06@gmail.com', 'Tree547!'),
(11, 'Harcy Collantes', 'harvy.collantes55@gmail.com', 'Sand364!'),
(12, 'Micko Comia', 'micko.comia22@gmail.com', 'Rock082!'),
(13, 'Vinz Cortiguerra', 'vinz.cortiguerra87@gmail.com', 'Fire225!'),
(14, 'Marc Delangin', 'marc.dalangin94@gmail.com', 'Rain119!'),
(15, 'James Patrick De Guzman', 'james.deguzman11@gmail.com', 'Frost667!'),
(16, 'Camile De Jesus', 'camile.dejesus40@gmail.com', 'Babyko143'),
(17, 'Ramon Fontalera', 'ramon.fontelera08@gmail.com', 'Blaze723!'),
(18, 'Marc Garcia', 'marc.garcia57@gmail.com', 'Hill999!'),
(19, 'Dreed Gonito', 'dreed.gonito14@gmail.com', '.Nova445!'),
(20, 'Jasper Jayme', 'jasper.jayme28@gmail.com', 'Star877!'),
(21, 'Princess Jordan', 'princess.jordan63@gmail.com', 'Dust444!'),
(22, 'James Lajo', 'james.lajo36@gmail.com', 'Ice337!'),
(23, 'Shaira Landicho', 'shaira.landicho01@gmail.com', 'Stone981!'),
(24, 'Dave Larrazabal', 'dave.larrazabal90@gmail.com', 'Fog210!'),
(25, 'Reymark Levita', 'reymark.levita81@gmail.com', ''),
(26, 'John Lopez', 'john.lopez76@gmail.com', 'Tree456!'),
(27, 'Ancil Macalalad', 'ancil.macalalad99@gmail.com', 'Flame102!'),
(28, 'Angiela Macaraig', 'angiela.macaraig19@gmail.com', 'Frost421!'),
(29, 'Eliza Macalintal', 'eliza.makalintal27@gmail.com', 'Moon555!'),
(30, 'Emanuel Masapol', 'emanuel.masapol62@gmail.com', 'Rain761!'),
(31, 'Cassandra Mercado', 'cassandra.mercado35@gmail.com', 'Wind183!'),
(32, 'Germain Miranda', 'germain.miranda79@gmail.com', 'Star934!'),
(33, 'Kenneth Montes', 'kenneth.montes43@gmail.com', 'Sky876!'),
(34, 'Qhris Lora Otalla', 'qhris.otalla85@gmail.com', 'ewan'),
(35, 'Kurt Perez', 'kurt.perez30@gmail.com', 'Nova912!'),
(36, 'Louisa Protestante', 'louisa.protestante20@gmail.com', 'Glow274!'),
(37, 'Benedict Ramos', 'benedict.ramos07@gmail.com', 'Pine387!'),
(38, 'Ralph Samonte', 'ralph.samonte71@gmail.com', 'Storm129!'),
(39, 'Joshua Sianquita', 'joshua.sianquita44@gmail.com', 'Blaze521!'),
(40, 'Kelvin Siman', 'kelvin.siman38@gmail.com', 'Tree880!'),
(41, 'Edwin Surwela', 'edwin.surwela60@gmail.com', 'Rain202!'),
(42, 'Alexander Tucay', 'alexander.tucay26@gmail.com', 'Wind666!'),
(43, 'Althea Untalan', 'althea.untalan12@gmail.com', 'Sky473!'),
(44, 'admin', 'admin', 'adminpass');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
