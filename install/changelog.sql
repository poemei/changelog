SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `changelog`
--

CREATE TABLE `changelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5,
  `version` varchar(20) NOT NULL,
  `category` enum('Feature','Fix','Security','Maintenance','Release','Development') DEFAULT 'Feature',
  `description` text NOT NULL,
  `date_released` date NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `changelog`
--
ALTER TABLE `changelog`
  ADD PRIMARY KEY (`id`);

