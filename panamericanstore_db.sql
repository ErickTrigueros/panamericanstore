-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-01-2020 a las 23:45:01
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `panamericanstore_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_category`
--

CREATE TABLE `tbl_category` (
  `idcat` int(11) NOT NULL,
  `category` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_category`
--

INSERT INTO `tbl_category` (`idcat`, `category`) VALUES
(1, 'Relojes'),
(5, 'Pulseras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_color`
--

CREATE TABLE `tbl_color` (
  `idcolor` int(11) NOT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_color`
--

INSERT INTO `tbl_color` (`idcolor`, `color`) VALUES
(1, 'Black'),
(2, 'Rose Gold');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_material`
--

CREATE TABLE `tbl_material` (
  `idmat` int(11) NOT NULL,
  `material` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_material`
--

INSERT INTO `tbl_material` (`idmat`, `material`) VALUES
(1, 'Cuero'),
(2, 'Metal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_product`
--

CREATE TABLE `tbl_product` (
  `idp` int(11) NOT NULL,
  `pcode` varchar(25) NOT NULL,
  `pname` varchar(200) NOT NULL,
  `pcategory` varchar(200) NOT NULL,
  `pstyle` varchar(100) DEFAULT NULL,
  `pmaterial` varchar(50) DEFAULT NULL,
  `pcolor` varchar(50) NOT NULL,
  `purchaseprice` float NOT NULL,
  `saleprice` float NOT NULL,
  `pobservation` varchar(250) DEFAULT NULL,
  `pstock` int(11) NOT NULL,
  `pdescription` varchar(250) DEFAULT NULL,
  `pimage` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_product`
--

INSERT INTO `tbl_product` (`idp`, `pcode`, `pname`, `pcategory`, `pstyle`, `pmaterial`, `pcolor`, `purchaseprice`, `saleprice`, `pobservation`, `pstock`, `pdescription`, `pimage`) VALUES
(1, '3455-ROSG', 'Reloj1', 'Relojes', 'Fashion', 'Metal', 'Rose Gold', 2, 5, 'test1', 5, 'desctest', '5e24d966023cd.png'),
(2, '3455-ROSG', 'Reloj2', 'Relojes', 'Casual', 'Cuero', 'Black', 2, 5, '', 5, '', '5e24d9b858d06.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_style`
--

CREATE TABLE `tbl_style` (
  `idstyle` int(11) NOT NULL,
  `style` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_style`
--

INSERT INTO `tbl_style` (`idstyle`, `style`) VALUES
(1, 'Casual'),
(2, 'Fashion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `username` varchar(200) NOT NULL,
  `useremail` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `name`, `surname`, `username`, `useremail`, `password`, `role`) VALUES
(1, 'Erick', 'Trigueros', 'etriguer', 'erickjerez92@hotmail.com', '1234', 'Admin'),
(2, 'Carlos', 'Carcamo', 'liancarlos', 'ccarcamog92@gmail.com', '1234', 'User');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`idcat`);

--
-- Indices de la tabla `tbl_color`
--
ALTER TABLE `tbl_color`
  ADD PRIMARY KEY (`idcolor`);

--
-- Indices de la tabla `tbl_material`
--
ALTER TABLE `tbl_material`
  ADD PRIMARY KEY (`idmat`);

--
-- Indices de la tabla `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`idp`);

--
-- Indices de la tabla `tbl_style`
--
ALTER TABLE `tbl_style`
  ADD PRIMARY KEY (`idstyle`);

--
-- Indices de la tabla `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `idcat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_color`
--
ALTER TABLE `tbl_color`
  MODIFY `idcolor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_material`
--
ALTER TABLE `tbl_material`
  MODIFY `idmat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `idp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_style`
--
ALTER TABLE `tbl_style`
  MODIFY `idstyle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
