-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 24 avr. 2021 à 11:54
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `presshare`
--

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

CREATE TABLE `author` (
  `a_id` int(10) UNSIGNED NOT NULL,
  `a_pseudo` varchar(20) NOT NULL,
  `a_first_name` varchar(20) ,
  `a_last_name` varchar(50) ,
  `a_password` varchar(255) NOT NULL,
  `a_created_at` datetime DEFAULT current_timestamp(),
  `a_confirmed_at` datetime DEFAULT NULL,
  `a_confirmation_token` varchar(100) DEFAULT NULL,
  `a_email` varchar(255) NOT NULL,
  `a_reset_token` varchar(200) DEFAULT NULL,
  `a_reset_at` datetime DEFAULT NULL,
  `a_remember_token` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`a_id`, `a_pseudo`, `a_first_name`, `a_last_name`, `a_password`, `a_created_at`, `a_confirmed_at`, `a_confirmation_token`, `a_email`, `a_reset_token`, `a_reset_at`, `a_remember_token`) VALUES
(1, 'senor16', 'Michée', 'Sesso Kosga Bamokaï', '$2y$10$HruIu9cMnX1xXaE/0sJ86e3M641DzajvMQWA.cKROE.pJai.N2Mhy', '2021-03-27 21:21:33', '2021-04-22 09:43:42', NULL, 'msesso@gmail.com', 'Tmf2WuClQ86prs0j2L8uOmQV2kU6TgRjz1C4MnJNOzPPsyrsII7c0FVEOvWZcEMxwPpTlbFqEMX3EWPeQIn7o8Ry65XwBO5eV73YkbtGtR8IATme3kWRjuoqId20kK9fzQ0ST3JaNaDrzIKEmM2Qtp8iMdHFhoLlAHb0JNe7wkD2ZF7ywR1k71kEUfbXclfmrkyqgX8j', '2021-04-24 09:59:14', NULL),
(30, 'dede', 'Deddy', 'Derson Danson Danely ', '$2y$10$r5PsnvZ8Wc0HnojYQJhqjOvfLPsWVgk6coT9U/SsLVmol3sHOpImK', '2021-04-19 15:16:01', '2021-04-22 09:43:42', NULL, 'dede@deda.com', 'L4FeChMRm2zf3eMZBws96RoWwlGynW43tAOjU8vrLbHsPhPO2xLBGef6QYQGLhlFfuBPpvCzZmXAYLBXEUXMTtkf0zSVQXRUKpZAUITjj8dGDcekfs4fm8UBD0dyZkvXDxSkSpRTrU1eTRihKbQiDnBuleTURbi8QiW8pJzFsL3yhufik9eT6uuAepRlxj4jBxMsZpLe', '2021-04-24 10:51:09', 'U3lYtwOWBjPeRmgN2bjQfvW6lF1mj6rNa1fCFEcfSom4RCkXE0aP4NhCnpwyoAYkuMFs86CQtjdv248jeUmB0EszIYDSmlgQf6loh6OoZbpkyoHsUEVDNAJktSw5RYtf7I2CwDPRi8qNR6lt2vakzEs3pxDFYrXrNZHBSr96w5EsqH51uXoZdEaLL63kFvFhGFK5PDWIuzhhutkSaT5NMADBJlP6yHAyAsLYo4HfpU0lkCAg1DqSTFgpaR'),
(31, 'hello', 'Kitty', 'Hello', '$2y$10$v/gBC9K8NnacSwhoUiugweQ6CkpPNKQEM1eJE5yDMLIAL8T44tqAS', '2021-04-22 09:43:30', '2021-04-22 09:43:42', NULL, 'hello@kitty.com', NULL, NULL, NULL),
(32, 'tatou', '', '', '$2y$10$OTdp.q/IZY5.yAPwEahGH.qkNylauCXoEryuK1GV4fO9bL4mVVCJ2', '2021-04-22 20:23:10', NULL, 's5PwsWghuCv7LwGrorIHdyGKOUW0dyQwYQODgz5LXxCS4dtAKMe1IEVwEANf', 'hello@tatou.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `press`
--

CREATE TABLE `press` (
  `p_id` int(11) NOT NULL,
  `p_title` varchar(255) NOT NULL,
  `p_content` text DEFAULT NULL,
  `p_genre` enum('Text','Link') DEFAULT 'Text',
  `p_author_id` int(10) UNSIGNED NOT NULL,
  `p_created_at` datetime DEFAULT current_timestamp(),
  `p_last_modified` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `press`
--

INSERT INTO `press` (`p_id`, `p_title`, `p_content`, `p_genre`, `p_author_id`, `p_created_at`, `p_last_modified`) VALUES
(1, 'OJ6nClfd9SBh', '1qqum9HT3PuPaBmQn0XscQ==', 'Link', 1, '2021-04-11 15:21:15', '2021-04-11 15:21:15'),
(3, 'gMxZXQ==', 'QgXoMiHZZGXJfdEjog==', 'Link', 1, '2021-04-11 15:21:15', '2021-04-11 15:21:15'),
(4, 'C39YEovtTg==', 'SG3fgzQcgNfq 5jF57oJU0Rl1kw== ', 'Text', 1, '2021-04-11 15:21:15', '2021-04-11 15:21:15'),
(5, '4kOIR DfnMIYi/pU=', 'k8bHPbEn1 UwOURjfhOB2mU1PTxg=', 'Text', 1, '2021-04-11 15:21:15', '2021-04-11 15:21:15'),
(6, 'a0sUyKQ2', 'FhZVv9FMgQwn8OK/ag3fj9XJ', 'Text', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(7, '8Kz9IxPH6o0=', ' LkehqocK Z2wQ==', 'Text', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(8, 'ufp/', 'HA9vzHHjEHB74wVgEg==', 'Text', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(9, 'AlVrC4fDKOwo', 'YPbeE2kDf/EvMA==', 'Text', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(10, 'jUA/ LjkYNfUJQw=', 'IbhKIUivzKQQmxe2ll4XrxWO Q==', 'Text', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(11, 'eLz6KkPc', '9Ie4pOjo2WUKZF5h', 'Text', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(12, 'YQ5THg==', '5BG74yYl6xpleuGnohFC', 'Link', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(13, '0Q7qZwNB 2snnnE=', 'ADmrICjraMDcFsWl2vblFlZp', 'Text', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(14, 'qe/90pJ3LdBd gs=', 'WodHooVsYkCo1LSeJJDsuRI=', 'Link', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(15, 'ipYM1sQkIh8/VQ==', 'qUconhWTE6MfYKSZ', 'Link', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(16, 'dU0Tckij', 'rs8xpQ7v7uYwtk4IJ9UPfnc=', 'Text', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(17, 'RWUpEw==', 'AIfrc4VqyUp3f1tBEg==', 'Link', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(18, 'dOG00g==', 'ryYM93WdQKDue3iah41DkUnz/Q==', 'Text', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(19, 'LxpZsQ==', 'nwMZVLnG7qISWw==', 'Text', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(20, 'gNzK', 'z4yGloX9pXHoTIg=', 'Text', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(21, 'm5aFD 7hR 6rfA==', '4DjQ2xjBJDo8WMt ', 'Link', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(22, '8f1P0zDC0E5wyA==', 'OJ1Mz1FQyj0YGtU=', 'Link', 1, '2021-04-11 15:21:16', '2021-04-11 15:21:16'),
(23, 'CCnV', 'ibpSXSfiiktzvo7HE6SSaYAn', 'Link', 1, '2021-04-11 15:21:17', '2021-04-11 15:21:17'),
(24, 'wEXVm4L3LxalkPlh', 'a7ARimEUMPwRjiKGXn0=', 'Link', 1, '2021-04-11 15:21:17', '2021-04-11 15:21:17'),
(25, 'change', 'MYmb/PlD9BsDMhrD2Xwssw==', 'Text', 1, '2021-04-11 15:21:17', '2021-04-15 13:17:55'),
(26, '2mXBtLN eNcK', 'tTyFwApqh56Bdnkw4jeMdA==', 'Link', 1, '2021-04-11 15:21:17', '2021-04-11 15:21:17'),
(27, 'HxU4hsz/', 'qbNEQuga0Ia ldYeuRAw/g==', 'Link', 1, '2021-04-11 15:21:17', '2021-04-11 15:21:17'),
(28, 'NlVNUE9r Q==', 'IWeqTwFrtM71wZdtD2y1', 'Text', 1, '2021-04-11 15:21:17', '2021-04-11 15:21:17'),
(29, 'DfXXzA==', 'dnwiqfRNCS0T2Dm2Ks2JttA=', 'Link', 1, '2021-04-11 15:21:17', '2021-04-11 15:21:17'),
(30, 'UA/l', 'thze90U5KiCv HVaZnykhw==', 'Text', 1, '2021-04-11 15:21:17', '2021-04-11 15:21:17'),
(31, 'Hello', 'Kitty', 'Text', 1, '2021-04-15 12:00:25', '2021-04-15 12:00:25'),
(32, 'dede', 'Collaboratively grow worldwide benefits vis-a-vis client-centric portals. Quickly myocardinate mission-critical quality vectors before interoperable resources. Phosfluorescently empower front-end growth strategies vis-a-vis out-of-the-box.', 'Text', 1, '2021-04-15 12:45:05', '2021-04-15 12:45:05'),
(35, 'dedem', 'Helo\r\nKitt', 'Text', 1, '2021-04-15 13:02:42', '2021-04-15 13:02:42'),
(36, 'sesso', 'ddede\n\r\nhello\ntiti', 'Text', 1, '2021-04-15 13:04:42', '2021-04-15 13:04:42'),
(37, 'w', 'dede\r\nfrfr', 'Text', 1, '2021-04-15 13:06:04', '2021-04-15 13:06:04'),
(38, 'e', 'a\r\nd\r\nc\r\nc', 'Text', 1, '2021-04-15 13:07:00', '2021-04-15 16:19:07'),
(39, 'qw', 'q\r\nw\r\ne\r\nr\r\nd', 'Text', 1, '2021-04-15 13:27:01', '2021-04-15 13:27:01'),
(72, 'dedesa', 'jk', 'Text', 1, '2021-04-15 16:02:40', '2021-04-15 16:29:07'),
(73, 'Hellog', 'Voici', 'Link', 1, '2021-04-15 17:09:42', '2021-04-15 17:09:42'),
(74, 'Hellog t', 'Jshs', 'Text', 1, '2021-04-15 17:10:04', '2021-04-15 17:10:04'),
(75, 'helloY', 'Gff', 'Text', 1, '2021-04-15 17:16:33', '2021-04-15 17:16:52'),
(76, 'KATY', 'Hello', 'Text', 1, '2021-04-16 13:53:00', '2021-04-16 15:32:36'),
(77, 'tata', 'Koumi nimi tity <b>Halodny</b>', 'Text', 1, '2021-04-22 10:24:05', '2021-04-22 10:24:05'),
(79, '', '12', 'Text', 30, '2021-04-23 14:07:32', '2021-04-23 14:08:00'),
(80, 'aqaqaq', 'aaaaaaaaaaaaaa', 'Text', 30, '2021-04-23 14:20:08', '2021-04-23 14:20:08'),
(81, '@sw', 'swsw', 'Text', 30, '2021-04-23 14:20:26', '2021-04-23 14:44:41');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`a_id`),
  ADD UNIQUE KEY `un_pseudo` (`a_pseudo`),
  ADD UNIQUE KEY `un_email` (`a_email`);

--
-- Index pour la table `press`
--
ALTER TABLE `press`
  ADD PRIMARY KEY (`p_id`),
  ADD UNIQUE KEY `un_title` (`p_title`),
  ADD KEY `fk_Press_p_author_id_Author` (`p_author_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `author`
--
ALTER TABLE `author`
  MODIFY `a_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `press`
--
ALTER TABLE `press`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `press`
--
ALTER TABLE `press`
  ADD CONSTRAINT `fk_Press_p_author_id_Author` FOREIGN KEY (`p_author_id`) REFERENCES `author` (`a_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
