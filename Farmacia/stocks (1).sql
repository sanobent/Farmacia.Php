-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-08-2024 a las 20:29:38
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
-- Base de datos: `farmacia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `principio_activo` varchar(255) DEFAULT NULL,
  `concentracion` varchar(255) DEFAULT NULL,
  `forma_farmaceutica` varchar(255) DEFAULT NULL,
  `presentacion` varchar(255) DEFAULT NULL,
  `fecha_caducidad` date DEFAULT NULL,
  `registro_sanitario` varchar(255) DEFAULT NULL,
  `iva` float DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `disp` int(11) DEFAULT NULL,
  `codigo_barras` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stocks`
--

INSERT INTO `stocks` (`id`, `nombre`, `marca`, `categoria`, `principio_activo`, `concentracion`, `forma_farmaceutica`, `presentacion`, `fecha_caducidad`, `registro_sanitario`, `iva`, `precio`, `disp`, `codigo_barras`) VALUES
(1, 'Aspirina', 'nsnd', 'Analgésicos', 'Paracetamol', 'mg/ml', 'Comprimidos', 'caja', '2024-08-02', '23e', 0, 233, 233, '39394949'),
(2, 'yquu', 'jesus', 'Analgésicos', 'Ibuprofeno', 'mg/ml', 'Comprimidos', 'aesteric', '2024-08-29', '23e', 0, 2000, 2, 'xnj93848');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
