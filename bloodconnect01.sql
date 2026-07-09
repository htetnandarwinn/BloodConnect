-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2026 at 11:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bloodconnect01`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT 'INFO',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `user_name`, `action`, `message`, `type`, `created_at`) VALUES
(1, 58, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260705234309 was submitted by patient.', 'INFO', '2026-07-05 17:13:09'),
(2, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 17:21:24'),
(3, 58, 'dardar', 'USER_LOGIN', 'dardar logged in to system', 'info', '2026-07-05 17:22:28'),
(4, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 17:22:42'),
(5, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 17:25:44'),
(6, 58, 'dardar', 'USER_LOGIN', 'dardar logged in to system', 'info', '2026-07-05 17:26:28'),
(7, 58, 'dardar', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260705235644 was submitted by patient.', 'INFO', '2026-07-05 17:26:44'),
(8, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 17:27:03'),
(9, 58, 'dardar', 'USER_LOGIN', 'dardar logged in to system', 'info', '2026-07-05 17:27:50'),
(10, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 17:28:16'),
(11, 57, 'Admin', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260705235946 was submitted by patient.', 'INFO', '2026-07-05 17:29:46'),
(12, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-05 18:40:29'),
(13, 59, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 02:56:07'),
(14, 59, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706092626 was submitted by patient.', 'INFO', '2026-07-06 02:56:26'),
(15, 59, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 02:57:15'),
(16, 59, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 02:58:32'),
(17, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 02:59:08'),
(18, 60, 'dd', 'USER_LOGIN', 'dd logged in to system', 'info', '2026-07-06 03:56:26'),
(19, 60, 'dd', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706102643 was submitted by patient.', 'INFO', '2026-07-06 03:56:43'),
(20, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 03:57:28'),
(21, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 04:32:39'),
(22, 60, 'dar dar', 'USER_LOGIN', 'dar dar logged in to system', 'info', '2026-07-06 05:10:56'),
(23, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 05:19:37'),
(24, 61, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 05:26:00'),
(25, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706115614 was submitted by patient.', 'INFO', '2026-07-06 05:26:14'),
(26, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 05:27:02'),
(27, 61, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 06:23:54'),
(28, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:24:16'),
(29, 61, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 06:30:03'),
(30, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:30:34'),
(31, 60, 'dar dar', 'USER_LOGIN', 'dar dar logged in to system', 'info', '2026-07-06 06:31:11'),
(32, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:31:27'),
(33, 62, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-06 06:33:16'),
(34, 62, 'bunny', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706130338 was submitted by patient.', 'INFO', '2026-07-06 06:33:38'),
(35, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:34:04'),
(36, 62, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-06 06:39:31'),
(37, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:40:08'),
(38, 60, 'dar dar', 'USER_LOGIN', 'dar dar logged in to system', 'info', '2026-07-06 06:40:35'),
(39, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 06:41:20'),
(40, 61, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 06:43:25'),
(41, 61, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-06 06:55:11'),
(42, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706132529 was submitted by patient.', 'INFO', '2026-07-06 06:55:29'),
(43, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706132912 was submitted by patient.', 'INFO', '2026-07-06 06:59:12'),
(44, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706162123 was submitted by patient.', 'INFO', '2026-07-06 09:51:23'),
(45, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706162711 was submitted by patient.', 'INFO', '2026-07-06 09:57:11'),
(46, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 10:08:27'),
(47, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706163934 was submitted by patient.', 'INFO', '2026-07-06 10:09:34'),
(48, 61, 'kk', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706164236 was submitted by patient.', 'INFO', '2026-07-06 10:12:36'),
(49, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 14:39:00'),
(50, 60, 'dar dar', 'USER_LOGIN', 'dar dar logged in to system', 'info', '2026-07-06 15:20:05'),
(51, 60, 'dar dar', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706215112 was submitted by patient.', 'INFO', '2026-07-06 15:21:12'),
(52, 60, 'dar dar', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706220348 was submitted by patient.', 'INFO', '2026-07-06 15:33:48'),
(53, 60, 'dar dar', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706224057 was submitted by patient.', 'INFO', '2026-07-06 16:10:57'),
(54, 60, 'dar dar', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706225205 was submitted by patient.', 'INFO', '2026-07-06 16:22:05'),
(55, 62, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-06 16:51:00'),
(56, 62, 'bb', 'USER_LOGIN', 'bb logged in to system', 'info', '2026-07-06 16:52:00'),
(57, 62, 'bb', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706232233 was submitted by patient.', 'INFO', '2026-07-06 16:52:33'),
(58, 62, 'bb', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706232256 was submitted by patient.', 'INFO', '2026-07-06 16:52:56'),
(59, 62, 'bb', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706232358 was submitted by patient.', 'INFO', '2026-07-06 16:53:58'),
(60, 62, 'bb', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260706234850 was submitted by patient.', 'INFO', '2026-07-06 17:18:50'),
(61, 63, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-06 17:36:39'),
(62, 63, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260707000718 was submitted by patient.', 'INFO', '2026-07-06 17:37:18'),
(63, 63, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-06 17:40:33'),
(64, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-06 17:42:04'),
(65, 63, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260707001339 was submitted by patient.', 'INFO', '2026-07-06 17:43:39'),
(66, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-06 18:26:30'),
(67, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-06 18:31:48'),
(68, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 03:03:14'),
(69, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 03:54:32'),
(70, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 04:23:34'),
(71, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 04:26:50'),
(72, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 04:58:26'),
(73, 64, 'bunny', 'USER_LOGIN', 'bunny logged in to system', 'info', '2026-07-07 05:05:25'),
(74, 65, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-07 05:13:28'),
(75, 65, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-07 05:16:23'),
(76, 66, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-07 05:30:24'),
(77, 65, 'dardar', 'USER_LOGIN', 'dardar logged in to system', 'info', '2026-07-07 06:38:41'),
(78, 67, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-07 07:31:05'),
(79, 67, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260707140124 was submitted by patient.', 'INFO', '2026-07-07 07:31:24'),
(80, 68, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-07 07:33:34'),
(81, 67, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260707140407 was submitted by patient.', 'INFO', '2026-07-07 07:34:07'),
(82, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 07:35:29'),
(83, 68, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-07 07:43:38'),
(84, 67, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'New blood request REQ20260707141745 was submitted by patient.', 'INFO', '2026-07-07 07:47:45'),
(85, 67, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-07 09:20:53'),
(86, 69, 'dardarwinnhtet', 'USER_LOGIN', 'dardarwinnhtet logged in to system', 'info', '2026-07-07 09:29:36'),
(87, 69, 'dardarwinnhtet', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260707161950 created', 'INFO', '2026-07-07 09:49:50'),
(88, 70, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-07 09:51:07'),
(89, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 10:10:22'),
(90, 70, 'kk', 'USER_LOGIN', 'kk logged in to system', 'info', '2026-07-07 10:14:43'),
(91, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 10:28:37'),
(92, 69, 'dardarwinnhtet1', 'USER_LOGIN', 'dardarwinnhtet1 logged in to system', 'info', '2026-07-07 10:32:43'),
(93, 70, 'kkkkkkkkkkkk', 'USER_LOGIN', 'kkkkkkkkkkkk logged in to system', 'info', '2026-07-07 10:33:21'),
(94, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 10:36:29'),
(95, 70, 'kkkkkkkkkkkk', 'USER_LOGIN', 'kkkkkkkkkkkk logged in to system', 'info', '2026-07-07 10:40:51'),
(96, 69, 'dardarwinnhtet1', 'USER_LOGIN', 'dardarwinnhtet1 logged in to system', 'info', '2026-07-07 10:42:10'),
(97, 69, 'dardarwinnhtet1', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260707171227 created', 'INFO', '2026-07-07 10:42:27'),
(98, 69, 'dardarwinnhtet1', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260707171315 created', 'INFO', '2026-07-07 10:43:15'),
(99, 69, 'dardarwinnhtet1', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260707171453 created', 'INFO', '2026-07-07 10:44:53'),
(100, 69, 'dardarwinnhtet1', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260707171517 created', 'INFO', '2026-07-07 10:45:17'),
(101, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-07 10:59:12'),
(102, 69, 'dardarwinnhtet1', 'USER_LOGIN', 'dardarwinnhtet1 logged in to system', 'info', '2026-07-07 11:00:03'),
(103, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 11:06:59'),
(104, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 13:55:32'),
(105, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-07 14:04:06'),
(106, 69, 'dardarwinnhtet1', 'USER_LOGIN', 'dardarwinnhtet1 logged in to system', 'info', '2026-07-07 14:07:35'),
(107, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-07 14:25:42'),
(108, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 15:23:09'),
(109, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 17:38:17'),
(110, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 18:03:19'),
(111, 69, 'dardarwinnhtet1', 'USER_LOGIN', 'dardarwinnhtet1 logged in to system', 'info', '2026-07-07 18:10:36'),
(112, 69, 'dardarwinnhtet1', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708004052 created', 'INFO', '2026-07-07 18:10:52'),
(113, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-07 18:40:54'),
(114, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 02:40:28'),
(115, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 02:47:11'),
(116, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 02:47:47'),
(117, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 02:48:32'),
(118, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 02:49:11'),
(119, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 02:58:38'),
(120, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:02:10'),
(121, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:02:36'),
(122, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:03:17'),
(123, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:10:42'),
(124, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:14:28'),
(125, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:20:28'),
(126, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:21:22'),
(127, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 03:27:24'),
(128, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 03:40:13'),
(129, 72, 'mm', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708101033 created', 'INFO', '2026-07-08 03:40:33'),
(130, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 03:40:57'),
(131, 71, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 03:42:19'),
(132, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 03:46:24'),
(133, 71, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 03:53:02'),
(134, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 04:01:56'),
(135, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 04:02:26'),
(136, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 04:02:51'),
(137, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 04:04:53'),
(138, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 04:05:30'),
(139, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 04:06:06'),
(140, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 04:34:31'),
(141, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 04:44:31'),
(142, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 04:45:53'),
(143, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 04:46:47'),
(144, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 04:50:33'),
(145, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 04:52:05'),
(146, 70, 'kay', 'USER_LOGIN', 'kay logged in to system', 'info', '2026-07-08 05:00:22'),
(147, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 05:00:46'),
(148, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 05:34:13'),
(149, 72, 'mm', 'USER_LOGIN', 'mm logged in to system', 'info', '2026-07-08 05:43:17'),
(150, 72, 'may', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708132527 created', 'INFO', '2026-07-08 06:55:27'),
(151, 73, 'judy', 'USER_LOGIN', 'judy logged in to system', 'info', '2026-07-08 06:57:07'),
(152, 74, 'akarilay', 'USER_LOGIN', 'akarilay logged in to system', 'info', '2026-07-08 07:11:54'),
(153, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708134218 created', 'INFO', '2026-07-08 07:12:19'),
(154, 75, 'hsumyatakari', 'USER_LOGIN', 'hsumyatakari logged in to system', 'info', '2026-07-08 07:13:45'),
(155, 75, 'hsumyatakari', 'USER_LOGIN', 'hsumyatakari logged in to system', 'info', '2026-07-08 07:17:14'),
(156, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708134812 created', 'INFO', '2026-07-08 07:18:12'),
(157, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708135434 created', 'INFO', '2026-07-08 07:24:34'),
(158, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708140129 created', 'INFO', '2026-07-08 07:31:29'),
(159, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708142435 created', 'INFO', '2026-07-08 07:54:35'),
(160, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708142827 created', 'INFO', '2026-07-08 07:58:27'),
(161, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708152349 created', 'INFO', '2026-07-08 08:53:49'),
(162, 57, 'Admin', 'USER_LOGIN', 'Admin logged in to system', 'info', '2026-07-08 09:25:47'),
(163, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708162617 created', 'INFO', '2026-07-08 09:56:17'),
(164, 74, 'akarilay', 'BLOOD_REQUEST_CREATED', 'Blood request REQ20260708162654 created', 'INFO', '2026-07-08 09:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `blood_requests`
--

CREATE TABLE `blood_requests` (
  `request_id` int(11) NOT NULL,
  `request_code` varchar(20) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `blood_group_needed` varchar(10) NOT NULL,
  `hospital_name` varchar(150) NOT NULL,
  `urgency` varchar(50) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `unit` int(11) NOT NULL DEFAULT 1,
  `donor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_requests`
--

INSERT INTO `blood_requests` (`request_id`, `request_code`, `patient_id`, `patient_name`, `blood_group_needed`, `hospital_name`, `urgency`, `contact_phone`, `status`, `created_at`, `unit`, `donor_id`) VALUES
(101, 'REQ20260708134218', 74, 'akari', 'A+', 'Grand Hospital , Yangon', 'Standard', '09671739912', 7, '2026-07-08 07:12:19', 5, NULL),
(102, 'REQ20260708134812', 74, 'akariri', 'AB+', 'Grand Hospital , Yangon', 'Standard', '09671739912', 8, '2026-07-08 07:18:12', 4, 75),
(103, 'REQ20260708135434', 74, 'kk', 'AB+', 'Grand Hospital , Yangon', 'Critical', '09671739912', 8, '2026-07-08 07:24:34', 4, 75),
(104, 'REQ20260708140129', 74, 'yy', 'AB+', 'City Hospital,Mandalay', 'Urgent', '09752591553', 8, '2026-07-08 07:31:29', 4, 75),
(105, 'REQ20260708142435', 74, 'akari', 'AB+', 'Grand Hospital , Yangon', 'Critical', '09671739912', 8, '2026-07-08 07:54:35', 4, 75),
(106, 'REQ20260708142827', 74, 'tt', 'AB+', 'Grand Hospital , Yangon', 'Urgent', '09671739912', 8, '2026-07-08 07:58:27', 4, 75),
(107, 'REQ20260708152349', 74, 'akari', 'AB+', 'Grand Hospital , Yangon', 'Urgent', '09671739912', 8, '2026-07-08 08:53:49', 4, 75),
(108, 'REQ20260708162617', 74, 'kaung', 'AB+', 'Grand Hospital , Yangon', 'Critical', '09671739912', 7, '2026-07-08 09:56:17', 4, NULL),
(109, 'REQ20260708162654', 74, 'yy', 'AB+', 'City Hospital,Mandalay', 'Critical', '09671739912', 7, '2026-07-08 09:56:54', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `donation_history`
--

CREATE TABLE `donation_history` (
  `donation_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `donation_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `last_donation_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`id`, `user_id`, `weight`, `last_donation_date`, `created_at`, `profile_photo`) VALUES
(5, 14, NULL, NULL, '2026-06-25 17:12:00', NULL),
(7, 22, NULL, NULL, '2026-06-25 20:22:18', NULL),
(8, 24, NULL, NULL, '2026-06-26 05:50:35', NULL),
(9, 26, NULL, NULL, '2026-06-26 09:35:10', NULL),
(10, 30, NULL, NULL, '2026-06-28 05:52:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` char(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `verified_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_data`
--

CREATE TABLE `master_data` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_data`
--

INSERT INTO `master_data` (`id`, `category`, `code`, `label`, `description`, `is_active`, `created_at`) VALUES
(1, 'STATUS', 'ACTIVE', 'Active', 'Active account', 1, '2026-06-26 06:58:02'),
(2, 'STATUS', 'INACTIVE', 'Inactive', 'Inactive account', 1, '2026-06-26 06:58:02'),
(3, 'STATUS', 'PENDING', 'Pending', 'Waiting for approval', 1, '2026-06-26 06:58:02'),
(4, 'STATUS', 'SUSPENDED', 'Suspended', 'Suspended account', 1, '2026-06-26 06:58:02'),
(5, 'AVAILABILITY', 'AVAILABLE', 'Available', 'Ready to donate', 1, '2026-06-26 06:58:02'),
(6, 'AVAILABILITY', 'UNAVAILABLE', 'Unavailable', 'Currently unavailable', 1, '2026-06-26 06:58:02'),
(7, 'REQUEST_STATUS', 'PENDING', 'Pending', 'Waiting for donor', 1, '2026-06-26 06:58:02'),
(8, 'REQUEST_STATUS', 'ACCEPTED', 'Accepted', 'Donor accepted', 1, '2026-06-26 06:58:02'),
(9, 'REQUEST_STATUS', 'COMPLETED', 'Completed', 'Donation completed', 1, '2026-06-26 06:58:02'),
(10, 'REQUEST_STATUS', 'CANCELLED', 'Cancelled', 'Request cancelled', 1, '2026-06-26 06:58:02'),
(11, 'RESPONSE_STATUS', 'PENDING', 'Pending', 'Waiting for donor response', 1, '2026-06-26 06:58:02'),
(12, 'RESPONSE_STATUS', 'ACCEPTED', 'Accepted', 'Donor accepted', 1, '2026-06-26 06:58:02'),
(13, 'RESPONSE_STATUS', 'DECLINED', 'Declined', 'Donor declined', 1, '2026-06-26 06:58:02'),
(14, 'NOTIFICATION_TYPE', 'REQUEST', 'Blood Request', 'New blood request notification', 1, '2026-06-26 06:58:02'),
(15, 'NOTIFICATION_TYPE', 'APPROVAL', 'Approval', 'Approval notification', 1, '2026-06-26 06:58:02'),
(16, 'NOTIFICATION_TYPE', 'REMINDER', 'Reminder', 'Reminder notification', 1, '2026-06-26 06:58:02'),
(17, 'BLOOD_GROUP', 'A_POS', 'A+', 'A Positive', 1, '2026-06-26 06:58:23'),
(18, 'BLOOD_GROUP', 'A_NEG', 'A-', 'A Negative', 1, '2026-06-26 06:58:23'),
(19, 'BLOOD_GROUP', 'B_POS', 'B+', 'B Positive', 1, '2026-06-26 06:58:23'),
(20, 'BLOOD_GROUP', 'B_NEG', 'B-', 'B Negative', 1, '2026-06-26 06:58:23'),
(21, 'BLOOD_GROUP', 'AB_POS', 'AB+', 'AB Positive', 1, '2026-06-26 06:58:23'),
(22, 'BLOOD_GROUP', 'AB_NEG', 'AB-', 'AB Negative', 1, '2026-06-26 06:58:23'),
(23, 'BLOOD_GROUP', 'O_POS', 'O+', 'O Positive', 1, '2026-06-26 06:58:23'),
(24, 'BLOOD_GROUP', 'O_NEG', 'O-', 'O Negative', 1, '2026-06-26 06:58:23'),
(25, 'URGENCY', 'LOW', 'Low', 'Low priority', 1, '2026-06-26 06:58:46'),
(26, 'URGENCY', 'MEDIUM', 'Medium', 'Medium priority', 1, '2026-06-26 06:58:46'),
(27, 'URGENCY', 'HIGH', 'High', 'High priority', 1, '2026-06-26 06:58:46'),
(28, 'URGENCY', 'CRITICAL', 'Critical', 'Immediate blood needed', 1, '2026-06-26 06:58:46'),
(29, 'MESSAGE_TYPE', 'REQUEST', 'Blood Request', 'New blood request message', 1, '2026-06-26 07:02:21'),
(30, 'MESSAGE_TYPE', 'ACCEPTED', 'Request Accepted', 'Donor accepted the blood request', 1, '2026-06-26 07:02:21'),
(31, 'MESSAGE_TYPE', 'DECLINED', 'Request Declined', 'Donor declined the blood request', 1, '2026-06-26 07:02:21'),
(32, 'MESSAGE_TYPE', 'COMPLETED', 'Donation Completed', 'Donation has been completed', 1, '2026-06-26 07:02:21'),
(33, 'MESSAGE_TYPE', 'REMINDER', 'Reminder', 'Reminder notification', 1, '2026-06-26 07:02:21'),
(34, 'MESSAGE_TYPE', 'ANNOUNCEMENT', 'Announcement', 'General system announcement', 1, '2026-06-26 07:02:21'),
(35, 'MESSAGE_TYPE', 'REQUEST', 'Blood Request', 'New blood request message', 1, '2026-06-26 07:04:43'),
(36, 'MESSAGE_TYPE', 'ACCEPTED', 'Request Accepted', 'Donor accepted the blood request', 1, '2026-06-26 07:04:43'),
(37, 'MESSAGE_TYPE', 'DECLINED', 'Request Declined', 'Donor declined the blood request', 1, '2026-06-26 07:04:43'),
(38, 'MESSAGE_TYPE', 'COMPLETED', 'Donation Completed', 'Donation completed successfully', 1, '2026-06-26 07:04:43'),
(39, 'MESSAGE_TYPE', 'REMINDER', 'Reminder', 'Reminder notification', 1, '2026-06-26 07:04:43'),
(40, 'MESSAGE_TYPE', 'ANNOUNCEMENT', 'Announcement', 'General system announcement', 1, '2026-06-26 07:04:43'),
(41, 'NOTIFICATION_TYPE', 'PROFILE_UPDATE', 'Profile Updated', NULL, 1, '2026-07-03 17:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_type_id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(50) NOT NULL DEFAULT 'general'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `notification_type_id`, `title`, `message`, `is_read`, `created_at`, `type`) VALUES
(69, 57, 14, 'New Blood Request', 'New blood request submitted by judy (AB-) and is waiting for matching donors.', 1, '2026-07-06 15:21:12', 'request'),
(71, 57, 14, 'New Blood Request', 'New blood request submitted by nick (B+) and is waiting for matching donors.', 1, '2026-07-06 15:33:48', 'request'),
(73, 57, 14, 'New Blood Request', 'New blood request submitted by dar (O+) and is waiting for matching donors.', 1, '2026-07-06 16:10:57', 'request'),
(75, 57, 14, 'New Blood Request', 'New blood request submitted by ngal (O-) and is waiting for matching donors.', 1, '2026-07-06 16:22:05', 'request'),
(80, 57, 14, 'New Blood Request', 'New blood request submitted by bunny (O+) and is waiting for matching donors.', 1, '2026-07-06 16:52:33', 'request'),
(82, 57, 14, 'New Blood Request', 'New blood request submitted by bb (AB+) and is waiting for matching donors.', 1, '2026-07-06 16:52:56', 'request'),
(84, 57, 14, 'New Blood Request', 'New blood request submitted by bunn (AB-) and is waiting for matching donors.', 1, '2026-07-06 16:53:58', 'request'),
(86, 57, 14, 'New Blood Request', 'New blood request submitted by nommi (O+) and is waiting for matching donors.', 1, '2026-07-06 17:18:50', 'request'),
(88, 57, 14, 'New Blood Request', 'New blood request submitted by dardar (AB+) and is waiting for matching donors.', 1, '2026-07-06 17:37:18', 'request'),
(92, 57, 14, 'New Blood Request', 'New blood request submitted by dar (A+) and is waiting for matching donors.', 1, '2026-07-06 17:43:39', 'request'),
(94, 57, 41, 'Patient Profile Updated', 'dardar updated their profile information.', 1, '2026-07-06 17:57:18', 'profile_update'),
(96, 57, 41, 'Patient Profile Updated', 'bunny updated their profile information.', 1, '2026-07-07 05:11:37', 'profile_update'),
(98, 57, 41, 'Patient Profile Updated', 'dardarwinnhtet updated their profile information.', 1, '2026-07-07 05:13:49', 'profile_update'),
(100, 57, 41, 'Patient Profile Updated', 'kk updated their profile information.', 1, '2026-07-07 05:30:50', 'profile_update'),
(102, 57, 14, 'New Blood Request', 'New blood request submitted by dar (O+) and is waiting for matching donors.', 1, '2026-07-07 07:31:24', 'request'),
(104, 57, 14, 'New Blood Request', 'New blood request submitted by ngal (B+) and is waiting for matching donors.', 1, '2026-07-07 07:34:07', 'request'),
(106, 57, 14, 'New Blood Request', 'New blood request submitted by judy (AB+) and is waiting for matching donors.', 1, '2026-07-07 07:47:45', 'request'),
(108, 57, 14, 'New Blood Request', 'New blood request REQ20260707161950 from kk (AB+)', 1, '2026-07-07 09:49:50', 'request'),
(110, 57, 41, 'Patient Profile Updated', 'dardarwinnhtet1 updated their profile information.', 1, '2026-07-07 10:13:40', 'profile_update'),
(112, 57, 14, 'New Blood Request', 'New blood request REQ20260707171227 from dd (AB+)', 1, '2026-07-07 10:42:27', 'request'),
(114, 57, 14, 'New Blood Request', 'New blood request REQ20260707171315 from judy (O+)', 1, '2026-07-07 10:43:15', 'request'),
(116, 57, 14, 'New Blood Request', 'New blood request REQ20260707171453 from judy (O+)', 1, '2026-07-07 10:44:53', 'request'),
(118, 57, 14, 'New Blood Request', 'New blood request REQ20260707171517 from nick (O+)', 1, '2026-07-07 10:45:17', 'request'),
(120, 57, 14, 'New Blood Request', 'New blood request REQ20260708004052 from kk (AB+)', 1, '2026-07-07 18:10:52', 'request'),
(122, 57, 14, 'New Blood Request', 'New blood request REQ20260708101033 from nick (O-)', 1, '2026-07-08 03:40:33', 'request'),
(126, 57, 41, 'Patient Profile Updated', 'may updated their profile information.', 1, '2026-07-08 06:55:01', 'profile_update'),
(128, 57, 14, 'New Blood Request', 'New blood request REQ20260708132527 from may (AB+)', 1, '2026-07-08 06:55:27', 'request'),
(129, 74, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-08 07:12:19', 'request'),
(130, 57, 14, 'New Blood Request', 'New blood request REQ20260708134218 from akari (A+)', 1, '2026-07-08 07:12:19', 'request'),
(131, 74, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-08 07:18:12', 'request'),
(132, 57, 14, 'New Blood Request', 'New blood request REQ20260708134812 from akariri (AB+)', 1, '2026-07-08 07:18:12', 'request'),
(133, 74, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-08 07:24:34', 'request'),
(134, 57, 14, 'New Blood Request', 'New blood request REQ20260708135434 from kk (AB+)', 1, '2026-07-08 07:24:34', 'request'),
(135, 74, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-08 07:31:29', 'request'),
(136, 57, 14, 'New Blood Request', 'New blood request REQ20260708140129 from yy (AB+)', 1, '2026-07-08 07:31:29', 'request'),
(137, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708140129 has been accepted by donor hsumyatakari.', 1, '2026-07-08 07:31:54', 'request'),
(138, 75, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260708140129. The patient will be notified shortly.', 1, '2026-07-08 07:31:54', 'request'),
(139, 74, 14, 'Blood Request Accepted', 'Donor hsumyatakari has accepted your blood request REQ20260708140129.', 1, '2026-07-08 07:31:54', 'request'),
(140, 74, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-08 07:54:35', 'request'),
(141, 75, 14, 'New Blood Request', 'Patient akari has requested AB+ blood. Please review the request.', 1, '2026-07-08 07:54:35', 'request'),
(142, 57, 14, 'New Blood Request', 'New blood request REQ20260708142435 from akari (AB+)', 1, '2026-07-08 07:54:35', 'request'),
(143, 74, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-08 07:58:27', 'request'),
(144, 75, 14, 'New Blood Request', 'Patient tt has requested AB+ blood. Please review the request.', 1, '2026-07-08 07:58:27', 'request'),
(145, 57, 14, 'New Blood Request', 'New blood request REQ20260708142827 from tt (AB+)', 1, '2026-07-08 07:58:27', 'request'),
(146, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708142827 has been accepted by donor hsumyatakari.', 1, '2026-07-08 07:59:01', 'request'),
(147, 75, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260708142827. The patient will be notified shortly.', 1, '2026-07-08 07:59:01', 'request'),
(148, 74, 14, 'Blood Request Accepted', 'Donor hsumyatakari has accepted your blood request REQ20260708142827.', 1, '2026-07-08 07:59:01', 'request'),
(149, 75, 41, 'Profile Updated', 'Your donor profile has been updated successfully.', 1, '2026-07-08 08:00:10', 'profile_update'),
(150, 57, 41, 'Donor Profile Updated', 'hsumyatakarilay updated their donor profile information.', 1, '2026-07-08 08:00:10', 'profile_update'),
(151, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708142435 has been accepted by donor hsumyatakarilay.', 1, '2026-07-08 08:00:39', 'request'),
(152, 75, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260708142435. The patient will be notified shortly.', 1, '2026-07-08 08:00:39', 'request'),
(153, 74, 14, 'Blood Request Accepted', 'Donor hsumyatakarilay has accepted your blood request REQ20260708142435.', 1, '2026-07-08 08:00:39', 'request'),
(154, 74, 41, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-08 08:05:21', 'profile_update'),
(155, 57, 41, 'Patient Profile Updated', 'akarilayy updated their profile information.', 1, '2026-07-08 08:05:21', 'profile_update'),
(156, 75, 41, 'Profile Updated', 'Your donor profile has been updated successfully.', 1, '2026-07-08 08:05:47', 'profile_update'),
(157, 57, 41, 'Donor Profile Updated', 'hsumyatakar updated their donor profile information.', 1, '2026-07-08 08:05:47', 'profile_update'),
(158, 75, 41, 'Profile Updated', 'Your donor profile has been updated successfully.', 1, '2026-07-08 08:06:11', 'profile_update'),
(159, 57, 41, 'Donor Profile Updated', 'hsumyatakary updated their donor profile information.', 1, '2026-07-08 08:06:11', 'profile_update'),
(160, 75, 41, 'Profile Updated', 'Your donor profile has been updated successfully.', 1, '2026-07-08 08:06:38', 'profile_update'),
(161, 57, 41, 'Donor Profile Updated', 'hsumyatakari updated their donor profile information.', 1, '2026-07-08 08:06:38', 'profile_update'),
(162, 75, 41, 'Profile Updated', 'Your donor profile has been updated successfully.', 1, '2026-07-08 08:11:18', 'profile_update'),
(163, 57, 41, 'Donor Profile Updated', 'hsumyatakarilay updated their donor profile information.', 1, '2026-07-08 08:11:18', 'profile_update'),
(164, 75, 41, 'Profile Updated', 'Your donor profile has been updated successfully.', 1, '2026-07-08 08:30:21', 'profile_update'),
(165, 57, 41, 'Donor Profile Updated', 'hsumyatakari updated their donor profile information.', 1, '2026-07-08 08:30:21', 'profile_update'),
(166, 74, 41, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-08 08:33:29', 'profile_update'),
(167, 57, 41, 'Patient Profile Updated', 'akarilay updated their profile information.', 1, '2026-07-08 08:33:29', 'profile_update'),
(168, 74, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-08 08:53:49', 'request'),
(169, 75, 14, 'New Blood Request', 'Patient akari has requested AB+ blood. Please review the request.', 1, '2026-07-08 08:53:49', 'request'),
(170, 57, 14, 'New Blood Request', 'New blood request REQ20260708152349 from akari (AB+)', 1, '2026-07-08 08:53:49', 'request'),
(171, 57, 14, 'Blood Request Accepted', 'Blood request REQ20260708152349 has been accepted by donor hsumyatakari.', 1, '2026-07-08 08:54:09', 'request'),
(172, 75, 14, 'Blood Request Accepted', 'You accepted blood request REQ20260708152349. The patient will be notified shortly.', 1, '2026-07-08 08:54:09', 'request'),
(173, 74, 14, 'Blood Request Accepted', 'Donor hsumyatakari has accepted your blood request REQ20260708152349.', 1, '2026-07-08 08:54:09', 'request'),
(174, 74, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 1, '2026-07-08 09:56:17', 'request'),
(175, 75, 14, 'New Blood Request', 'Patient kaung has requested AB+ blood. Please review the request.', 1, '2026-07-08 09:56:17', 'request'),
(176, 57, 14, 'New Blood Request', 'New blood request REQ20260708162617 from kaung (AB+)', 0, '2026-07-08 09:56:17', 'request'),
(177, 74, 14, 'Blood Request Submitted', 'Your blood request is now pending.', 0, '2026-07-08 09:56:54', 'request'),
(178, 75, 14, 'New Blood Request', 'Patient yy has requested AB+ blood. Please review the request.', 0, '2026-07-08 09:56:54', 'request'),
(179, 57, 14, 'New Blood Request', 'New blood request REQ20260708162654 from yy (AB+)', 0, '2026-07-08 09:56:54', 'request');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(100) NOT NULL,
  `permission_key` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_name`, `permission_key`, `description`, `created_at`) VALUES
(13, 'View Dashboard', 'dashboard.view', 'View dashboard', '2026-07-07 15:23:44'),
(14, 'View Profile', 'profile.view', 'View profile', '2026-07-07 15:23:44'),
(15, 'Update Profile', 'profile.update', 'Update profile', '2026-07-07 15:23:44'),
(16, 'Create Blood Request', 'blood_request.create', 'Create blood request', '2026-07-07 15:23:44'),
(17, 'View My Requests', 'blood_request.view_own', 'View own requests', '2026-07-07 15:23:44'),
(18, 'Search Donor', 'donor.search', 'Search donors', '2026-07-07 15:23:44'),
(19, 'View Matching Requests', 'blood_request.view_matching', 'View matching requests', '2026-07-07 15:23:44'),
(20, 'Accept Blood Request', 'blood_request.accept', 'Accept blood request', '2026-07-07 15:23:44'),
(21, 'Decline Blood Request', 'blood_request.decline', 'Decline blood request', '2026-07-07 15:23:44'),
(22, 'View Donation History', 'donation_history.view', 'View donation history', '2026-07-07 15:23:44'),
(23, 'View Notifications', 'notification.view', 'View notifications', '2026-07-07 15:23:44'),
(24, 'View Users', 'user.view', 'View users', '2026-07-07 15:23:44'),
(25, 'Delete Users', 'user.delete', 'Delete users', '2026-07-07 15:23:44'),
(26, 'View Donors', 'donor.view', 'View donors', '2026-07-07 15:23:44'),
(27, 'Delete Donors', 'donor.delete', 'Delete donors', '2026-07-07 15:23:44'),
(28, 'View Statistics', 'statistics.view', 'Dashboard statistics', '2026-07-07 15:23:44'),
(29, 'View Activity Log', 'activity_log.view', 'View system activity', '2026-07-07 15:23:44'),
(30, 'Manage User Types', 'user_type.manage', 'Manage roles', '2026-07-07 15:23:44'),
(31, 'Manage Permissions', 'permission.manage', 'Assign permissions', '2026-07-07 15:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `request_donors`
--

CREATE TABLE `request_donors` (
  `request_donor_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `response_status_id` int(11) NOT NULL,
  `response_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_type_id` int(11) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_code` varchar(10) DEFAULT NULL,
  `verification_expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_login` tinyint(1) DEFAULT 0,
  `blood_group_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `phone`, `password`, `blood_group`, `address`, `status_id`, `available`, `created_at`, `username`, `updated_at`, `deleted_at`, `user_type_id`, `is_verified`, `verification_code`, `verification_expires_at`, `is_active`, `is_login`, `blood_group_code`) VALUES
(57, 'adminbloodconnect@gmail.com', NULL, '$2y$10$5efVnZlim6W66nsKyKhcW.nizpGZE1xGhYrmhjJlJJ1VEQQJllK2u', 'A_POS', NULL, 1, 1, '2026-07-05 16:13:33', 'Admin', '2026-07-06 06:29:05', NULL, 1, 1, NULL, NULL, 1, 0, NULL),
(73, 'judy@gmail.com', '09765732081', '$2y$10$HLPebPwk88ANszYYRFc6UOx1k.oLac83ElomWiBZyGnv6OfIdHlOK', 'O+', 'yangon', 3, 1, '2026-07-08 06:56:32', 'judy', '2026-07-08 07:00:18', NULL, 2, 1, NULL, NULL, 1, 0, NULL),
(74, 'akari@gmail.com', '09765732081', '$2y$10$aqfuA8xV93WZYBknOIakMOcdN96NVTASwKL7SB4jS.IjeV70sPnHa', 'A+', 'yangon', 3, 1, '2026-07-08 07:11:11', 'akarilay', '2026-07-08 08:33:29', NULL, 3, 1, NULL, NULL, 1, 0, NULL),
(75, 'hsumyatakari@gmail.com', '09795535556', '$2y$10$bMmYx/prLuWxU5veMrUwA.fSPXXETkdlHydkY.M8oAnRDwzBEwXxe', 'AB+', 'yangon', 3, 1, '2026-07-08 07:13:13', 'hsumyatakari', '2026-07-08 08:30:21', NULL, 2, 1, NULL, NULL, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `permissions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `name`, `permissions`, `created_at`) VALUES
(1, 'admin', '*', '2026-07-07 12:46:52'),
(2, 'donor', 'dashboard,blood_requests,accept_request,profile,notifications,history', '2026-07-07 12:46:52'),
(3, 'patient', 'dashboard,request_blood,search_donor,my_requests,profile,notifications', '2026-07-07 12:46:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_type_permissions`
--

CREATE TABLE `user_type_permissions` (
  `user_type_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type_permissions`
--

INSERT INTO `user_type_permissions` (`user_type_id`, `permission_id`) VALUES
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 31),
(3, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 26),
(3, 27),
(3, 28),
(3, 29),
(3, 31);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD UNIQUE KEY `request_code` (`request_code`),
  ADD KEY `status_id` (`status`),
  ADD KEY `blood_requests_ibfk_1` (`patient_id`);

--
-- Indexes for table `donation_history`
--
ALTER TABLE `donation_history`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `status_id` (`status`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `fk_email_verification_user` (`user_id`);

--
-- Indexes for table `master_data`
--
ALTER TABLE `master_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notification_type_id` (`notification_type_id`),
  ADD KEY `notifications_ibfk_1` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `permission_key` (`permission_key`);

--
-- Indexes for table `request_donors`
--
ALTER TABLE `request_donors`
  ADD PRIMARY KEY (`request_donor_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `response_status_id` (`response_status_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `availability_id` (`available`),
  ADD KEY `fk_users_user_types` (`user_type_id`),
  ADD KEY `fk_user_status` (`status_id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user_type_permissions`
--
ALTER TABLE `user_type_permissions`
  ADD PRIMARY KEY (`user_type_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `donation_history`
--
ALTER TABLE `donation_history`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_data`
--
ALTER TABLE `master_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `request_donors`
--
ALTER TABLE `request_donors`
  MODIFY `request_donor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `blood_requests_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blood_requests_ibfk_2` FOREIGN KEY (`status`) REFERENCES `master_data` (`id`);

--
-- Constraints for table `donation_history`
--
ALTER TABLE `donation_history`
  ADD CONSTRAINT `donation_history_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `blood_requests` (`request_id`),
  ADD CONSTRAINT `donation_history_ibfk_2` FOREIGN KEY (`donor_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `donation_history_ibfk_3` FOREIGN KEY (`status`) REFERENCES `master_data` (`id`);

--
-- Constraints for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD CONSTRAINT `fk_email_verification_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`notification_type_id`) REFERENCES `master_data` (`id`);

--
-- Constraints for table `request_donors`
--
ALTER TABLE `request_donors`
  ADD CONSTRAINT `request_donors_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `blood_requests` (`request_id`),
  ADD CONSTRAINT `request_donors_ibfk_2` FOREIGN KEY (`donor_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `request_donors_ibfk_3` FOREIGN KEY (`response_status_id`) REFERENCES `master_data` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_status` FOREIGN KEY (`status_id`) REFERENCES `master_data` (`id`),
  ADD CONSTRAINT `fk_users_user_types` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_type_permissions`
--
ALTER TABLE `user_type_permissions`
  ADD CONSTRAINT `user_type_permissions_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_type_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
