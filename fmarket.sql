--
-- Database: `fmarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact_no` varchar(200) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`username`, `password`, `Name`, `email`, `contact_no`) VALUES
('aaa', 'aaa', 'aaa', 'aaa', 'aaa'),
('aaa1', 'aaa', 'aaa', 'aaa', 'aaa'),
('dddddd', '1dddddd', 'Ddd Dd', 'd@d', '123456'),
-- --------------------------------------------------------

--
-- Table structure for table `freelancer`
--

CREATE TABLE `freelancer` (
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact_no` varchar(200) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `freelancer`
--

INSERT INTO `freelancer` (`username`, `password`, `Name`, `email`, `contact_no`) VALUES
('ffffff', '1ffffff', 'f', 'f@f', '123456'),
('freelancer1', '111111', 'Freelancer One', 'f@f1', '123456'),
('freelancer2', '111111', 'Freelancer Two', 'f@f2', '123456'),

-- --------------------------------------------------------

--
-- Table structure for table `job_offer`
--

CREATE TABLE `job_offer` (
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `e_username` varchar(200) NOT NULL,
  `valid` tinyint(1) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_offer`
--

INSERT INTO `job_offer` (`job_id`, `title`, `type`, `description`, `e_username`, `valid`) VALUES
(1, 'jjj', 'kkk', 'lll', 0, '', '20', 0),
(2, 'kk', 'k', 'l', 'h', 1),
(3, 'b', 'm', 'n', 'd', 2),

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `sender` varchar(200) NOT NULL,
  `receiver` varchar(200) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `selected`
--

CREATE TABLE `selected` (
  `f_username` varchar(200) NOT NULL,
  `job_id` varchar(30) NOT NULL,
  `e_username` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `selected`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `freelancer`
--
ALTER TABLE `freelancer`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `job_offer`
--
ALTER TABLE `job_offer`
  ADD PRIMARY KEY (`job_id`),
  ADD UNIQUE KEY `job_id` (`job_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `job_offer`
--
ALTER TABLE `job_offer`
  MODIFY `job_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
