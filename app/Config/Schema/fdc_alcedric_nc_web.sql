-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 11, 2024 at 10:53 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fdc_alcedric_nc_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `created_by`, `created`, `modified`) VALUES
(23, 8, '2024-04-11 10:45:10', '2024-04-11 10:45:10'),
(24, 9, '2024-04-11 10:52:42', '2024-04-11 10:52:42'),
(25, 9, '2024-04-11 10:53:24', '2024-04-11 10:53:24'),
(26, 8, '2024-04-11 11:41:08', '2024-04-11 11:41:08'),
(27, 8, '2024-04-11 11:50:01', '2024-04-11 11:50:01'),
(28, 9, '2024-04-11 16:15:11', '2024-04-11 16:15:11'),
(29, 8, '2024-04-11 16:42:16', '2024-04-11 16:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `participant_id`, `conversation_id`, `message`, `created`) VALUES
(37, 26, 21, 'Yow squiddy', '2024-04-11 10:43:00'),
(40, 32, 24, 'hi sponge from squiddy', '2024-04-11 10:52:42'),
(41, 34, 25, 'hi milky from squiddy\'\r\n', '2024-04-11 10:53:24'),
(42, 36, 26, 'hi squiddy', '2024-04-11 11:41:08'),
(43, 38, 27, 'Hi milk', '2024-04-11 11:50:01'),
(44, 39, 27, 'hey johnny', '2024-04-11 11:50:18'),
(45, 39, 27, 'how are you?', '2024-04-11 11:50:25'),
(46, 38, 27, 'Im good now', '2024-04-11 11:55:02'),
(47, 38, 27, 'How about you?', '2024-04-11 11:55:08'),
(48, 39, 27, 'Im good too', '2024-04-11 11:55:15'),
(49, 39, 27, 'What will you do today?', '2024-04-11 11:55:31'),
(50, 38, 27, 'I think I\'m going to play some games now', '2024-04-11 11:55:52'),
(51, 39, 27, 'So you like games?', '2024-04-11 11:56:09'),
(52, 38, 27, 'Yes, I do\n', '2024-04-11 11:56:59'),
(53, 38, 27, 'How about you?', '2024-04-11 11:57:06'),
(54, 38, 27, 'Hi milky', '2024-04-11 12:54:10'),
(55, 39, 27, 'Hello, what can i do for u?', '2024-04-11 12:54:25'),
(56, 38, 27, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2024-04-11 14:42:06'),
(57, 39, 27, 'Your message is too long', '2024-04-11 15:11:36'),
(58, 39, 27, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2024-04-11 16:00:04'),
(59, 39, 27, 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2024-04-11 16:00:24'),
(60, 38, 27, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', '2024-04-11 16:01:12'),
(61, 40, 28, 'new convo between squid and milky', '2024-04-11 16:15:11'),
(62, 42, 29, 'csd', '2024-04-11 16:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `user_id`, `conversation_id`, `created`) VALUES
(26, 8, 21, '2024-04-11 10:43:00'),
(27, 9, 21, '2024-04-11 10:43:00'),
(32, 9, 24, '2024-04-11 10:52:42'),
(33, 10, 24, '2024-04-11 10:52:42'),
(34, 9, 25, '2024-04-11 10:53:24'),
(35, 11, 25, '2024-04-11 10:53:24'),
(36, 8, 26, '2024-04-11 11:41:08'),
(37, 9, 26, '2024-04-11 11:41:08'),
(38, 8, 27, '2024-04-11 11:50:01'),
(39, 11, 27, '2024-04-11 11:50:01'),
(40, 9, 28, '2024-04-11 16:15:11'),
(41, 11, 28, '2024-04-11 16:15:11'),
(42, 8, 29, '2024-04-11 16:42:16'),
(43, 9, 29, '2024-04-11 16:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `hobby` text NOT NULL,
  `profile_picture` varchar(40) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `created_ip` varchar(200) NOT NULL,
  `modified_ip` varchar(200) NOT NULL,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `age`, `birthdate`, `gender`, `hobby`, `profile_picture`, `email`, `password`, `created`, `modified`, `created_ip`, `modified_ip`, `last_login`) VALUES
(8, 'Johnny', 20, '2024-04-11', 'male', 'I\'m Johnny and my hobby is to go out to the mall and buy some foods', '', 'johnny@gmail.com', '1d235b05ec8f9285776a7065b1340f04beb53b08', '2024-04-11 10:32:25', '2024-04-11 10:32:25', '::1', '::1', '2024-04-11 16:02:35'),
(9, 'Squidward', 30, '2024-04-11', 'male', 'I\'m squiddy and my hobby is to find squids and eat them alive as fresh', '', 'squidward@gmail.com', '7067db5654fffcdac749f70f928e7fddcb4e8ac6', '2024-04-11 10:33:30', '2024-04-11 10:33:30', '::1', '::1', '2024-04-11 16:09:27'),
(10, 'Sponge', 20, '2024-04-11', 'male', 'Spongynious', '', 'sponge@gmail.com', '6bca2c239c8b36ee93a34e0f01beb22837d6429e', '2024-04-11 10:34:08', '2024-04-11 10:34:08', '::1', '::1', '2024-04-11 10:51:59'),
(11, 'Milky', 39, '2024-04-11', 'female', 'Milky way galaxy exploration and beyond', '5efa87758b0e9909c0b4.jpeg', 'milky@gmail.com', '125c138b2f48734ade135a3f7656e2c910192a87', '2024-04-11 10:34:45', '2024-04-11 10:50:25', '::1', '::1', '2024-04-11 16:08:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
