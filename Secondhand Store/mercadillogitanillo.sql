-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-01-2024 a las 12:25:17
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
-- Base de datos: `mercadillogitanillo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `cod_articulo` int(9) NOT NULL,
  `cod_usuario` int(6) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `precio` double NOT NULL,
  `categoria` varchar(25) NOT NULL,
  `estado` varchar(25) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`cod_articulo`, `cod_usuario`, `nombre`, `descripcion`, `foto`, `precio`, `categoria`, `estado`, `activo`) VALUES
(1, 1, 'Scooter 49cc', 'Moto de mi primo, ha cogido los 120 en recta, tuneada', '1Scooter 49cc.png', 500, 'Vehículos', 'En buen estado', 1),
(2, 1, 'Volkswagen Golf 1995', 'VW GOLF 2.0GTI 115cv del 1995 con 171000km, cierre centralizado, elevalunas electricas, aire acondic', '1Volkswagen Golf 1995.png', 1000, 'Vehículos', 'En condiciones aceptables', 1),
(3, 1, 'Bolso Gucic', 'Bolso Gucic Original te lo joro', '1Bolso Gucic.png', 5, 'Ropa', 'Como Nuevo', 1),
(4, 1, 'Collar Cruz', 'Collar de oros con la cruz del señor', '1Collar Cruz.png', 10, 'Otra', 'En buen estado', 1),
(5, 1, 'Cajón Flamenco', 'Cajón flamenco fusión', '1Cajón Flamenco.png', 12, 'Otra', 'Toca repararlo', 1),
(6, 1, 'Vestido Flamenca', 'El vestido de casamiento de mi prima', '1Vestido Flamenca.png', 100, 'Ropa', 'Como Nuevo', 1),
(7, 1, 'Oregano del monte', 'Oregano de cultivo propio', '1Oregano del monte.jpeg', 10, 'Otra', 'Nuevo', 1),
(8, 1, 'Armario', 'Armario de madera de roble', '1Armario.png', 100, 'Muebles', 'Como Nuevo', 1),
(9, 2, 'Toyota Hilux ', 'Toyota del 2000 4x4 ', '2Toyota Hilux .jpg', 3000, 'Vehículos', 'En condiciones aceptables', 1),
(10, 2, 'Moto Choper', 'Moto 250 estilo Harley del 2015', '2Moto Choper.jpg', 20500, 'Vehículos', 'En buen estado', 1),
(11, 2, 'Escritorio ', 'Escritorio de madera de cerezo para estudiar', '2Escritorio .jpg', 120, 'Muebles', 'Como Nuevo', 1);

--
-- Disparadores `articulos`
--
DELIMITER $$
CREATE TRIGGER `nuevoarticulo` BEFORE INSERT ON `articulos` FOR EACH ROW BEGIN
    
    SET NEW.cod_articulo = (SELECT COALESCE(MAX(cod_articulo), 0) + 1 FROM articulos);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chats`
--

CREATE TABLE `chats` (
  `cod_chat` int(9) NOT NULL,
  `cod_comprador` int(6) NOT NULL,
  `cod_vendedor` int(6) NOT NULL,
  `cod_articulo` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chats`
--

INSERT INTO `chats` (`cod_chat`, `cod_comprador`, `cod_vendedor`, `cod_articulo`) VALUES
(291, 1, 2, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `cod_mensaje` int(9) NOT NULL,
  `cod_chat` int(9) NOT NULL,
  `contenido` varchar(150) NOT NULL,
  `cod_usuario` int(6) NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`cod_mensaje`, `cod_chat`, `contenido`, `cod_usuario`, `hora`) VALUES
(1, 291, 'Me interesa', 1, '13:56:52'),
(2, 291, 'Te la compro por 2000', 1, '13:59:03'),
(3, 291, 'No es negociable', 2, '13:59:15'),
(4, 291, 'Jayy ni pa ti ni pa mi 2500', 1, '14:00:16'),
(5, 291, 'Que no es negociable', 2, '14:00:35');

--
-- Disparadores `mensajes`
--
DELIMITER $$
CREATE TRIGGER `nuevomensaje` BEFORE INSERT ON `mensajes` FOR EACH ROW BEGIN
SET NEW.cod_mensaje = (
        SELECT COALESCE(MAX(cod_mensaje), 0) + 1 
        FROM mensajes 
        WHERE cod_mensaje <> 0
    );
    SET NEW.hora = CURRENT_TIME();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int(6) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contrasena` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cod_usuario`, `nombre`, `correo`, `contrasena`) VALUES
(1, 'Richal', 'Richal@xn--pualada-5za.com', 'richal'),
(2, 'ivan', 'ivan@gmail.com', 'ivan'),
(3, 'andres', 'andres@andres.com', 'andres'),
(4, 'tupapichampu', 'champu@gmail.com', '123'),
(5, 'Nacho', 'nachomartinez2001@gmail.com', 'nacho'),
(6, 'a', 'a@gmail.com', 'a'),
(7, 'manolo', 'manolo@manolo.es', 'manolo'),
(8, 'Parserito', 'parse@gmail.com', '123');

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `nuevousuario` BEFORE INSERT ON `usuarios` FOR EACH ROW BEGIN
  
    SET NEW.cod_usuario = (SELECT COALESCE(MAX(cod_usuario), 0) + 1 FROM usuarios);
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`cod_articulo`),
  ADD KEY `articulos_ibfk_1` (`cod_usuario`);

--
-- Indices de la tabla `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`cod_chat`),
  ADD KEY `cod_articulo` (`cod_articulo`),
  ADD KEY `cod_comprador` (`cod_comprador`),
  ADD KEY `cod_vendedor` (`cod_vendedor`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`cod_mensaje`),
  ADD KEY `cod_usuario` (`cod_usuario`),
  ADD KEY `mensajes_ibfk_1` (`cod_chat`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`cod_articulo`) REFERENCES `articulos` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`cod_comprador`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chats_ibfk_3` FOREIGN KEY (`cod_vendedor`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`cod_chat`) REFERENCES `chats` (`cod_chat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
