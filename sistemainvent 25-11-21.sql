-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2021 a las 09:11:31
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
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`idalmacen`, `nombre`, `direccion`, `telefono`, `email`, `is_principal`, `created_at`) VALUES
(1, 'Bodega principal 2.1', 'Sanarate', '54674406', 'bodegaprin@gmail.com', 1, '0000-00-00 00:00:00'),
(2, 'bodega de producción', 'Barrio el Centro, Aldea El Rancho', '54151515', 'bodegapro@gmail.com', 0, '0000-00-00 00:00:00'),
(3, 'bodega de produccion 20.', 'El Rancho', '54165151', 'fabian.17antoni@gmail.com', 1, '0000-00-00 00:00:00'),
(4, 'Bodega Capital', 'Zona 12', '79354040', 'capital@gmail.com', 0, '0000-00-00 00:00:00');

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
(1, 'Madera de Pino', 'Esta es utilizada para tarimas y mesas', 1, '2021-07-22 18:13:42'),
(2, 'tarima', 'para la venta', 1, '0000-00-00 00:00:00'),
(3, 'tarima', 'buena', 1, '2021-08-31 02:18:14');

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
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 4, NULL, NULL, NULL, 50, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-27 17:44:40'),
(2, 5, NULL, NULL, NULL, 50, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-30 19:58:46'),
(3, 6, NULL, NULL, NULL, 0, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-30 20:01:05'),
(4, 7, NULL, NULL, NULL, 0, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-30 20:47:41'),
(5, 8, NULL, NULL, NULL, 0, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-30 20:47:49'),
(6, 9, NULL, NULL, NULL, 0, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-30 20:49:22'),
(7, 10, NULL, NULL, NULL, 0, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-30 20:57:56'),
(8, 11, NULL, NULL, NULL, 0, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-30 21:21:36'),
(9, 12, NULL, NULL, NULL, 0, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-30 21:28:24'),
(10, 13, NULL, NULL, NULL, 0, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-30 21:28:32'),
(11, 14, NULL, NULL, NULL, 0, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-30 21:30:26'),
(12, 15, NULL, NULL, NULL, 50, NULL, NULL, 1, NULL, 1, 0, 0, '2021-08-31 02:21:23'),
(13, 2, NULL, NULL, NULL, 10, 1, 1, 1, 1, 1, 0, 0, '2021-11-25 08:08:48'),
(14, 3, NULL, NULL, NULL, 10, 1, 1, 1, 1, 1, 0, 0, '2021-11-25 08:08:48');

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
(9, 'Planilla');

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
(1, 'milton2', 'Merlos2', 2, '45151222222', NULL, 'Sanarate222', '5415151522', '54674406222', 'milton22@gmail.com', NULL, 0, NULL, 1, 1, '0000-00-00 00:00:00'),
(2, 'Fabian', 'Flores', 1, '15151', NULL, 'El Rancho', '4545151', '51515151', 'fabian.17antoni@gmail.com', NULL, 0, NULL, 1, 1, '0000-00-00 00:00:00'),
(3, 'bryan', 'Rodriguez', 1, '454545', NULL, 'El Rancho', '45451545', '5454545', 'bodegapro@gmail.com', NULL, 0, NULL, 1, 1, '0000-00-00 00:00:00'),
(4, 'Express', 'Sanarate', 1, '66116', NULL, 'Parque central', '55521542', '11111', 'coffesan@expresscoffe.com.gt', NULL, 0, NULL, 1, 1, '0000-00-00 00:00:00'),
(5, 'Luis', 'Lopez', 2, '606060', NULL, 'Jicaro', '60606060', '79255050', 'luis@gmail.com', NULL, 0, NULL, 1, 1, '0000-00-00 00:00:00'),
(6, 'Jose', 'Perez Leon', 2, '101010', NULL, 'Guastatoya', '10102020', '79252525', 'jose@gmail.com', NULL, 0, NULL, 2, 1, '0000-00-00 00:00:00'),
(7, 'Antonia', 'perez', 2, '808080', NULL, 'Jicaro', '10101010', '80808080', 'antoni@gmail.com', NULL, 0, NULL, 2, 1, '0000-00-00 00:00:00'),
(8, 'Oseas', 'Vasquez', 1, '40406060', NULL, 'San Marcos', '55552020', '79251012', 'oseas@gmail.com', NULL, 0, NULL, 1, 1, '0000-00-00 00:00:00'),
(9, 'Osiel', 'Velasquez', 2, '50507070', NULL, 'Huehuetenango', '55557742', '79354040', 'Osiel@hotmail.com', NULL, 0, NULL, 2, 1, '0000-00-00 00:00:00'),
(10, 'Pedro Luis', 'Juarez Gamarro.', 2, '2366689091601.', NULL, 'San Agustin.', '55553030.', NULL, 'pedro@hotmail.com', 'Bodeguero', 0, NULL, 3, 1, '0000-00-00 00:00:00'),
(11, 'Josue', 'Colindres', 2, '2366979011901', NULL, 'El Rancho', '44556323', NULL, 'josue@gmail.com', 'Tarimero2', 0, NULL, 3, 1, '0000-00-00 00:00:00'),
(12, 'Evelyn', 'Loaiza', 2, '40+40840', NULL, 'Sanarate', '55046045', NULL, 'evelyn@gmail.com', 'Asistente', 0, NULL, 3, 1, '0000-00-00 00:00:00'),
(18, 'sdfasdf', 'asdfasd', 2, 'asdfasd', NULL, 'adsfa', 'sadfa', NULL, 'fabian@gmail.com', 'dafasdf', 0, NULL, 3, 1, '0000-00-00 00:00:00'),
(19, 'Express', 'Sanarate', 1, '4545454', NULL, 'Parque central', '55521542', '4444444', 'coffesan@expresscoffe.com.gt', NULL, 0, NULL, 2, 1, '0000-00-00 00:00:00'),
(20, 'Milton', 'Merlos', 1, '444444515', NULL, 'Sanarate', '55521542', '55221215', 'er617820@gmail.com', NULL, 0, NULL, 1, 1, '0000-00-00 00:00:00'),
(21, 'Milton', 'Merlos', 2, '22223232323', NULL, 'Sanarate', '55521542', NULL, 'er617820@gmail.com', 'Administrador', 0, NULL, 3, 1, '0000-00-00 00:00:00');

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kind` int(11) NOT NULL DEFAULT '1',
  `condicion` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `imagen`, `codigo`, `nombre`, `descripcion`, `inventario_min`, `precio_en`, `id_precio_lis`, `unit`, `presentation`, `idusuario`, `idcategoria`, `created_at`, `kind`, `condicion`) VALUES
(2, '', '2552521', 'tarima nueva actualziada', 'tarima de pino.20', 10, 0, NULL, 'unidad2', 'Tarima grande doble', NULL, 1, '2021-08-31 01:16:22', 1, 1),
(3, '', '2426', 'banco', 'banco para niño', 10, 0, NULL, 'decena', 'banco grande', NULL, 1, '2021-08-31 01:23:59', 1, 1),
(4, '', '2425', 'tarima 2.0', 'para la venta', 10, 0, NULL, 'unidad', 'Mesa', NULL, 1, '2021-08-27 17:44:40', 1, 1),
(5, '', '45454111', 'tarima 22', 'para la venta2', 10, 0, NULL, 'unidad2', 'Mesa1', NULL, 1, '2021-08-31 01:49:36', 1, 1),
(6, '', '45454', 'tarima nueva', 'para la venta', 10, 0, NULL, '', '', NULL, 1, '2021-08-31 01:49:41', 1, 1),
(7, '', '45454', 'tarima nueva 2', 'para la venta', 10, 0, NULL, '', '', NULL, 1, '2021-08-30 20:51:41', 1, 0),
(8, '', '2424', 'tarima22222', 'tarima de pino', 10, 0, NULL, 'unidad', 'Tarima grande', NULL, 1, '2021-08-30 20:51:28', 1, 0),
(9, '', '45454', 'tarima nueva 20.', 'para la ventagg', 10, 0, NULL, '', '', NULL, 1, '2021-08-30 20:51:20', 1, 0),
(10, '', '2425', 'tarima 2.0.1.1.1.1', 'para la venta', 10, 0, NULL, 'unidad', 'Mesa', NULL, 1, '2021-08-30 20:57:56', 1, 1),
(11, '', '2424', 'tarima 2.0000', 'tarima de pino', 10, 0, NULL, 'unidad', 'Tarima grande', NULL, 1, '2021-08-30 21:21:36', 1, 1),
(12, '', '2424', 'tarima', 'tarima de pino', 10, 0, NULL, 'unidad', 'Tarima grande', NULL, 1, '2021-08-30 21:28:24', 1, 1),
(13, '', '2424', 'tarima44444444', 'tarima de pino', 10, 0, NULL, 'unidad', 'Tarima grande', NULL, 1, '2021-08-30 21:28:32', 1, 1),
(14, '', '2424', 'tarima2222', 'tarima de pino', 10, 0, NULL, '', '', NULL, 1, '2021-08-30 21:30:26', 1, 1),
(15, '1630376484.jpg', '252110', 'TARIMA', 'NUEVA', 10, 0, NULL, 'unidad', 'Tarima', NULL, 2, '2021-08-31 02:24:14', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccion`
--

CREATE TABLE `transaccion` (
  `idingreso` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tipo_comprobante` int(11) DEFAULT NULL,
  `codigo_factura` varchar(255) DEFAULT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `comentario` text,
  `ref_id` int(11) DEFAULT NULL,
  `sell_from_id` int(11) DEFAULT NULL,
  `idpersona` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `tipo_operacion_id` int(11) DEFAULT '2',
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
(1, '2021-11-20', 2, '20', 'ZZ', NULL, NULL, NULL, 2, 1, 2, NULL, NULL, NULL, NULL, 20, NULL, 10, NULL, 0, NULL, NULL, 1, '2021-11-25 08:08:48');

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
(5, 'Donald', 'Guevara', '42546094', 'Donal@gmail.com', 'Administrador', 'DonalG', 'c7b377b58653e6310ac0a8593af3d9befd11de5c', '', 1, '0000-00-00 00:00:00');

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
(200, 1, 9);

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `idalmacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `credito`
--
ALTER TABLE `credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `idingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
