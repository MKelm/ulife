-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2014 at 07:30 PM
-- Server version: 5.5.40-0+wheezy1
-- PHP Version: 5.4.35-0+deb7u2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ulife`
--

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE IF NOT EXISTS `buildings` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `title` varchar(64) NOT NULL,
  `text` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buildings_levels`
--

CREATE TABLE IF NOT EXISTS `buildings_levels` (
`id` int(10) unsigned NOT NULL,
  `building_id` int(10) unsigned NOT NULL,
  `number` int(10) unsigned NOT NULL,
  `rl_number` int(10) unsigned NOT NULL,
  `c_wood` int(10) unsigned NOT NULL,
  `c_stones` int(10) unsigned NOT NULL,
  `c_workers` int(10) unsigned NOT NULL,
  `c_rounds` int(10) unsigned NOT NULL,
  `volume` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `name` varchar(64) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `research_fields`
--

CREATE TABLE IF NOT EXISTS `research_fields` (
`id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `title` varchar(64) NOT NULL,
  `text` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `research_levels`
--

CREATE TABLE IF NOT EXISTS `research_levels` (
`id` int(10) unsigned NOT NULL,
  `field_id` int(10) unsigned NOT NULL,
  `number` int(10) unsigned NOT NULL,
  `researchers` int(10) unsigned NOT NULL,
  `experience` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE IF NOT EXISTS `units` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `title` varchar(64) NOT NULL,
  `text` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `units_levels`
--

CREATE TABLE IF NOT EXISTS `units_levels` (
`id` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `number` int(11) NOT NULL,
  `rl_number` int(11) NOT NULL,
  `t_coins` int(10) unsigned NOT NULL,
  `t_rounds` int(10) unsigned NOT NULL,
  `volume` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(64) NOT NULL,
  `wood` int(10) unsigned NOT NULL,
  `stones` int(10) unsigned NOT NULL,
  `food` int(10) unsigned NOT NULL,
  `coins` int(10) unsigned NOT NULL,
  `citizen` int(10) unsigned NOT NULL,
  `experience` int(10) unsigned NOT NULL,
  `registration` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_builders`
--

CREATE TABLE IF NOT EXISTS `users_builders` (
  `unit_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `building_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_buildings`
--

CREATE TABLE IF NOT EXISTS `users_buildings` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `building_id` int(10) unsigned NOT NULL,
  `level_id` int(10) unsigned NOT NULL,
  `start_round` int(10) unsigned NOT NULL,
  `end_round` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_research`
--

CREATE TABLE IF NOT EXISTS `users_research` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `field_id` int(10) unsigned NOT NULL,
  `field_level_id` int(10) unsigned NOT NULL,
  `start_round` int(10) unsigned NOT NULL,
  `end_round` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_researchers`
--

CREATE TABLE IF NOT EXISTS `users_researchers` (
  `unit_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `research_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_units`
--

CREATE TABLE IF NOT EXISTS `users_units` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `level_id` int(10) unsigned NOT NULL,
  `start_round` int(10) unsigned NOT NULL,
  `end_round` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
 ADD PRIMARY KEY (`id`), ADD KEY `title` (`title`);

--
-- Indexes for table `buildings_levels`
--
ALTER TABLE `buildings_levels`
 ADD PRIMARY KEY (`id`), ADD KEY `building_id` (`building_id`), ADD KEY `number` (`number`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
 ADD PRIMARY KEY (`name`);

--
-- Indexes for table `research_fields`
--
ALTER TABLE `research_fields`
 ADD PRIMARY KEY (`id`), ADD KEY `parent_id` (`parent_id`), ADD KEY `title` (`title`);

--
-- Indexes for table `research_levels`
--
ALTER TABLE `research_levels`
 ADD PRIMARY KEY (`id`), ADD KEY `field_id` (`field_id`), ADD KEY `number` (`number`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units_levels`
--
ALTER TABLE `units_levels`
 ADD PRIMARY KEY (`id`), ADD KEY `unit_id` (`unit_id`), ADD KEY `number` (`number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users_builders`
--
ALTER TABLE `users_builders`
 ADD PRIMARY KEY (`unit_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_buildings`
--
ALTER TABLE `users_buildings`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `time` (`start_round`);

--
-- Indexes for table `users_research`
--
ALTER TABLE `users_research`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_researchers`
--
ALTER TABLE `users_researchers`
 ADD PRIMARY KEY (`unit_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_units`
--
ALTER TABLE `users_units`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `time` (`end_round`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `buildings_levels`
--
ALTER TABLE `buildings_levels`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `research_fields`
--
ALTER TABLE `research_fields`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `research_levels`
--
ALTER TABLE `research_levels`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `units_levels`
--
ALTER TABLE `units_levels`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_buildings`
--
ALTER TABLE `users_buildings`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_research`
--
ALTER TABLE `users_research`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_units`
--
ALTER TABLE `users_units`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;