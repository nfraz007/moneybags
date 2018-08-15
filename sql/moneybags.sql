-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: fdb16.biz.nf
-- Generation Time: Aug 15, 2018 at 12:28 PM
-- Server version: 5.7.20-log
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `moneybags`
--

-- --------------------------------------------------------

--
-- Table structure for table `moneybags_currency`
--

CREATE TABLE `moneybags_currency` (
  `currency_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `short` varchar(100) NOT NULL,
  `html` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moneybags_currency`
--

INSERT INTO `moneybags_currency` (`currency_id`, `name`, `short`, `html`, `status`) VALUES
(1, 'Rupee', 'INR', '&#8377;', 1),
(2, 'Dollar', 'USD', '$', 1),
(3, 'Euro', 'EUR', '&#8364;', 1);

-- --------------------------------------------------------

--
-- Table structure for table `moneybags_date`
--

CREATE TABLE `moneybags_date` (
  `date_id` int(11) NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moneybags_date`
--

INSERT INTO `moneybags_date` (`date_id`, `date`) VALUES
(1, 'M-d-Y'),
(2, 'm/d/Y'),
(3, 'm/d/y'),
(4, 'd-M-Y'),
(5, 'd/m/Y'),
(6, 'd/m/y');

-- --------------------------------------------------------

--
-- Table structure for table `moneybags_money`
--

CREATE TABLE `moneybags_money` (
  `money_id` bigint(20) NOT NULL,
  `people_id` bigint(20) NOT NULL,
  `amount` int(11) NOT NULL COMMENT '+ve user get money, -ve user paid money',
  `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remark` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `moneybags_people`
--

CREATE TABLE `moneybags_people` (
  `people_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL COMMENT '+ve user will get money, -ve user have to pay money',
  `datetime` datetime NOT NULL,
  `popular` bigint(20) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `moneybags_user`
--

CREATE TABLE `moneybags_user` (
  `user_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL DEFAULT '1',
  `date_id` int(11) NOT NULL DEFAULT '1',
  `email` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `verified` tinyint(4) NOT NULL,
  `registered_on` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moneybags_user`
--

INSERT INTO `moneybags_user` (`user_id`, `currency_id`, `date_id`, `email`, `fname`, `lname`, `password`, `gender`, `verified`, `registered_on`, `status`) VALUES
(2, 1, 4, 'nfraz007@gmail.com', 'Nazish', 'Fraz', '123456', 'male', 1, '2017-04-02 18:52:13', 1),
(3, 1, 1, 'test@gmail.com', 'N', 'F', 'e10adc3949ba59abbe56e057f20f883e', 'male', 1, '2017-04-10 23:59:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `moneybags_user_history`
--

CREATE TABLE `moneybags_user_history` (
  `history_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `moneybags_currency`
--
ALTER TABLE `moneybags_currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `moneybags_date`
--
ALTER TABLE `moneybags_date`
  ADD PRIMARY KEY (`date_id`);

--
-- Indexes for table `moneybags_money`
--
ALTER TABLE `moneybags_money`
  ADD PRIMARY KEY (`money_id`);

--
-- Indexes for table `moneybags_people`
--
ALTER TABLE `moneybags_people`
  ADD PRIMARY KEY (`people_id`);

--
-- Indexes for table `moneybags_user`
--
ALTER TABLE `moneybags_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `moneybags_user_history`
--
ALTER TABLE `moneybags_user_history`
  ADD PRIMARY KEY (`history_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `moneybags_currency`
--
ALTER TABLE `moneybags_currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `moneybags_date`
--
ALTER TABLE `moneybags_date`
  MODIFY `date_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `moneybags_money`
--
ALTER TABLE `moneybags_money`
  MODIFY `money_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `moneybags_people`
--
ALTER TABLE `moneybags_people`
  MODIFY `people_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `moneybags_user`
--
ALTER TABLE `moneybags_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `moneybags_user_history`
--
ALTER TABLE `moneybags_user_history`
  MODIFY `history_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;