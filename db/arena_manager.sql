-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 16, 2016 at 11:30 PM
-- Server version: 5.6.30-0ubuntu0.15.10.1
-- PHP Version: 5.6.11-1ubuntu3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fotrrisdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `arena_manager`
--

CREATE TABLE IF NOT EXISTS `arena_manager` (
  `id_arena` int(11) NOT NULL COMMENT 'id arena for arena ',
  `id_user` int(11) NOT NULL COMMENT 'id user for arena',
  `sn_active` varchar(1) COLLATE utf8mb4_bin NOT NULL DEFAULT 'S' COMMENT 'registro activo o no de la tabla arena_manager',
  `user_create` varchar(30) COLLATE utf8mb4_bin NOT NULL COMMENT 'creador de la tabla',
  `user_modif` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'user modificador de la tabla',
  `date_create` date NOT NULL COMMENT 'fecha de creacion de la tabla arena_manager',
  `date_modif` date DEFAULT NULL COMMENT 'fecha de modificacion de la tabla '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

