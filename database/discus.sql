-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2020 at 03:36 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `discus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `aname` varchar(30) NOT NULL,
  `addedby` varchar(30) NOT NULL,
  `aheadline` varchar(12) NOT NULL,
  `abio` varchar(500) NOT NULL,
  `aimage` varchar(60) NOT NULL DEFAULT 'cmt.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `datetime`, `username`, `password`, `aname`, `addedby`, `aheadline`, `abio`, `aimage`) VALUES
(1, 'September-28-2020 19:54:06', 'admin1', 'admin1', 'Zoey', 'navi', 'Architect', 'Been an architect for about 10 years now', 'Ginger pattern9791_rectangle.jpg'),
(2, 'September-28-2020 21:19:21', 'admin2', 'admin2', 'Admin Two', 'admin1', '', '', ''),
(4, 'September-29-2020 18:01:34', 'demo', 'demo123', 'demo', 'admin1', '', '', 'cmt.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `author`, `datetime`) VALUES
(1, 'Technology', 'navi', 'September-27-2020 23:44:35'),
(3, 'Science', 'navi', 'September-27-2020 23:51:13'),
(4, 'Music', 'admin1', 'September-28-2020 21:04:12');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approvedby` varchar(50) NOT NULL,
  `status` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `datetime`, `name`, `email`, `comment`, `approvedby`, `status`, `post_id`) VALUES
(1, 'September-28-2020 16:43:54', 'dummy1', 'd1@mail.com', 'test', 'Admin One', 'OFF', 2),
(2, 'September-28-2020 17:12:10', 'hello', 'h@mail.com', 'hello2', 'pending', 'OFF', 2),
(3, 'September-29-2020 12:39:59', 'xyz', 'xy@mail.com', 'xyz ewndsf dsfahbdsfa hadbshfbh ashbfhash hbbdahbfha hbhabdsfhbahdsf', 'Admin One', 'ON', 2),
(4, 'September-29-2020 12:40:45', 'dummy2', 'dummy2@mail.com', 'sample comment 2', 'pending', 'OFF', 2),
(5, 'September-29-2020 12:41:40', 'd3', 'd3@mail.com', '3rd sample comment....', 'pending', 'OFF', 3),
(6, 'September-29-2020 12:42:14', 'lucifer', 'lc@mail.com', 'good post btw', 'pending', 'OFF', 3),
(7, 'September-29-2020 12:42:55', 'hello world', 'hw@mail.com', 'what project is it again?', 'Admin One', 'ON', 1),
(9, 'September-29-2020 16:00:00', 'demo', 'demo@mail.com', 'test - demo', 'Admin One', 'ON', 6);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `title` varchar(300) NOT NULL,
  `category` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `post` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `datetime`, `title`, `category`, `author`, `image`, `post`) VALUES
(1, 'September-28-2020 00:43:08', 'Program Done', 'Music', 'navi', 'geoload.JPG', 'Nam dignissim sed nunc eu consequat. Vivamus congue magna eu enim convallis, a tincidunt turpis vulputate. Nulla quis eleifend nulla. Vivamus at imperdiet elit. In consequat justo eget tortor dignissim dignissim. Curabitur rutrum et magna quis aliquam. Phasellus faucibus commodo erat, eget ultrices ex aliquet vitae. Phasellus id nisl ut arcu faucibus egestas. Etiam fringilla lacus eu rutrum finibus. Ut ultricies libero nec enim consectetur laoreet. Ut lacinia nibh eu risus interdum, sed vestibulum velit viverra.'),
(2, 'September-28-2020 16:38:49', 'sample1', 'Science', 'navi', 'orsrc21424.jpg', 'Fusce convallis, dolor a dapibus pretium, mi ex hendrerit sapien, id posuere leo libero eget purus. Maecenas consequat sapien sit amet dui eleifend, eget pellentesque urna scelerisque. Aliquam scelerisque risus non malesuada scelerisque. Cras aliquam purus odio, id pellentesque tellus feugiat sed. Fusce tempus aliquam mauris ac auctor. Etiam facilisis pharetra felis, in euismod lacus accumsan id. Donec dapibus ligula id dolor vulputate, et congue tortor viverra. Donec tincidunt nibh sit amet auctor elementum. Nullam ac risus ultricies, pharetra nisi ac, convallis purus. Nulla sed turpis ullamcorper, mattis diam quis, cursus orci.          '),
(3, 'September-28-2020 16:39:19', 'sample2', 'Music', 'navi', 'orsrc30378.jpg', 'Ut sit amet viverra eros. Nullam nec accumsan odio, vitae dapibus velit. Donec ac odio non risus pharetra mattis id sed arcu. Maecenas semper quam mi. In orci risus, sodales eu eros eget, laoreet hendrerit neque. Nam ultrices tristique hendrerit. Integer a aliquet elit. Maecenas dignissim turpis ac aliquam congue. Duis facilisis dapibus tincidunt.'),
(4, 'September-29-2020 15:00:16', 'post1', 'Science', 'admin1', 'Discoverig a fantasy world2362_rectangle.jpg', ' Suspendisse porttitor, purus non auctor tincidunt, diam est tincidunt libero, sed iaculis nisl mi eu mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut dapibus commodo nulla, et tristique enim dictum et. Vivamus sagittis mattis nulla, quis convallis risus pulvinar eget. Fusce sodales vulputate quam, non tincidunt eros. Vivamus sed orci justo. Morbi efficitur a nunc id efficitur. Duis et iaculis diam. Quisque eget leo ligula. Praesent eu laoreet metus.'),
(5, 'September-29-2020 15:00:30', 'post2', 'Technology', 'admin1', 'I am10912_rectangle.jpg', 'Etiam facilisis pharetra felis, in euismod lacus accumsan id. Donec dapibus ligula id dolor vulputate, et congue tortor viverra. Donec tincidunt nibh sit amet auctor elementum. Nullam ac risus ultricies, pharetra nisi ac, convallis purus. Nulla sed turpis ullamcorper, mattis diam quis, cursus orci. In laoreet felis sed purus facilisis, egestas tempor massa dignissim. Fusce mollis non tellus et ultrices. Donec nisi urna, placerat et tortor vitae, ultrices molestie ipsum.\r\nNulla facilisi. Donec a lacus ultricies, pulvinar tortor nec, ultrices arcu. Curabitur porttitor sodales lacus, id placerat dolor interdum eu. Sed imperdiet nulla a viverra porttitor.       '),
(6, 'September-29-2020 15:00:53', 'post3', 'Technology', 'admin1', 'Drifting away10825_rectangle.jpg', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exercitation ulliam corper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem veleum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel willum lunombro dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `post_com_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
