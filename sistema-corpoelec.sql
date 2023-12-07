-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-12-2023 a las 20:59:01
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema-corpoelec`
--
CREATE DATABASE IF NOT EXISTS `sistema-corpoelec` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sistema-corpoelec`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrasenas`
--

CREATE TABLE `contrasenas` (
  `id` int(11) NOT NULL,
  `contrasenaEmail` varchar(255) NOT NULL,
  `contrasenaToken` varchar(255) NOT NULL,
  `userCodigo` varchar(255) NOT NULL,
  `userType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id` int(11) NOT NULL,
  `M_Codigo` varchar(255) NOT NULL,
  `M_Nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id`, `M_Codigo`, `M_Nombre`) VALUES
(1, 'M7166930-1', 'Andrés Mata'),
(2, 'M1319918-2', 'Arismendi'),
(3, 'M0571799-3', 'Benítez'),
(4, 'M9423560-4', 'Bermúdez'),
(5, 'M5678428-5', 'Cajigal'),
(6, 'M4021865-6', 'Libertador'),
(7, 'M1319918-7', 'Mariño'),
(8, 'M0571799-8', 'Valdez'),
(9, 'M7166930-9', 'Central de Servicios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaciones`
--

CREATE TABLE `operaciones` (
  `id` int(11) NOT NULL,
  `O_Codigo` varchar(255) NOT NULL,
  `O_Procedimiento` varchar(255) NOT NULL,
  `O_Fecha` date NOT NULL,
  `O_Equipo` varchar(255) NOT NULL,
  `O_Municipio` varchar(255) NOT NULL,
  `O_EstadoActual` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operaciones`
--

INSERT INTO `operaciones` (`id`, `O_Codigo`, `O_Procedimiento`, `O_Fecha`, `O_Equipo`, `O_Municipio`, `O_EstadoActual`) VALUES
(1, 'H5284534-1', 'Reparación', '2023-12-15', '26635,', 'Libertador', 'Almacenado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transformadores`
--

CREATE TABLE `transformadores` (
  `id` int(11) NOT NULL,
  `T_Codigo` varchar(255) NOT NULL,
  `T_Estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `T_Capacidad` varchar(255) NOT NULL,
  `T_Municipio` varchar(255) NOT NULL,
  `T_Direccion` varchar(255) NOT NULL,
  `T_Tipo` varchar(255) NOT NULL,
  `T_Banco` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transformadores`
--

INSERT INTO `transformadores` (`id`, `T_Codigo`, `T_Estado`, `T_Capacidad`, `T_Municipio`, `T_Direccion`, `T_Tipo`, `T_Banco`) VALUES
(1, '22792', 'Instalado', '39006', 'Benítez', '6 College Street', 'Bifásico', 'No'),
(2, '16162,', 'Instalado', '21235', 'Andrés Mata', '134 Williams Street', 'Monofásico', 'Si'),
(3, '26635,', 'Almacenado', '45150', 'Libertador', '5541 Woodland Avenue', 'Trifásico', 'No'),
(4, '70734,', 'Instalado', '36137', 'Mariño', '48638 Park Street', 'Trifásico', 'No'),
(5, '12559,', 'Dañado', '60686', 'Andrés Mata', '346 Wood Street', 'Bifásico', 'No'),
(6, '27296,', 'Almacenado', '57536', 'Central de Servicios', '54120 Main Street East', 'Bifásico', 'No'),
(7, '17306,', 'Instalado', '7807', 'Andrés Mata', '134 Williams Street', 'Monofásico', 'Si'),
(8, '14997,', 'Instalado', '22309,', 'Andrés Mata', '134 Williams Street', 'Monofásico', 'Si'),
(9, '23378,', 'Instalado', '40550', 'Valdez', '20 Bridge Street', 'Monofásico', 'No'),
(10, '4282,', 'Dañado', '31683', 'Central de Servicios', '54120 Main Street East', 'Trifásico', 'No'),
(11, '2040,', 'Dañado', '33736', 'Bermúdez', '73 Laurel Street', 'Monofásico', 'Si'),
(12, '6339,', 'Instalado', '32238', 'Bermúdez', '73 Laurel Street', 'Monofásico', 'Si'),
(13, '9896,', 'Instalado', '3885', 'Arismendi', '58 Cambridge Drive', 'Bifásico', 'No'),
(14, '20721,', 'Dañado', '13585', 'Cajigal', '49 Church Street', 'Monofásico', 'No'),
(15, '19873,', 'Instalado', '24860', 'Bermúdez', '73 Laurel Street', 'Monofásico', 'Si'),
(16, '19700,', 'Almacenado', '51282', 'Central de Servicios', '54120 Main Street East', 'Monofásico', 'No'),
(17, '13291,', 'Instalado', '48677', 'Benítez', '8 Market Street', 'Monofásico', 'No'),
(18, '1357,', 'Dañado', '35074', 'Valdez', '8706 Ridge Avenue', 'Bifásico', 'No'),
(19, '15132,', 'Instalado', '48580', 'Libertador', '567 Main Street South', 'Bifásico', 'No'),
(20, '19037,', 'Dañado', '9770', 'Mariño', '39 Hill Street', 'Trifásico', 'No'),
(21, '10169,', 'Instalado', '54998', 'Benítez', '60 Valley Road', 'Bifásico', 'No'),
(22, '26828,', 'Almacenado', '26433', 'Central de Servicios', '54120 Main Street East', 'Monofásico', 'No'),
(23, '17497,', 'Instalado', '52737', 'Bermúdez', '84 Harrison Street', 'Trifásico', 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `userCodigo` varchar(255) NOT NULL,
  `userUsername` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userType` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `userLastname` varchar(255) NOT NULL,
  `userCargo` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `userCodigo`, `userUsername`, `userPassword`, `userType`, `userName`, `userLastname`, `userCargo`, `userEmail`) VALUES
(22, 'A4578498-1', 'Administrador', '$2y$10$3EzeN.PCK35YjopwUEbxOuvXr6h7/7WNjjQwlkxMMcxD.L7azPVGu', 'Administrador', 'Jonkellys', 'Maestre', 'Pasante', 'jonke2331@gmail.com'),
(28, 'N3458910-2', 'Normal', '$2y$10$DXubHGbUW5jsdvE8v1oXkOUiwDfApgJJ1tZ6aFoEpRkdXdh1O9iva', 'Normal', 'Rosa', 'Fernández', 'Gerencia de ATIT', 'rosa@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contrasenas`
--
ALTER TABLE `contrasenas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userCodigo` (`userCodigo`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `M_Nombre` (`M_Nombre`);

--
-- Indices de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `O-Equipo` (`O_Equipo`),
  ADD KEY `O-Codigo` (`O_Codigo`);

--
-- Indices de la tabla `transformadores`
--
ALTER TABLE `transformadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T-Codigo` (`T_Codigo`),
  ADD KEY `T-Municipio` (`T_Municipio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userCodigo` (`userCodigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contrasenas`
--
ALTER TABLE `contrasenas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `transformadores`
--
ALTER TABLE `transformadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contrasenas`
--
ALTER TABLE `contrasenas`
  ADD CONSTRAINT `contrasenas_ibfk_1` FOREIGN KEY (`userCodigo`) REFERENCES `usuarios` (`userCodigo`);

--
-- Filtros para la tabla `operaciones`
--
ALTER TABLE `operaciones`
  ADD CONSTRAINT `operaciones_ibfk_1` FOREIGN KEY (`O_Equipo`) REFERENCES `transformadores` (`T_Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `transformadores`
--
ALTER TABLE `transformadores`
  ADD CONSTRAINT `transformadores_ibfk_1` FOREIGN KEY (`T_Municipio`) REFERENCES `municipios` (`M_Nombre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
