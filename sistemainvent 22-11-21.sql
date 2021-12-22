-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-12-2021 a las 20:28:06
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemainvent`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `idalmacen` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_principal` tinyint(1) NOT NULL,
  `condicion` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`idalmacen`, `nombre`, `direccion`, `telefono`, `email`, `is_principal`, `condicion`, `created_at`) VALUES
(1, 'Bodega principal', 'Tulumaje', '54171515', 'Donal@gmail.com', 1, 1, '2021-12-16 16:57:52'),
(2, 'Bodega producto terminado', 'Tulumaje 2', '55521542', 'er617820@gmail.com', 0, 1, '2021-12-16 17:02:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `idalmacen` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajachica`
--

CREATE TABLE `cajachica` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `monto` float DEFAULT NULL,
  `date_at` date DEFAULT NULL,
  `kind` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`, `condicion`, `created_at`) VALUES
(1, 'Madera de pino', 'Nueva', 1, '2021-12-16 22:58:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credito`
--

CREATE TABLE `credito` (
  `id` int(11) NOT NULL,
  `tipo_pago_id` int(11) NOT NULL,
  `transaccion_id` int(11) DEFAULT NULL,
  `idpersona` int(11) NOT NULL,
  `total` double DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `credito`
--

INSERT INTO `credito` (`id`, `tipo_pago_id`, `transaccion_id`, `idpersona`, `total`, `created_at`) VALUES
(1, 1, 3, 2, 500, '2021-12-20'),
(18, 2, 3, 2, 300, NULL),
(19, 2, 3, 2, 100, NULL),
(20, 2, 3, 2, 25, NULL),
(29, 2, 3, 2, 12, NULL),
(30, 2, 3, 2, 25, NULL),
(31, 1, 7, 3, 2500, '2021-12-20'),
(32, 2, 7, 3, 500, NULL),
(33, 2, 7, 3, 500, NULL),
(34, 2, 7, 3, 500, NULL),
(36, 2, 7, 3, 200, NULL),
(38, 2, 7, 3, 4, NULL),
(42, 2, 7, 3, 200, NULL),
(43, 2, 3, 2, 38, NULL),
(44, 2, 7, 3, 596, NULL),
(45, 1, 8, 2, 100, '2021-12-21'),
(46, 1, 9, 3, 8, '2021-12-22'),
(47, 1, 10, 2, 250, '2021-12-22'),
(48, 2, 9, 3, 5, NULL),
(49, 2, 10, 2, 100, NULL),
(50, 2, 9, 3, 2, NULL),
(51, 2, 9, 3, 1, NULL),
(52, 2, 8, 2, 50, NULL),
(53, 2, 10, 2, 10, NULL),
(54, 2, 10, 2, 10, NULL),
(55, 2, 10, 2, 10, NULL),
(56, 2, 10, 2, 20, NULL),
(57, 2, 10, 2, 10, NULL),
(58, 2, 10, 2, 10, NULL),
(59, 2, 10, 2, 10, NULL),
(60, 2, 10, 2, 10, NULL),
(61, 2, 10, 2, 10, NULL),
(62, 2, 10, 2, 10, NULL),
(63, 2, 10, 2, 10, NULL),
(64, 2, 10, 2, 10, NULL),
(65, 2, 10, 2, 10, NULL),
(66, 2, 10, 2, 5, NULL),
(67, 2, 10, 2, 5, NULL),
(68, 1, 11, 2, 500, '2021-12-27'),
(69, 2, 8, 2, 10, NULL),
(70, 2, 8, 2, 10, NULL),
(71, 2, 8, 2, 10, NULL),
(72, 2, 8, 2, 10, NULL),
(73, 2, 8, 2, 10, NULL),
(74, 2, 11, 2, 100, NULL),
(75, 2, 11, 2, 100, NULL),
(76, 2, 11, 2, 50, NULL),
(77, 2, 11, 2, 10, NULL),
(78, 2, 11, 2, 10, NULL),
(79, 2, 11, 2, 10, NULL),
(80, 2, 11, 2, 10, NULL),
(81, 2, 11, 2, 10, NULL),
(82, 2, 11, 2, 10, NULL),
(83, 2, 11, 2, 10, NULL),
(84, 1, 12, 2, 20, '2021-12-25'),
(85, 2, 11, 2, 50, NULL),
(86, 2, 12, 2, 20, NULL),
(87, 1, 63, 2, 100, '2021-12-31'),
(88, 2, 11, 2, 130, NULL),
(89, 1, 64, 2, 250, '2021-12-23'),
(90, 2, 64, 2, 250, NULL),
(91, 1, 65, 2, 100, '2021-12-23'),
(92, 2, 65, 2, 100, NULL),
(93, 1, 66, 2, 300, '2021-12-23'),
(94, 2, 66, 2, 150, NULL),
(95, 2, 66, 2, 100, NULL),
(96, 2, 66, 2, 50, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `idventa` int(10) NOT NULL,
  `idarticulo` int(10) NOT NULL,
  `cantidad` int(10) NOT NULL,
  `precio_venta` double NOT NULL,
  `descuento` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`idventa`, `idarticulo`, `cantidad`, `precio_venta`, `descuento`) VALUES
(1, 1, 10, 50, '0'),
(5, 1, 50, 50, '0'),
(6, 1, 4, 25, '0'),
(7, 1, 2, 4, '0'),
(8, 1, 5, 50, '0'),
(9, 1, 10, 50, '0'),
(10, 1, 5, 4, '0'),
(11, 2, 25, 1, '0'),
(11, 1, 14, 1, '0'),
(12, 1, 2, 45, '0'),
(13, 1, 22, 1, '0'),
(14, 4, 11, 25, '0'),
(15, 1, 10, 10, '0'),
(16, 1, 5, 50, '0'),
(17, 1, 5, 20, '0'),
(18, 1, 2, 150, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos_ingreso`
--

CREATE TABLE `gastos_ingreso` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `total` double DEFAULT NULL,
  `caja_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id` int(11) NOT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operacion`
--

CREATE TABLE `operacion` (
  `id` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `idalmacen` int(11) DEFAULT NULL,
  `idalmacen_des` int(11) DEFAULT NULL,
  `operation_from_id` int(11) DEFAULT NULL,
  `cantidad` float NOT NULL,
  `price_compra` double DEFAULT NULL,
  `idprecio_lis` double DEFAULT NULL,
  `tipo_operacion_id` int(11) NOT NULL,
  `transaccion_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `is_draft` tinyint(1) NOT NULL DEFAULT '0',
  `is_traspase` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `operacion`
--

INSERT INTO `operacion` (`id`, `idproducto`, `idalmacen`, `idalmacen_des`, `operation_from_id`, `cantidad`, `price_compra`, `idprecio_lis`, `tipo_operacion_id`, `transaccion_id`, `status`, `is_draft`, `is_traspase`, `created_at`) VALUES
(1, 1, 1, NULL, NULL, 150, 20, 45, 1, 1, 1, 0, 0, '2021-12-16 23:02:13'),
(2, 1, 1, NULL, NULL, 50, 20, NULL, 6, 2, 1, 0, 1, '2021-12-16 23:03:23'),
(3, 1, 1, NULL, 2, 50, 20, NULL, 2, 2, 1, 0, 1, '2021-12-16 23:03:23'),
(4, 1, 2, NULL, 2, 50, 20, NULL, 1, 2, 1, 0, 1, '2021-12-16 23:03:23'),
(5, 1, 1, NULL, NULL, 10, NULL, 50, 2, 3, 1, 0, 0, '2021-12-16 23:05:20'),
(6, 1, 1, NULL, NULL, 50, NULL, 50, 2, 7, 1, 0, 0, '2021-12-17 02:17:16'),
(7, 1, 1, NULL, NULL, 4, NULL, 25, 2, 8, 1, 0, 0, '2021-12-17 17:29:32'),
(8, 1, 1, NULL, NULL, 2, NULL, 4, 2, 9, 1, 0, 0, '2021-12-17 17:31:19'),
(9, 1, 1, NULL, NULL, 5, NULL, 50, 2, 10, 1, 0, 0, '2021-12-17 20:16:24'),
(10, 1, 1, NULL, NULL, 10, NULL, 50, 2, 11, 1, 0, 0, '2021-12-17 22:32:25'),
(11, 1, 1, NULL, NULL, 5, NULL, 4, 2, 12, 1, 0, 0, '2021-12-21 02:59:39'),
(12, 2, 1, NULL, NULL, 500, 1, 1, 1, 13, 1, 0, 0, '2021-12-21 03:56:47'),
(13, 2, 1, NULL, NULL, 25, NULL, 1, 2, 14, 1, 0, 0, '2021-12-21 05:24:39'),
(14, 1, 1, NULL, NULL, 14, NULL, 1, 2, 14, 1, 0, 0, '2021-12-21 05:24:39'),
(25, 1, 1, NULL, NULL, 0, 1, NULL, 1, 29, 1, 0, 0, '2021-12-21 06:05:44'),
(26, 1, 1, NULL, NULL, 0, 103, NULL, 1, 30, 1, 0, 0, '2021-12-21 06:08:53'),
(27, 1, 1, NULL, NULL, 0, 106, NULL, 1, 31, 1, 0, 0, '2021-12-21 06:10:37'),
(28, 1, 1, NULL, NULL, 0, 106, NULL, 1, 32, 1, 0, 0, '2021-12-21 06:11:40'),
(29, 1, 1, NULL, NULL, 0, 106, NULL, 1, 33, 1, 0, 0, '2021-12-21 06:12:18'),
(30, 1, 1, NULL, NULL, 0, 106, NULL, 1, 34, 1, 0, 0, '2021-12-21 06:12:59'),
(31, 1, 1, NULL, NULL, 0, 106, NULL, 1, 35, 1, 0, 0, '2021-12-21 06:14:15'),
(32, 1, 1, NULL, NULL, 0, 106, NULL, 1, 36, 1, 0, 0, '2021-12-21 06:16:21'),
(33, 1, 1, NULL, NULL, 0, 106, NULL, 1, 37, 1, 0, 0, '2021-12-21 06:17:18'),
(34, 1, 1, NULL, NULL, 0, 106, NULL, 1, 38, 1, 0, 0, '2021-12-21 06:18:07'),
(35, 1, 1, NULL, NULL, 2, 106, NULL, 1, 39, 1, 0, 0, '2021-12-21 06:22:24'),
(36, 3, 1, NULL, NULL, 10, 25, 1, 1, 40, 1, 0, 0, '2021-12-21 16:51:11'),
(37, 1, 1, NULL, NULL, 2, NULL, 150, 2, 41, 1, 0, 0, '2021-12-21 17:11:47'),
(38, 1, 1, NULL, NULL, 2, 54, NULL, 1, 42, 1, 0, 0, '2021-12-21 17:17:49'),
(39, 1, 1, NULL, NULL, 2, 54, NULL, 1, 42, 1, 0, 0, '2021-12-21 17:17:49'),
(41, 1, 1, NULL, NULL, 2, 41, NULL, 1, 43, 1, 0, 0, '2021-12-21 17:22:10'),
(43, 1, 1, NULL, NULL, 2, 41, NULL, 1, 43, 1, 0, 0, '2021-12-21 17:22:10'),
(45, 1, 1, NULL, NULL, 2, 13, NULL, 1, 44, 1, 0, 0, '2021-12-21 17:25:55'),
(47, 1, 1, NULL, NULL, 2, 25, NULL, 1, 45, 1, 0, 0, '2021-12-21 17:27:03'),
(48, 2, 1, NULL, NULL, 30, 1, NULL, 2, 46, 1, 0, 0, '2021-12-21 17:29:32'),
(49, 1, 1, NULL, NULL, 2, 29, NULL, 1, 46, 1, 0, 0, '2021-12-21 17:29:32'),
(50, 3, 1, NULL, NULL, 1, 25, NULL, 2, 46, 1, 0, 0, '2021-12-21 17:29:32'),
(51, 1, 1, NULL, NULL, 2, 29, NULL, 1, 46, 1, 0, 0, '2021-12-21 17:29:32'),
(52, 2, 1, NULL, NULL, 1, 1, NULL, 2, 47, 1, 0, 0, '2021-12-21 17:30:47'),
(53, 1, 1, NULL, NULL, 2, 13, NULL, 1, 47, 1, 0, 0, '2021-12-21 17:30:47'),
(54, 3, 1, NULL, NULL, 1, 25, NULL, 2, 47, 1, 0, 0, '2021-12-21 17:30:47'),
(55, 1, 1, NULL, NULL, 2, 13, NULL, 1, 47, 1, 0, 0, '2021-12-21 17:30:47'),
(56, 1, 1, NULL, NULL, 1, 26, NULL, 1, 48, 1, 0, 0, '2021-12-21 17:33:56'),
(57, 3, 1, NULL, NULL, 1, 25, NULL, 2, 48, 1, 0, 0, '2021-12-21 17:33:56'),
(58, 1, 1, NULL, NULL, 1, 26, NULL, 1, 48, 1, 0, 0, '2021-12-21 17:33:56'),
(59, 2, 1, NULL, NULL, 1, 1, NULL, 2, 48, 1, 0, 0, '2021-12-21 17:33:56'),
(60, 1, 1, NULL, NULL, 22, NULL, 1, 2, 49, 1, 0, 0, '2021-12-21 17:34:44'),
(61, 1, 1, NULL, NULL, 1, 25, NULL, 1, 50, 1, 0, 0, '2021-12-21 17:35:25'),
(62, 3, 1, NULL, NULL, 1, 25, NULL, 2, 50, 1, 0, 0, '2021-12-21 17:35:25'),
(63, 1, 1, NULL, NULL, 3, 26, NULL, 1, 51, 1, 0, 0, '2021-12-21 17:36:17'),
(64, 2, 1, NULL, NULL, 2, 1, NULL, 2, 51, 1, 0, 0, '2021-12-21 17:36:17'),
(65, 1, 1, NULL, NULL, 3, 26, NULL, 1, 51, 1, 0, 0, '2021-12-21 17:36:17'),
(66, 3, 1, NULL, NULL, 3, 25, NULL, 2, 51, 1, 0, 0, '2021-12-21 17:36:17'),
(67, 1, 1, NULL, NULL, 2, 13, NULL, 1, 52, 1, 0, 0, '2021-12-21 17:37:15'),
(68, 2, 1, NULL, NULL, 25, 1, NULL, 2, 52, 1, 0, 0, '2021-12-21 17:37:15'),
(69, 1, 1, NULL, NULL, 2, 26, NULL, 1, 53, 1, 0, 0, '2021-12-21 17:38:55'),
(70, 2, 1, NULL, NULL, 2, 1, NULL, 2, 53, 1, 0, 0, '2021-12-21 17:38:55'),
(72, 3, 1, NULL, NULL, 2, 25, NULL, 2, 53, 1, 0, 0, '2021-12-21 17:38:55'),
(73, 1, 1, NULL, NULL, 3, 10, NULL, 1, 54, 1, 0, 0, '2021-12-21 17:40:46'),
(74, 3, 1, NULL, NULL, 1, 25, NULL, 2, 54, 1, 0, 0, '2021-12-21 17:40:46'),
(75, 2, 1, NULL, NULL, 2, 1, NULL, 2, 54, 1, 0, 0, '2021-12-21 17:40:46'),
(76, 3, 1, NULL, NULL, 25, 10, 1, 1, 55, 1, 0, 0, '2021-12-21 17:56:52'),
(77, 1, 1, NULL, NULL, 3, 25, NULL, 1, 56, 1, 0, 0, '2021-12-21 17:57:49'),
(78, 3, 1, NULL, NULL, 2, 25, NULL, 2, 56, 1, 0, 0, '2021-12-21 17:57:49'),
(79, 2, 1, NULL, NULL, 25, 1, NULL, 2, 56, 1, 0, 0, '2021-12-21 17:57:49'),
(80, 1, 1, NULL, NULL, 5, 39, NULL, 1, 57, 1, 0, 0, '2021-12-21 18:52:20'),
(81, 2, 1, NULL, NULL, 100, 1, NULL, 2, 57, 1, 0, 0, '2021-12-21 18:52:20'),
(82, 3, 1, NULL, NULL, 2, 25, NULL, 2, 57, 1, 0, 0, '2021-12-21 18:52:20'),
(83, 4, 1, NULL, NULL, 3, 65, NULL, 1, 58, 1, 0, 0, '2021-12-21 18:53:48'),
(84, 2, 1, NULL, NULL, 100, 1, NULL, 2, 58, 1, 0, 0, '2021-12-21 18:53:48'),
(85, 3, 1, NULL, NULL, 2, 25, NULL, 2, 58, 1, 0, 0, '2021-12-21 18:53:48'),
(86, 4, 1, NULL, NULL, 5, 29, NULL, 1, 59, 1, 0, 0, '2021-12-21 19:01:02'),
(87, 2, 1, NULL, NULL, 25, 1, NULL, 2, 59, 1, 0, 0, '2021-12-21 19:01:02'),
(88, 3, 1, NULL, NULL, 4, 25, NULL, 2, 59, 1, 0, 0, '2021-12-21 19:01:02'),
(89, 4, 1, NULL, NULL, 3, 55, NULL, 1, 60, 1, 0, 0, '2021-12-21 22:39:35'),
(90, 2, 1, NULL, NULL, 25, 1, NULL, 2, 60, 1, 0, 0, '2021-12-21 22:39:35'),
(91, 3, 1, NULL, NULL, 4, 25, NULL, 2, 60, 1, 0, 0, '2021-12-21 22:39:35'),
(92, 1, 1, NULL, NULL, 3, 50.66666666666667, NULL, 1, 61, 1, 0, 0, '2021-12-21 23:00:39'),
(93, 2, 1, NULL, NULL, 20, 1, NULL, 2, 61, 1, 0, 0, '2021-12-21 23:00:39'),
(94, 3, 1, NULL, NULL, 3, 25, NULL, 2, 61, 1, 0, 0, '2021-12-21 23:00:39'),
(95, 4, 1, NULL, NULL, 11, NULL, 25, 2, 62, 1, 0, 0, '2021-12-21 23:39:26'),
(96, 1, 1, NULL, NULL, 10, NULL, 10, 2, 63, 1, 0, 0, '2021-12-22 03:27:27'),
(97, 1, 1, NULL, NULL, 5, NULL, 50, 2, 64, 1, 0, 0, '2021-12-22 06:29:33'),
(98, 1, 1, NULL, NULL, 5, NULL, 20, 2, 65, 1, 0, 0, '2021-12-22 06:33:00'),
(99, 1, 1, NULL, NULL, 2, NULL, 150, 2, 66, 1, 0, 0, '2021-12-22 06:35:24'),
(100, 4, 1, NULL, NULL, 2, 120.65, NULL, 1, 67, 1, 0, 0, '2021-12-22 06:59:54'),
(101, 2, 1, NULL, NULL, 2, 1, NULL, 2, 67, 1, 0, 0, '2021-12-22 06:59:54'),
(102, 3, 1, NULL, NULL, 5, 25, NULL, 2, 67, 1, 0, 0, '2021-12-22 06:59:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id` int(11) NOT NULL,
  `tipo_pago` int(11) DEFAULT NULL,
  `cantidad` float DEFAULT NULL,
  `pago` double DEFAULT NULL,
  `idpersona` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Escritorio'),
(2, 'Almacen'),
(3, 'Compras'),
(4, 'Ventas'),
(5, 'Acceso'),
(6, 'Consulta Compras'),
(7, 'Consulta Ventas'),
(8, 'Caja'),
(9, 'Planilla'),
(10, 'articulo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `tipo_docum` int(11) NOT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `empresa` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `telefono1` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `activar_credito` tinyint(1) NOT NULL DEFAULT '0',
  `limite_credito` double DEFAULT NULL,
  `tipo_person` int(11) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `nombre`, `apellido`, `tipo_docum`, `nit`, `empresa`, `direccion`, `telefono`, `telefono1`, `email`, `cargo`, `activar_credito`, `limite_credito`, `tipo_person`, `condicion`, `created_at`) VALUES
(1, 'Express', 'Sanarate', 1, '2457815', NULL, 'Parque central', '55521542', '44451515', 'coffesan@expresscoffe.com.gt', NULL, 0, NULL, 2, 1, '0000-00-00 00:00:00'),
(2, 'Milton', 'Merlos', 1, '4848451', NULL, 'Sanarate', '55521542', '5451212', 'er617820@gmail.com', NULL, 0, NULL, 1, 1, '0000-00-00 00:00:00'),
(3, 'Vinicio', 'Mejia', 1, '45151', NULL, 'Ovejas', '54151515', '1521512', 'vinicio@gmial.com', NULL, 0, NULL, 1, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `inventario_min` int(11) NOT NULL DEFAULT '10',
  `precio_en` float NOT NULL,
  `id_precio_lis` float DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `presentation` varchar(255) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idcategoria` int(11) DEFAULT NULL,
  `tipo_producto` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kind` int(11) NOT NULL DEFAULT '1',
  `condicion` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `imagen`, `codigo`, `nombre`, `descripcion`, `inventario_min`, `precio_en`, `id_precio_lis`, `unit`, `presentation`, `idusuario`, `idcategoria`, `tipo_producto`, `created_at`, `kind`, `condicion`) VALUES
(1, '', '1', 'Tarima 40x40', 'Nueva', 10, 0, NULL, 'unidad', 'Tarima grande', 1, 1, 2, '2021-12-21 18:32:35', 1, 1),
(2, '', '2', 'Madera de pino', 'para realizar tarimas', 10, 0, NULL, 'pies', '6 pies', 1, 1, 1, '2021-12-21 18:34:47', 1, 1),
(3, '', '3', 'cola', 'cola para muebles', 10, 0, NULL, '1 litro', 'Botella', 1, 1, 1, '2021-12-21 18:35:57', 1, 1),
(4, '', '4', 'tarima 50X50', 'tarima de pino', 10, 0, NULL, 'pies', 'Tarima grande', 1, 1, 2, '2021-12-21 23:47:13', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `id` int(11) NOT NULL,
  `nombrepago` varchar(25) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`id`, `nombrepago`) VALUES
(1, 'Pagado'),
(2, 'Credito'),
(3, 'Abastecimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccion`
--

CREATE TABLE `transaccion` (
  `idingreso` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `tipo_comprobante` int(11) DEFAULT NULL,
  `codigo_factura` varchar(255) DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `comentario` text,
  `ref_id` int(11) DEFAULT NULL,
  `sell_from_id` int(11) DEFAULT NULL,
  `idpersona` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `tipo_operacion_id` int(11) DEFAULT NULL,
  `caja_id` int(11) DEFAULT NULL,
  `tipo_pago` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL,
  `forma_pago` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `efectivo` double DEFAULT NULL,
  `iva` double DEFAULT NULL,
  `descuento` double DEFAULT NULL,
  `is_draft` tinyint(1) NOT NULL DEFAULT '0',
  `almacen_to_id` int(11) DEFAULT NULL,
  `almacen_des_id` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `transaccion`
--

INSERT INTO `transaccion` (`idingreso`, `fecha`, `tipo_comprobante`, `codigo_factura`, `serie`, `comentario`, `ref_id`, `sell_from_id`, `idpersona`, `idusuario`, `tipo_operacion_id`, `caja_id`, `tipo_pago`, `estatus`, `forma_pago`, `total`, `efectivo`, `iva`, `descuento`, `is_draft`, `almacen_to_id`, `almacen_des_id`, `estado`, `created_at`) VALUES
(1, '2021-12-16', 1, '1', 'A', NULL, NULL, NULL, 1, 1, 1, NULL, 1, NULL, 1, 3000, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-16 23:02:13'),
(2, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 6, NULL, 1, NULL, 1, 1000, NULL, NULL, NULL, 0, 2, 1, 1, '2021-12-16 23:03:23'),
(3, '2021-12-16', 1, '1', 'a', NULL, NULL, NULL, 2, 1, 2, NULL, 2, NULL, 1, 500, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-16 23:05:20'),
(7, '2021-12-16', 1, '2', 'A', NULL, NULL, NULL, 3, 1, 2, NULL, 2, NULL, 1, 2500, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-17 02:17:16'),
(8, '2021-12-17', 1, '5', 'A', NULL, NULL, NULL, 2, 1, 2, NULL, 2, NULL, 1, 100, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-17 20:49:22'),
(9, '2021-12-17', 1, '25', 'A', NULL, NULL, NULL, 3, 1, 2, NULL, 2, NULL, 1, 8, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-17 20:49:26'),
(10, '2021-12-17', 1, '5561', 'A', NULL, NULL, NULL, 2, 1, 2, NULL, 2, NULL, 1, 250, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-17 20:49:33'),
(11, '2021-12-17', 1, '545154', 'A', NULL, NULL, NULL, 2, 1, 2, NULL, 2, NULL, 1, 500, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-17 22:32:25'),
(12, '2021-12-20', 1, '22', 'A', NULL, NULL, NULL, 2, 1, 2, NULL, 2, NULL, 1, 20, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-21 02:59:39'),
(13, '2021-12-20', 1, '25', 'A', NULL, NULL, NULL, 1, 1, 1, NULL, 1, NULL, 1, 500, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-21 03:56:47'),
(14, '2021-12-20', 1, '25', 'S', NULL, NULL, NULL, 2, 1, 2, NULL, 1, NULL, 1, 39, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-21 05:24:39'),
(29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:49:10'),
(30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:49:14'),
(31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:49:17'),
(32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:49:21'),
(33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:49:26'),
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:49:30'),
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:49:33'),
(36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:49:36'),
(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:49:39'),
(38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:49:44'),
(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 06:22:24'),
(40, '2021-12-21', 1, '26', 'A', NULL, NULL, NULL, 1, 1, 1, NULL, 1, NULL, 1, 250, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-21 16:51:11'),
(41, '2021-12-21', 1, '27', 'A', NULL, NULL, NULL, 2, 1, 2, NULL, 1, NULL, 1, 90, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-21 17:11:18'),
(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 105, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:17:49'),
(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 80, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:22:10'),
(44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 25, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:25:55'),
(45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 50, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:27:03'),
(46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 55, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:29:32'),
(47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 26, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:30:47'),
(48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 26, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:33:56'),
(49, '2021-12-21', 1, '55', 'a', NULL, NULL, NULL, 2, 1, 2, NULL, 1, NULL, 1, 22, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-21 17:34:44'),
(50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 25, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:35:25'),
(51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 77, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:36:17'),
(52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 25, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:37:15'),
(53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 52, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:38:55'),
(54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 27, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:40:46'),
(55, '2021-12-21', 1, '25', 'a', NULL, NULL, NULL, 1, 1, 1, NULL, 1, NULL, 1, 250, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-21 17:56:52'),
(56, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 75, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 17:57:49'),
(57, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 150, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 18:52:20'),
(58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 150, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 18:53:47'),
(59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 125, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 19:01:02'),
(60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 125, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 22:39:35'),
(61, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 95, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-21 23:00:39'),
(62, '2021-12-21', 1, '55', 'a', NULL, NULL, NULL, 2, 1, 2, NULL, 1, NULL, 1, 275, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-21 23:39:26'),
(63, '2021-12-21', 1, '1111', 'A', NULL, NULL, NULL, 2, 1, 2, NULL, 2, NULL, 1, 100, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-22 03:27:27'),
(64, '2021-12-22', 1, '2512', 'A', NULL, NULL, NULL, 2, 1, 2, NULL, 2, NULL, 1, 250, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-22 06:29:33'),
(65, '2021-12-22', 1, '200', 'A', NULL, NULL, NULL, 2, 1, 2, NULL, 2, NULL, 1, 100, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-22 06:33:00'),
(66, '2021-12-22', 2, '55', 'A', NULL, NULL, NULL, 2, 1, 2, NULL, 2, NULL, 1, 300, NULL, 0, NULL, 0, NULL, NULL, 1, '2021-12-22 06:35:24'),
(67, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 127, NULL, NULL, NULL, 0, NULL, NULL, 1, '2021-12-22 06:59:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `apellido`, `telefono`, `email`, `cargo`, `login`, `password`, `imagen`, `condicion`, `created_at`) VALUES
(1, 'Donal', 'Gevara', '4771577', 'fabian@gmail.com', 'Administrador de sistemas', 'DonalG', 'd033e22ae348aeb5660fc2140aec35850c4da997', '1487132068.jpg', 1, '2021-07-22 08:31:05'),
(2, 'Milton', 'Merlos', '54785211', 'mmerlos@gmail.com', 'Bodegero', 'mmerlos', '7c222fb2927d828af22f592134e8932480637c0d', '1626971823.jpg', 1, '0000-00-00 00:00:00'),
(3, 'Bryan', 'rodriguez', '931742904', 'super@gmial.com', 'adminsitrador', 'super', 'd033e22ae348aeb5660fc2140aec35850c4da997', '1487132068.jpg', 1, '0000-00-00 00:00:00'),
(4, 'elia', 'Flores', '54671677', 'eli92sury@gmail.com', 'Licenciada', 'eliflores', 'd033e22ae348aeb5660fc2140aec35850c4da997', '', 1, '0000-00-00 00:00:00'),
(5, 'Donald', 'Guevara', '42546094', 'Donal@gmail.com', 'Administrador', 'DonalG', 'c7b377b58653e6310ac0a8593af3d9befd11de5c', '', 1, '0000-00-00 00:00:00'),
(6, 'Fabian', 'Flores', '546774406', 'ffloresl1@miumg.edu.gt', 'Admin', 'ffloresl', 'da42b120cebb490722771c8ea8ffbaf39d66af15', '1638595991.jpg', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`id`, `idusuario`, `idpermiso`) VALUES
(154, 2, 2),
(155, 2, 5),
(177, 4, 1),
(178, 4, 2),
(179, 4, 3),
(180, 4, 4),
(181, 4, 5),
(182, 4, 6),
(183, 4, 7),
(187, 3, 2),
(188, 5, 1),
(189, 5, 2),
(190, 5, 3),
(191, 1, 1),
(192, 1, 2),
(193, 1, 3),
(194, 1, 4),
(195, 1, 5),
(196, 1, 6),
(197, 1, 7),
(198, 1, 8),
(199, 1, 9),
(200, 1, 9),
(201, 6, 1),
(202, 6, 2),
(203, 6, 3),
(204, 1, 10),
(205, 1, 10),
(206, 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(10) NOT NULL,
  `idcliente` int(10) NOT NULL,
  `idusuario` int(10) NOT NULL,
  `tipo_comprobante` int(3) NOT NULL,
  `serie_comprobante` varchar(50) COLLATE utf8_bin NOT NULL,
  `num_comprobante` int(10) NOT NULL,
  `fecha_hora` date NOT NULL,
  `impuesto` int(10) DEFAULT NULL,
  `total_venta` double NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '0',
  `create_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `idcliente`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_venta`, `estado`, `create_at`) VALUES
(1, 2, 1, 1, 'a', 1, '2021-12-16', 0, 500, 0, '2021-12-16 17:05:20'),
(5, 3, 1, 1, 'A', 2, '2021-12-16', 0, 2500, 0, '2021-12-16 20:17:16'),
(6, 2, 1, 1, 'A', 5, '2021-12-17', 0, 100, 0, '2021-12-17 11:29:32'),
(7, 3, 1, 1, 'A', 25, '2021-12-17', 0, 8, 0, '2021-12-17 11:31:19'),
(8, 2, 1, 1, 'A', 5561, '2021-12-17', 0, 250, 0, '2021-12-17 14:16:24'),
(9, 2, 1, 1, 'A', 545154, '2021-12-17', 0, 500, 0, '2021-12-17 16:32:25'),
(10, 2, 1, 1, 'A', 22, '2021-12-20', 0, 20, 0, '2021-12-20 20:59:39'),
(11, 2, 1, 1, 'S', 25, '2021-12-20', 0, 39, 0, '2021-12-20 23:24:39'),
(12, 2, 1, 1, 'A', 27, '2021-12-21', 0, 90, 0, '2021-12-21 11:11:18'),
(13, 2, 1, 1, 'a', 55, '2021-12-21', 0, 22, 0, '2021-12-21 11:34:44'),
(14, 2, 1, 1, 'a', 55, '2021-12-21', 0, 275, 0, '2021-12-21 17:39:26'),
(15, 2, 1, 1, 'A', 1111, '2021-12-21', 0, 100, 0, '2021-12-21 21:27:27'),
(16, 2, 1, 1, 'A', 2512, '2021-12-22', 0, 250, 0, '2021-12-22 00:29:33'),
(17, 2, 1, 1, 'A', 200, '2021-12-22', 0, 100, 0, '2021-12-22 00:33:00'),
(18, 2, 1, 2, 'A', 55, '2021-12-22', 0, 300, 0, '2021-12-22 00:35:24');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`idalmacen`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cajachica`
--
ALTER TABLE `cajachica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `credito`
--
ALTER TABLE `credito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersona` (`idpersona`),
  ADD KEY `transaccion_id` (`transaccion_id`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD KEY `fk_venta` (`idventa`),
  ADD KEY `fk_producto` (`idarticulo`);

--
-- Indices de la tabla `gastos_ingreso`
--
ALTER TABLE `gastos_ingreso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caja_id` (`caja_id`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operacion`
--
ALTER TABLE `operacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idalmacen` (`idalmacen`),
  ADD KEY `idalmacen_des` (`idalmacen_des`),
  ADD KEY `idproducto` (`idproducto`),
  ADD KEY `transaccion_id` (`transaccion_id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersona` (`idpersona`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `idcategoria` (`idcategoria`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `caja_id` (`caja_id`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idpersona` (`idpersona`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idpermiso` (`idpermiso`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `pk_idcliente` (`idcliente`),
  ADD KEY `pk_idusuario` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `idalmacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cajachica`
--
ALTER TABLE `cajachica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `credito`
--
ALTER TABLE `credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `gastos_ingreso`
--
ALTER TABLE `gastos_ingreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operacion`
--
ALTER TABLE `operacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `idingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `credito`
--
ALTER TABLE `credito`
  ADD CONSTRAINT `credito_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`),
  ADD CONSTRAINT `credito_ibfk_2` FOREIGN KEY (`transaccion_id`) REFERENCES `transaccion` (`idingreso`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_producto` FOREIGN KEY (`idarticulo`) REFERENCES `producto` (`idproducto`),
  ADD CONSTRAINT `fk_venta` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`);

--
-- Filtros para la tabla `gastos_ingreso`
--
ALTER TABLE `gastos_ingreso`
  ADD CONSTRAINT `gastos_ingreso_ibfk_1` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`id`);

--
-- Filtros para la tabla `operacion`
--
ALTER TABLE `operacion`
  ADD CONSTRAINT `operacion_ibfk_1` FOREIGN KEY (`idalmacen`) REFERENCES `almacen` (`idalmacen`),
  ADD CONSTRAINT `operacion_ibfk_2` FOREIGN KEY (`idalmacen_des`) REFERENCES `almacen` (`idalmacen`),
  ADD CONSTRAINT `operacion_ibfk_3` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`),
  ADD CONSTRAINT `operacion_ibfk_4` FOREIGN KEY (`transaccion_id`) REFERENCES `transaccion` (`idingreso`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`),
  ADD CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD CONSTRAINT `transaccion_ibfk_1` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`id`),
  ADD CONSTRAINT `transaccion_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`),
  ADD CONSTRAINT `transaccion_ibfk_3` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`);

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `usuario_permiso_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`),
  ADD CONSTRAINT `usuario_permiso_ibfk_2` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `pk_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `persona` (`idpersona`),
  ADD CONSTRAINT `pk_idusuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
