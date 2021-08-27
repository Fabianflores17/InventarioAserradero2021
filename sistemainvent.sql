-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-07-2021 a las 20:51:50
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
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_principal` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`, `condicion`, `created_at`) VALUES
(1, 'Madera de Pino', 'Esta es utilizada para tarimas y mesas', 1, '2021-07-22 12:13:42');

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
  `idalmacen` int(11) NOT NULL,
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
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(7, 'Consulta Ventas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(50) NOT NULL,
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `inventario_min` int(11) NOT NULL DEFAULT '10',
  `precio_en` float NOT NULL,
  `id_precio_lis` float DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `presentation` varchar(255) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idcategoria` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `kind` int(11) NOT NULL DEFAULT '1',
  `condicion` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccion`
--

CREATE TABLE `transaccion` (
  `id` int(11) NOT NULL,
  `codigo_factura` varchar(255) DEFAULT NULL,
  `invoice_file` varchar(255) DEFAULT NULL,
  `comentario` text,
  `ref_id` int(11) DEFAULT NULL,
  `sell_from_id` int(11) DEFAULT NULL,
  `idpersona` int(11) DEFAULT NULL,
  `idusario` int(11) DEFAULT NULL,
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
  `status` int(11) DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'Fabian Antonio', 'Flores lopez', '4771577', 'fabian@gmail.com', 'Administrador de sistemas', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '1487132068.jpg', 1, '2021-07-22 08:31:05'),
(2, 'Milton', 'Merlos', '54785211', 'mmerlos@gmail.com', 'Bodegero', 'mmerlos', '7c222fb2927d828af22f592134e8932480637c0d', '1626971823.jpg', 1, '0000-00-00 00:00:00'),
(3, 'Bryan', 'rodriguez', '931742904', 'super@gmial.com', 'adminsitrador', 'super', 'd033e22ae348aeb5660fc2140aec35850c4da997', '1487132068.jpg', 1, '0000-00-00 00:00:00'),
(4, 'elia', 'Flores', '54671677', 'eli92sury@gmail.com', 'Licenciada', 'eliflores', 'd033e22ae348aeb5660fc2140aec35850c4da997', '', 1, '0000-00-00 00:00:00');

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
(141, 1, 1),
(142, 1, 2),
(143, 1, 3),
(144, 1, 4),
(145, 1, 5),
(146, 1, 6),
(147, 1, 7),
(154, 2, 2),
(155, 2, 5),
(177, 4, 1),
(178, 4, 2),
(179, 4, 3),
(180, 4, 4),
(181, 4, 5),
(182, 4, 6),
(183, 4, 7),
(187, 3, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcategoria` (`idcategoria`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caja_id` (`caja_id`),
  ADD KEY `idusario` (`idusario`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `credito`
--
ALTER TABLE `credito`
  ADD CONSTRAINT `credito_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `credito_ibfk_2` FOREIGN KEY (`transaccion_id`) REFERENCES `transaccion` (`id`);

--
-- Filtros para la tabla `gastos_ingreso`
--
ALTER TABLE `gastos_ingreso`
  ADD CONSTRAINT `gastos_ingreso_ibfk_1` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`id`);

--
-- Filtros para la tabla `operacion`
--
ALTER TABLE `operacion`
  ADD CONSTRAINT `operacion_ibfk_1` FOREIGN KEY (`idalmacen`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `operacion_ibfk_2` FOREIGN KEY (`idalmacen_des`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `operacion_ibfk_3` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `operacion_ibfk_4` FOREIGN KEY (`transaccion_id`) REFERENCES `transaccion` (`id`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`),
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
  ADD CONSTRAINT `transaccion_ibfk_2` FOREIGN KEY (`idusario`) REFERENCES `usuario` (`idusuario`),
  ADD CONSTRAINT `transaccion_ibfk_3` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`);

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
