-- Server version: 10.3.37-MariaDB-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schedules`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(1000) NOT NULL,
  `name` text NOT NULL,
  `profile` text NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{"timetable":[{"day":"Monday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Tuesday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Wednesday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Thursday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]},{"day":"Friday","schedule":[{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""},{"subject":"","room":"","message":""}]}],"periods":[{"start":"08:00","end":"09:20"},{"start":"09:20","end":"09:40"},{"start":"09:40","end":"11:00"},{"start":"11:10","end":"12:30"},{"start":"12:45","end":"13:45"},{"start":"13:45","end":"15:05"},{"start":"15:10","end":"16:30"}],"colors":{},"other":{"timeSkipNextDay":{"enabled":true,"time":1020}}}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
