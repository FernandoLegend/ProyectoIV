-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-02-2025 a las 05:43:39
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_personal_admin_system`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assignament`
--

CREATE TABLE `assignament` (
  `id` int(1) NOT NULL,
  `direction` varchar(60) NOT NULL,
  `description` varchar(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `rif` varchar(30) NOT NULL,
  `tlf.` int(20) NOT NULL,
  `director` varchar(255) NOT NULL,
  `nivel_academico` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `family_list`
--

CREATE TABLE `family_list` (
  `id` int(5) NOT NULL,
  `staff_id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `relationship` varchar(20) NOT NULL,
  `birthdate` date NOT NULL,
  `directory` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hiring_periods`
--

CREATE TABLE `hiring_periods` (
  `id` int(20) NOT NULL,
  `staff_id` int(20) NOT NULL,
  `in_date` date NOT NULL,
  `off_date` date DEFAULT NULL,
  `type_in` varchar(50) NOT NULL,
  `type_off` varchar(50) DEFAULT NULL,
  `workstation` varchar(255) NOT NULL,
  `salary` int(10) NOT NULL,
  `cargo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff_list`
--

CREATE TABLE `staff_list` (
  `id` int(4) NOT NULL,
  `assignment_id` int(5) NOT NULL,
  `working_status` int(1) DEFAULT NULL,
  `date_in` date DEFAULT NULL,
  `date_off` date DEFAULT NULL,
  `names` varchar(255) NOT NULL,
  `surnames` varchar(255) NOT NULL,
  `identity_card_number` varchar(11) NOT NULL,
  `directory` varchar(100) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `date_create` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_system`
--

CREATE TABLE `users_system` (
  `user` varchar(20) NOT NULL,
  `pass_word` varchar(20) NOT NULL,
  `security_lvl` varchar(1) NOT NULL,
  `token` varchar(32) DEFAULT NULL,
  `token_expiracion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users_system`
--

INSERT INTO `users_system` (`user`, `pass_word`, `security_lvl`, `token`, `token_expiracion`) VALUES
('admin', 'admin', '0', 'd7b6f4e41dbc2c4ab8029a374cb6eceb', '2025-02-06 06:11:49'),
('fernando', 'fernando', '1', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `assignament`
--
ALTER TABLE `assignament`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `family_list`
--
ALTER TABLE `family_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hiring_periods`
--
ALTER TABLE `hiring_periods`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `staff_list`
--
ALTER TABLE `staff_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `assignament`
--
ALTER TABLE `assignament`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `family_list`
--
ALTER TABLE `family_list`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hiring_periods`
--
ALTER TABLE `hiring_periods`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `staff_list`
--
ALTER TABLE `staff_list`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
