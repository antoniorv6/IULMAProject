-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2018 a las 11:39:05
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
-- Estructura de tabla para la tabla `administrator`
--

CREATE TABLE `administrator` (
  `email` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `administrator`
--

INSERT INTO `administrator` (`email`) VALUES
('ariosvila@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `column`
--

CREATE TABLE `column` (
  `ID` int(11) NOT NULL,
  `Abbreviation` varchar(100) COLLATE utf8_bin NOT NULL,
  `Author_surname` varchar(100) COLLATE utf8_bin NOT NULL,
  `Author_Name` varchar(100) COLLATE utf8_bin NOT NULL,
  `Title` varchar(100) COLLATE utf8_bin NOT NULL,
  `gen_title` varchar(100) COLLATE utf8_bin NOT NULL,
  `Place` varchar(100) COLLATE utf8_bin NOT NULL,
  `Dateofcreation` varchar(100) COLLATE utf8_bin NOT NULL,
  `Col` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `Source` varchar(100) COLLATE utf8_bin NOT NULL,
  `Medium` varchar(100) COLLATE utf8_bin NOT NULL,
  `Language_written` varchar(100) COLLATE utf8_bin NOT NULL,
  `Country` varchar(100) COLLATE utf8_bin NOT NULL,
  `First_Insert` varchar(100) COLLATE utf8_bin NOT NULL,
  `Last_Insert` varchar(100) COLLATE utf8_bin NOT NULL,
  `Filepath` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `column`
--

INSERT INTO `column` (`ID`, `Abbreviation`, `Author_surname`, `Author_Name`, `Title`, `gen_title`, `Place`, `Dateofcreation`, `Col`, `Source`, `Medium`, `Language_written`, `Country`, `First_Insert`, `Last_Insert`, `Filepath`) VALUES
(15, 'CorCTPlu16072013 ', 'Cortelazzo', ' Michele', 'I capolavori formali delle circolari scolastiche italiane', ' Plurilingua', ' Lugano', ' 16 luglio 2013', ' col 5-6', ' Corriere del Ticino', ' stampa', ' italiano', ' Svizzera ', 'ariosvila@gmail.com', 'ariosvila@gmail.com', 'uploaded/test_real_lorem.docx'),
(16, 'CoreCat2588', 'Rivers', 'Antonio', 'I capolavori formali delle circolari scolastiche italiane', ' Plurilingua', ' Lugano', ' 16 luglio 2013', ' col 5-6', ' Corriere del Ticino', ' stampa', ' italiano', ' Svizzera ', 'ariosvila@gmail.com', 'ariosvila@gmail.com', 'uploaded/test_real_lorem.docx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `content`
--

CREATE TABLE `content` (
  `article` int(100) NOT NULL,
  `textcontent` longtext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `content`
--

INSERT INTO `content` (`article`, `textcontent`) VALUES
(15, 'Cortelazzo, Michele, Plurilingua, Corriere del Ticino, Lugano, 16 luglio 2013, p.16, col 5-6, stampa, italiano, Svizzera \r\nCorCTPlu16072013 \r\nI capolavori formali delle circolari scolastiche italiane.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut facilisis at magna a vehicula. Morbi eget odio urna. Duis quis scelerisque metus. Nam facilisis felis non rutrum feugiat. Duis eget rutrum ipsum. Suspendisse euismod eget nisl nec ultricies. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\r\nSed aliquet lorem vitae sem cursus, in semper velit facilisis. Aenean porta mi quis felis tempus, sit amet semper libero tempor. Vivamus maximus leo orci, in cursus augue condimentum eget. Quisque eget leo sit amet lectus varius condimentum. Donec eget est interdum, commodo turpis at, cursus enim. Sed eu quam ut diam sollicitudin semper. In laoreet sollicitudin risus, sed porta ex egestas a. Integer quam arcu, auctor eu aliquam ut, maximus eget magna. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque non velit lacus. Fusce dui felis, congue ac laoreet at, viverra in risus.\r\nCurabitur sapien risus, pharetra vel suscipit sit amet, mollis at lacus. Suspendisse ut faucibus ligula. Etiam sed est sem. Ut aliquam mauris at urna hendrerit ultrices. Mauris pharetra dui a scelerisque volutpat. Nunc vel orci quam. Curabitur in velit ac est cursus vehicula sit amet eu erat. Donec eu arcu bibendum, feugiat libero et, fringilla nisl. Nullam commodo est consequat arcu placerat auctor. Donec a vulputate felis. Praesent leo velit, dignissim eu volutpat eget, pharetra sit amet justo. Nulla facilisi. Fusce faucibus ante et nunc malesuada, posuere viverra risus tincidunt. Maecenas lobortis molestie urna, volutpat congue neque laoreet nec. Duis iaculis libero a diam mollis, sit amet porta augue viverra.\r\nNam ut risus eget quam blandit aliquam. Integer vitae bibendum risus, eu dapibus lectus. Ut quis enim odio. Nulla nisl leo, pulvinar vitae sodales vitae, porta eget arcu. Maecenas cursus eros urna, quis dapibus ante congue at. Suspendisse molestie lorem sed volutpat consequat. Fusce semper felis a aliquam ullamcorper. Duis non neque at neque accumsan dignissim quis eu nisl. Ut consequat dui eu aliquet auctor. Pellentesque tincidunt molestie leo, vel ullamcorper lacus posuere posuere.\r\nPellentesque tincidunt, quam et aliquet elementum, risus sem dapibus augue, nec vestibulum metus mauris a nunc. Mauris laoreet mi sit amet tellus commodo egestas. Suspendisse sit amet elementum quam, in luctus tortor. Proin eget risus ac libero semper interdum. Nunc lacinia, lacus vel malesuada luctus, mi erat sagittis neque, vitae placerat magna turpis quis orci. Suspendisse ultrices tempor dapibus. Proin feugiat ipsum est, eget scelerisque urna viverra id. Interdum et malesuada fames ac ante ipsum primis in faucibus.\r\n'),
(16, 'Cortelazzo, Michele, Plurilingua, Corriere del Ticino, Lugano, 16 luglio 2013, p.16, col 5-6, stampa, italiano, Svizzera \r\nCorCTPlu16072013 \r\nI capolavori formali delle circolari scolastiche italiane.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut facilisis at magna a vehicula. Morbi eget odio urna. Duis quis scelerisque metus. Nam facilisis felis non rutrum feugiat. Duis eget rutrum ipsum. Suspendisse euismod eget nisl nec ultricies. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\r\nSed aliquet lorem vitae sem cursus, in semper velit facilisis. Aenean porta mi quis felis tempus, sit amet semper libero tempor. Vivamus maximus leo orci, in cursus augue condimentum eget. Quisque eget leo sit amet lectus varius condimentum. Donec eget est interdum, commodo turpis at, cursus enim. Sed eu quam ut diam sollicitudin semper. In laoreet sollicitudin risus, sed porta ex egestas a. Integer quam arcu, auctor eu aliquam ut, maximus eget magna. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque non velit lacus. Fusce dui felis, congue ac laoreet at, viverra in risus.\r\nCurabitur sapien risus, pharetra vel suscipit sit amet, mollis at lacus. Suspendisse ut faucibus ligula. Etiam sed est sem. Ut aliquam mauris at urna hendrerit ultrices. Mauris pharetra dui a scelerisque volutpat. Nunc vel orci quam. Curabitur in velit ac est cursus vehicula sit amet eu erat. Donec eu arcu bibendum, feugiat libero et, fringilla nisl. Nullam commodo est consequat arcu placerat auctor. Donec a vulputate felis. Praesent leo velit, dignissim eu volutpat eget, pharetra sit amet justo. Nulla facilisi. Fusce faucibus ante et nunc malesuada, posuere viverra risus tincidunt. Maecenas lobortis molestie urna, volutpat congue neque laoreet nec. Duis iaculis libero a diam mollis, sit amet porta augue viverra.\r\nNam ut risus eget quam blandit aliquam. Integer vitae bibendum risus, eu dapibus lectus. Ut quis enim odio. Nulla nisl leo, pulvinar vitae sodales vitae, porta eget arcu. Maecenas cursus eros urna, quis dapibus ante congue at. Suspendisse molestie lorem sed volutpat consequat. Fusce semper felis a aliquam ullamcorper. Duis non neque at neque accumsan dignissim quis eu nisl. Ut consequat dui eu aliquet auctor. Pellentesque tincidunt molestie leo, vel ullamcorper lacus posuere posuere.\r\nPellentesque tincidunt, quam et aliquet elementum, risus sem dapibus augue, nec vestibulum metus mauris a nunc. Mauris laoreet mi sit amet tellus commodo egestas. Suspendisse sit amet elementum quam, in luctus tortor. Proin eget risus ac libero semper interdum. Nunc lacinia, lacus vel malesuada luctus, mi erat sagittis neque, vitae placerat magna turpis quis orci. Suspendisse ultrices tempor dapibus. Proin feugiat ipsum est, eget scelerisque urna viverra id. Interdum et malesuada fames ac ante ipsum primis in faucibus.\r\n');

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
('ariosvila@gmail.com', '::1', '2018-09-02 17:07:21', 'f24273999e68104e191ef9cb9dfc34c0');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `column`
--
ALTER TABLE `column`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `content`
--
ALTER TABLE `content`
  ADD UNIQUE KEY `article_2` (`article`),
  ADD KEY `article` (`article`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`email`) REFERENCES `editor` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `content_ibfk_1` FOREIGN KEY (`article`) REFERENCES `column` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`email`) REFERENCES `editor` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
