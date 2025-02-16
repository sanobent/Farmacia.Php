-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-08-2024 a las 20:29:58
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
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `ID` int(11) NOT NULL,
  `FechaTransaccion` varchar(255) NOT NULL,
  `TipoFactura` varchar(255) NOT NULL,
  `NumeroFactura` varchar(255) NOT NULL,
  `ProductoVendido` varchar(255) NOT NULL,
  `CantidadVendida` varchar(255) NOT NULL,
  `PrecioUnitario` varchar(255) NOT NULL,
  `MetodoPago` varchar(255) NOT NULL,
  `IDCliente` varchar(255) NOT NULL,
  `IDVendedor` varchar(255) NOT NULL,
  `CanalVenta` varchar(255) NOT NULL,
  `Descuentos` varchar(255) NOT NULL,
  `Intereses` varchar(255) NOT NULL,
  `TotalVenta` varchar(255) NOT NULL,
  `PrecioDescuento` varchar(255) NOT NULL,
  `PrecioIntereses` varchar(255) NOT NULL,
  `PrecioTotal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
