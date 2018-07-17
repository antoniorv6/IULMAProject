-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-07-2018 a las 12:43:24
-- Versión del servidor: 10.1.24-MariaDB
-- Versión de PHP: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `metapress`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `column`
--

CREATE TABLE `column` (
  `ID` int(11) NOT NULL,
  `Author_surname` varchar(100) COLLATE utf8_bin NOT NULL,
  `Author_Name` varchar(100) COLLATE utf8_bin NOT NULL,
  `Title` varchar(100) COLLATE utf8_bin NOT NULL,
  `Place` varchar(100) COLLATE utf8_bin NOT NULL,
  `Dateofcreation` varchar(100) COLLATE utf8_bin NOT NULL,
  `Col` varchar(100) COLLATE utf8_bin NOT NULL,
  `Source` varchar(100) COLLATE utf8_bin NOT NULL,
  `Medium` varchar(100) COLLATE utf8_bin NOT NULL,
  `Language_written` varchar(100) COLLATE utf8_bin NOT NULL,
  `Country` varchar(100) COLLATE utf8_bin NOT NULL,
  `First_Insert` varchar(100) COLLATE utf8_bin NOT NULL,
  `Last_Insert` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editor`
--

CREATE TABLE `editor` (
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `password` varchar(10) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `surname` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `editor`
--

INSERT INTO `editor` (`email`, `password`, `name`, `surname`) VALUES
('ariosvila@gmail.com', 'antonio', 'Antonio', 'Rios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `session`
--

CREATE TABLE `session` (
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `dispositive` varchar(46) COLLATE utf8_bin NOT NULL,
  `timeoflogin` datetime NOT NULL,
  `token` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `session`
--

INSERT INTO `session` (`email`, `dispositive`, `timeoflogin`, `token`) VALUES
('ariosvila@gmail.com', '::1', '2018-07-17 11:55:09', 'b4ff5d2a1a9c2b6bcd12246ea0624975');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `column`
--
ALTER TABLE `column`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `editor`
--
ALTER TABLE `editor`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`email`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `column`
--
ALTER TABLE `column`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`email`) REFERENCES `editor` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
