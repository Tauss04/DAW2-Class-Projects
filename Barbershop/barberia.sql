-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2023 a las 13:59:30
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `barberia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `cod_empleado` int(1) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `paentrar` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`cod_empleado`, `usuario`, `paentrar`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `cod_cita` int(5) NOT NULL,
  `cod_cliente` int(4) NOT NULL,
  `cod_empleado` int(1) NOT NULL,
  `cod_servicio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `citas`
--
DELIMITER $$
CREATE TRIGGER `nuevacita` BEFORE INSERT ON `citas` FOR EACH ROW BEGIN
  SET NEW.cod_cita = IFNULL((SELECT MAX(cod_cita) + 1 FROM citas), 1);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `cod_cliente` int(4) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `asientra` varchar(15) NOT NULL,
  `correo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`cod_cliente`, `nombre`, `usuario`, `asientra`, `correo`) VALUES
(0, 'peluquero', 'peluquero', 'peluquero', 'peluquero');

--
-- Disparadores `clientes`
--
DELIMITER $$
CREATE TRIGGER `nuevoCli` BEFORE INSERT ON `clientes` FOR EACH ROW BEGIN
  SET NEW.cod_cliente = IFNULL((SELECT MAX(cod_cliente) + 1 FROM clientes), 1);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `cod_empleado` int(1) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `codentrada` varchar(15) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`cod_empleado`, `nombre`, `codentrada`, `activo`) VALUES
(1, 'oscar', 'oscar', 1),
(2, 'omar', 'omar', 1),
(3, 'kevin', 'kevin', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `cod_servicio` int(1) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` int(3) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`cod_servicio`, `nombre`, `descripcion`, `precio`, `activo`) VALUES
(0, 'ausencia', 'ausencia empleado', 0, 1),
(1, 'corte hombre', '15min', 10, 1),
(2, 'afeitado hombre', 'afeitado barba 15min', 7, 1),
(3, 'limpieza facial', 'limpieza y masaje cara 45min', 12, 1),
(4, 'corte pelo+barba', '30 min', 15, 1),
(5, 'completo', 'corte pelo+barba+limpieza facial 1h 15min', 20, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`cod_empleado`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`cod_cita`),
  ADD KEY `cod_cliente` (`cod_cliente`),
  ADD KEY `cod_empleado` (`cod_empleado`),
  ADD KEY `cod_servicio` (`cod_servicio`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cod_cliente`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`cod_empleado`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`cod_servicio`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`cod_empleado`) REFERENCES `empleados` (`cod_empleado`);

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`cod_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`cod_empleado`) REFERENCES `empleados` (`cod_empleado`) ON UPDATE CASCADE,
  ADD CONSTRAINT `citas_ibfk_3` FOREIGN KEY (`cod_servicio`) REFERENCES `servicio` (`cod_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
