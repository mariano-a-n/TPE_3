-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2025 a las 05:14:46
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
-- Base de datos: `concesionaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `nacionalidad` varchar(50) NOT NULL,
  `anio_de_creacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `marca`, `nacionalidad`, `anio_de_creacion`) VALUES
(2, 'chevrolet', 'EE.UU', 1911),
(3, 'ford', 'EE.UU', 1903),
(4, 'wolsvagens', 'alemania', 1937),
(5, 'Porsche', 'alemania', 1931),
(6, 'Toyota', 'japon', 1937),
(9, 'Renault', 'francia', 1899),
(11, 'doge', 'argentina', 1990);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contraseña` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `contraseña`) VALUES
(1, 'webadmin@gmail.com', '$2a$12$GEZvn5wP9wiDlbJCPhVD/e7.cPUk4Dj3UuIq4FudKV/c.HIHkKfie');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `modelo` tinytext NOT NULL,
  `anio` int(4) NOT NULL,
  `km` int(11) NOT NULL COMMENT 'kilometros recorridos',
  `precio` double NOT NULL,
  `patente` varchar(10) NOT NULL,
  `es_nuevo` tinyint(1) NOT NULL DEFAULT 0,
  `imagen` varchar(200) NOT NULL,
  `vendido` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `id_marca`, `modelo`, `anio`, `km`, `precio`, `patente`, `es_nuevo`, `imagen`, `vendido`) VALUES
(1, 3, 'ford f-100', 1981, 1000, 1500000, 'SHY 893', 0, 'https://http2.mlstatic.com/D_NQ_NP_2X_742636-MLA89983452028_082025-F.webp', 0),
(2, 6, 'corola', 2010, 0, 100000, 'gdfeygf', 1, '', 1),
(3, 2, 'Chevrolet Onix', 2026, 0, 0, 'xtr 894 jk', 0, 'https://www.chevrolet.com.ar/content/dam/chevrolet/sa/argentina/espanol/vdc-collections/2024/cars/onix/jelly-flyout-onix.png?imwidth=3000', 0),
(4, 2, 'Chevrolet Onix Plus', 2026, 0, 0, 'JP329ZT', 0, 'https://www.chevrolet.com.ar/content/dam/chevrolet/sa/argentina/espanol/index/new-vsid/homepage/refresh-julio/flyout/jelly-flyout-onix-plus.png?imwidth=3000', 0),
(5, 3, 'Bronco Sport', 2025, 0, 100, 'ER875XD', 0, 'https://www.ford.com.ar/content/dam/Ford/website-assets/latam/ar/home/showroom/fds/far-bronco-sport-showroom.jpg.dam.full.high.jpg/1741354285826.jpg', 0),
(6, 3, 'BRONCO', 2024, 5, 1.5, 'ZXG78RT', 1, 'https://www.ford.com.ar/content/dam/Ford/website-assets/latam/ar/home/showroom/fds/far-showroom-bronco-badlands.jpg.dam.full.high.jpg/1749137924018.jpg', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patente` (`patente`),
  ADD KEY `id_marca` (`id_marca`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
