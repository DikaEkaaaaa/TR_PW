-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 03:25 AM
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
-- Database: `db_job`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_applications`
--

CREATE TABLE `tb_applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_applications`
--

INSERT INTO `tb_applications` (`id`, `user_id`, `job_id`, `status`, `applied_at`) VALUES
(13, 15, 14, 'Rejected', '2024-12-02 13:49:31'),
(15, 15, 16, 'Accepted', '2024-12-02 14:43:51'),
(16, 18, 18, 'Accepted', '2024-12-03 01:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jobs`
--

CREATE TABLE `tb_jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `employment_type` enum('intern','full-time') NOT NULL,
  `salary_range` varchar(100) DEFAULT NULL,
  `company_name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','expired','deleted') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_jobs`
--

INSERT INTO `tb_jobs` (`id`, `title`, `description`, `requirements`, `employment_type`, `salary_range`, `company_name`, `location`, `created_at`, `updated_at`, `created_by`, `expired_at`, `status`) VALUES
(14, 'Laboran', 'Laboran adalah pekerjaan yang fokus pada teknisi dan troubleshooting', 'Umur 18+\r\nMahasiswa Aktif FTI UKSW', 'intern', '2000000', 'FTI UKSW', 'Salatiga', '2024-12-02 03:50:49', '2024-12-02 14:05:08', 10, NULL, 'active'),
(16, 'Halo', 'Halo', 'Halo', 'full-time', '2000', 'Kucingan', 'Blotongan', '2024-12-02 14:40:38', '2024-12-02 14:50:49', 0, NULL, 'expired'),
(17, 'Karyawan Teknisi', 'Memperbaiki permasalahan teknis dalam kantor', 'Pengalaman 3 tahun\r\nUmur 18 tahun', 'full-time', '2000000', 'PT PENCARI CINTA SEJATI', 'Salatiga', '2024-12-03 01:16:22', '2024-12-03 01:16:22', 17, NULL, 'active'),
(18, 'Sekertaris Direktur', 'Menyiapkan Rapat dan Meeting dan lain-lain', 'Lulusan Akademis Sekertari\r\nTOEFL 500', 'intern', '1500000', 'Kantor Laboran FTI', 'Salatiga', '2024-12-03 01:18:19', '2024-12-03 01:18:19', 17, NULL, 'active'),
(19, 'asd', 'asd', 'ads', 'intern', '2000000', 'asd', 'ads', '2024-12-03 02:00:09', '2024-12-03 02:00:09', 0, NULL, 'active'),
(20, 'asda', 'dsad', 'asda', 'intern', '12', 'asd', 'asd', '2024-12-03 02:03:50', '2024-12-03 02:03:50', 9, NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tb_job_history`
--

CREATE TABLE `tb_job_history` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  `updated_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_job_history`
--

INSERT INTO `tb_job_history` (`id`, `job_id`, `title`, `status`, `updated_at`, `updated_by`) VALUES
(6, 16, 'Halo', 'expired', '2024-12-02 21:50:49', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_profiles`
--

CREATE TABLE `tb_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_profiles`
--

INSERT INTO `tb_profiles` (`id`, `user_id`, `full_name`, `email`, `phone_number`, `address`, `experience`, `skills`, `created_at`, `updated_at`) VALUES
(1, 11, 'Budiono Siregar', 'kapallawd@gmail.com', '088899994444', 'PC aja', 'Iso Renang Kedalaman 5meter', 'Iso renang masseh', '2024-12-02 04:10:26', '2024-12-02 04:13:49'),
(4, 15, 'Dikaeka', 'aemlnx18@gmail.com', '088899994444', 'v', 'vv', 'v', '2024-12-02 13:45:31', '2024-12-02 13:45:31'),
(5, 18, 'Budiono Siregar', 'test@test.com', '088899994444', 'Blotongan, Salatiga', 'Pernah menjadi sekertaris RT', 'Mengetik Sebelas Jari', '2024-12-03 01:20:36', '2024-12-03 01:20:36');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Employee','Employer','Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `nama`, `password`, `role`) VALUES
(9, 'admin', '$2y$10$LC8LOXFngbM4zcXj.cx3Le70W57ITtkO4ijvB2PGa0rLA1BGtd69K', 'Admin'),
(10, 'PTUKSW', '$2y$10$E6s6PJJT.LhjzhkWGcF1Bu8j2bk5scEkOYJS2frWIy8lhqWaRXp2m', 'Employer'),
(11, 'Pendaftar', '$2y$10$wBdQfhJe69TVvgOfv1MnGunHlIOgt3SudgzYkjcxZcQaBa1fMi4lu', 'Employee'),
(13, 'hello', '$2y$10$Wi.Dd4q/TH935QVvcH9LGeAEWB7EsE8JG4JnEp3GxpqwyU2gVnQEK', 'Employee'),
(15, 'dika', '$2y$10$OXEGuxZAKgdvDNuUanhda.Z5kAajTu5GCSxUiZNwmwPpnBAQSHxHi', 'Employee'),
(16, 'saya', '$2y$10$iJFa/7EuUZkXrQ5dr4BNY.NMFwFuK04aBiyRYI8Lj0aqojT4Y1ipy', 'Employee'),
(17, 'testdaftar', '$2y$10$7Nm1xQPrq5JShv/1VsdTYen3BJqmCjbMZOXaD.xc8owAJ6X9yA/Ey', 'Employer'),
(18, 'pencarikerja', '$2y$10$Vhy7fhOj0pgnojJdQwzCju.lLlH4M1Zy8X5AH3xYwkFf/2ujcB/bC', 'Employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_applications`
--
ALTER TABLE `tb_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `tb_jobs`
--
ALTER TABLE `tb_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `tb_job_history`
--
ALTER TABLE `tb_job_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `tb_profiles`
--
ALTER TABLE `tb_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_applications`
--
ALTER TABLE `tb_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_jobs`
--
ALTER TABLE `tb_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_job_history`
--
ALTER TABLE `tb_job_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_profiles`
--
ALTER TABLE `tb_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_applications`
--
ALTER TABLE `tb_applications`
  ADD CONSTRAINT `tb_applications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`),
  ADD CONSTRAINT `tb_applications_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `tb_jobs` (`id`);

--
-- Constraints for table `tb_jobs`
--
ALTER TABLE `tb_jobs`
  ADD CONSTRAINT `tb_jobs_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `tb_users` (`id`);

--
-- Constraints for table `tb_job_history`
--
ALTER TABLE `tb_job_history`
  ADD CONSTRAINT `tb_job_history_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tb_jobs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_profiles`
--
ALTER TABLE `tb_profiles`
  ADD CONSTRAINT `tb_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
