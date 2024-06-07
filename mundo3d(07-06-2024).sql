-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2024 a las 00:14:30
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
-- Base de datos: `mundo3d`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

CREATE TABLE `calendario` (
  `identificador` int(4) NOT NULL,
  `evento` varchar(25) NOT NULL,
  `color_evento` varchar(25) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `usuario` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `Pe_Cliente` int(10) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `estado_pago` enum('pendiente','pagado') NOT NULL DEFAULT 'pendiente',
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `Pe_Cliente`, `cantidad`, `estado_pago`, `id_producto`) VALUES
(52, 1131110766, 1, 'pendiente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `Cgo_Codigo` int(1) NOT NULL,
  `Cgo_Nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`Cgo_Codigo`, `Cgo_Nombre`) VALUES
(1, 'Impresoras'),
(2, 'Repuestos'),
(3, 'Mantenimiento'),
(4, 'Impresion'),
(5, 'Archivos 3D');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `Identificador` int(100) NOT NULL,
  `Pe_Cliente` int(10) NOT NULL,
  `Pe_Estado` int(1) NOT NULL,
  `Pe_Producto` int(11) NOT NULL,
  `Pe_Cantidad` int(5) NOT NULL,
  `Pe_Fechapedido` date NOT NULL,
  `Pe_Fechaentrega` date NOT NULL,
  `pe_nombre_pedido` varchar(255) NOT NULL,
  `Pe_Observacion` varchar(50) NOT NULL,
  `Acciones` enum('activo','inactivo') DEFAULT 'activo',
  `pe_tipo_impresion` varchar(50) DEFAULT NULL,
  `pe_color` varchar(30) DEFAULT NULL,
  `nombre_imagen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`Identificador`, `Pe_Cliente`, `Pe_Estado`, `Pe_Producto`, `Pe_Cantidad`, `Pe_Fechapedido`, `Pe_Fechaentrega`, `pe_nombre_pedido`, `Pe_Observacion`, `Acciones`, `pe_tipo_impresion`, `pe_color`, `nombre_imagen`) VALUES
(1, 1026577616, 3, 2, 2, '2013-01-02', '2015-12-02', '', 'En proceso', 'activo', 'Filamento', 'Azul', '../images/imagenes_pedidos/pedido-1.jpg'),
(2, 1026577616, 4, 8, 2, '2024-05-15', '2024-04-16', '', '123', 'activo', 'Tereftalato de Polietileno Glicol', 'Blanco Menta', '../images/imagenes_pedidos/pedido-2.jpg'),
(3, 1131110766, 3, 3, 23, '0000-00-00', '2024-04-29', '', '1234', 'activo', 'Tereftalato de Polietileno', 'Yordy', '../images/imagenes_pedidos/pedido-3.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_estado`
--

CREATE TABLE `pedido_estado` (
  `Es_Codigo` int(1) NOT NULL,
  `Es_Nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido_estado`
--

INSERT INTO `pedido_estado` (`Es_Codigo`, `Es_Nombre`) VALUES
(1, 'Nuevo'),
(2, 'Confirmado'),
(3, 'En proceso'),
(4, 'Terminado'),
(5, 'Entregado'),
(6, 'Cancelado'),
(7, 'Devuelto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Identificador` int(11) NOT NULL,
  `Pro_Nombre` varchar(50) NOT NULL,
  `Pro_Descripcion` varchar(255) NOT NULL,
  `Pro_Categoria` int(1) NOT NULL,
  `Pro_Cantidad` int(20) NOT NULL,
  `Pro_PrecioVenta` int(255) NOT NULL,
  `Pro_Costo` decimal(10,0) DEFAULT NULL,
  `Pro_Estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `nombre_imagen` varchar(50) NOT NULL,
  `descripcion_imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Identificador`, `Pro_Nombre`, `Pro_Descripcion`, `Pro_Categoria`, `Pro_Cantidad`, `Pro_PrecioVenta`, `Pro_Costo`, `Pro_Estado`, `nombre_imagen`, `descripcion_imagen`) VALUES
(1, 'Creality Ender 3 pro', 'Creality Ender 3 pro , permite imprimir de forma asequible numerosos tipos de filamento: PLA, ABS, PETG, flexible, entre otros en un volumen de impresión por encima del estándar', 1, 8, 190, 600000, 'activo', '../images/imagenes_catalogo/catalogo-1.png', ''),
(2, 'Tairona XL  Doble Ext', 'Tairona XL Doble Ext,  Ensamblada. En acero inoxidable con autonivelación de cama y base calefactada. Imprime multiples materiales como: ABS, PLA, TPU, TPE, PVA, PETG, MADERA, SMOOTH, HIPS, NYLON, FIBRA DE CARBONO', 1, 0, 3490000, 200, 'activo', '../images/imagenes_catalogo/catalogo-2.png', ''),
(3, 'BOQUILLA O NOZZLE DE 0.2/0.3/0.4/0.6/0.8/1.0/1.2 M', 'Material: Latón\r\nPrecisión de la boquilla: 0.4mm\r\nDiámetro de entrada: 1.75mm\r\nDiámetro de la rosca externa: 6 mm\r\nDiámetro del hexágono: 6 mm', 2, 6, 12000, NULL, 'activo', '../images/imagenes_catalogo/catalogo-3.png', ''),
(4, 'RODAMIENTOS DE ACERO CARBONO ARTILLERY GENIUS/X1', 'Componente de repuesto para impresora 3D. Unos rodamientos en mal estado repercutirá en una mala calidad de impresión 3D.Rodamientos de goma silenciosos compatibles con ARTILLERY GENIUS y SIDEWINDER X1Material: Acero al carbono y goma de alta cali', 2, 7, 12000, 0, 'activo', '../images/imagenes_catalogo/catalogo-4.webp', ''),
(5, 'Crealily  Ender 3 Pro', 'Crealily  Ender 3 Pro, se le va a realizar limpieza y cambio del rodamiento ', 3, 1, 200000, 0, 'activo', '../images/imagenes_catalogo/catalogo-5.png', ''),
(6, 'Tairona XL  Doble Ext.', 'Tairona XL Doble Ext, se va a realizar el cambio de PIÑÓN DENTADO EXTRUSOR TITAN ARTILLERY GENIUS/X1 y cargar el filamento ', 3, 5, 230000, 0, 'activo', '../images/imagenes_catalogo/catalogo-6.png', ''),
(7, 'impresión de un dragón ', 'impresión de un dragón en el color rojo con ojos negros ', 4, 8, 500000, 0, 'activo', '../images/imagenes_catalogo/catalogo-7.jpg', ''),
(8, 'figura de acción de luffy de one piece', 'impresión 3d de una figura de acción de luffy de one piece con los colores (negro, rojo, piel, café, azul y rojo) ', 4, 2, 850000, 400000, 'activo', '../images/imagenes_catalogo/catalogo-8.jpg', ''),
(9, 'Fiat-Abarth 750 GT Zagota', 'Modelo para impresora en modelo FDM\r\nPARÁMETROS DE IMPRESIÓN 3D\r\nAltura de capa 0.2\r\nTemperatura hotend 205\r\nCama 50\r\nRelleno 10% giroide\r\nTiempo de impresión carrocería 17 horas aprox.\r\nResto de piezas 10 horas\r\nMedidas:\r\nAncho 62 mm\r\nLargo 146 mm\r\nAlto ', 5, 6, 500000, 250000, 'activo', '../images/imagenes_catalogo/catalogo-9.jpg', ''),
(10, 'imagen de calavera', 'imagen en 3d de calavera ', 5, 3, 0, NULL, 'activo', '../images/imagenes_catalogo/catalogo-10.jpg', '');

--
-- Disparadores `productos`
--
DELIMITER $$
CREATE TRIGGER `actualizarPrecioVenta` BEFORE UPDATE ON `productos` FOR EACH ROW BEGIN
    IF NEW.Pro_Costo <> OLD.Pro_Costo THEN
        SET NEW.Pro_PrecioVenta = NEW.Pro_Costo * 2; -- Puedes ajustar la fórmula según tu necesidad
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `actualizarPrecioVentaBeforeInsert` BEFORE INSERT ON `productos` FOR EACH ROW BEGIN
    SET NEW.Pro_PrecioVenta = NEW.Pro_Costo * 2;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `Tipo` int(1) NOT NULL,
  `Nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`Tipo`, `Nombre`) VALUES
(1, 'Administrador'),
(2, 'Colaborador'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Usu_Identificacion` int(10) NOT NULL,
  `Usu_Nombre_completo` varchar(20) NOT NULL,
  `Usu_Telefono` varchar(20) NOT NULL,
  `Usu_Email` varchar(50) NOT NULL,
  `Usu_Ciudad` varchar(20) NOT NULL,
  `Usu_Direccion` varchar(50) NOT NULL,
  `Usu_Contraseña` varchar(5000) NOT NULL,
  `Usu_Rol` int(1) NOT NULL,
  `Usu_Estado` enum('activo','inactivo') DEFAULT 'activo',
  `Usu_Pedidos` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Usu_Identificacion`, `Usu_Nombre_completo`, `Usu_Telefono`, `Usu_Email`, `Usu_Ciudad`, `Usu_Direccion`, `Usu_Contraseña`, `Usu_Rol`, `Usu_Estado`, `Usu_Pedidos`) VALUES
(1000698993, 'Juan David Penagos', '3108199377', 'jjuandavid2003@gmail.com', 'Bogotá', 'Calle 19 El Bronx', '$2y$10$4YSTOtpwRnNK9lRF83yC7eQNbp4XuykCGhOGzhE4K3B.fixR3309i', 3, 'activo', NULL),
(1026577616, 'Yordy Suárez Bonilla', '3214996400', 'ysuarez61@misena.edu.co', 'Bogotá', 'Calle Falsa # 123', '$2y$10$DjDdnVOHHBR6rnG2yc73Iut2xUU8c0n5O53n0DdAVbvayZ1smsdU.', 2, 'activo', NULL),
(1026577618, 'Yordy Suarez', 'Usuario', 'yordy_9328@hotmail.com', 'Bogota D.C.', 'CL 72 SUR 22 26', '$2y$10$WNVnjb/exohqd3hKbyqfQuKk5HcCd5IgBBZOE9bFBOD5OX9IdXvwu', 1, 'activo', NULL),
(1131110766, 'Ruben Dario Triviño', '3113287379', 'darioruben876@gmail.com', 'Bogotá', 'suba-bogota', '$2y$10$PGM06.gFmaiE7JxFpl9Fz.4TkyqEwW4IkOHsRg/pbjvyNVKzBt5Sm', 3, 'activo', NULL),
(2147483647, 'Ronal', '3210000000', 'rudatrivi@hotmail.com', 'Bogotá', 'Calle 19', '$2y$10$lqk4gNcPvTNZZTKddPOl6OuNQQc8bPxJEF.FmhUNGHPZX0HJHbCr6', 2, 'activo', NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistausuarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vistausuarios` (
`Usu_Identificacion` int(10)
,`Usu_Nombre_completo` varchar(20)
,`Usu_Telefono` varchar(20)
,`Usu_Email` varchar(50)
,`Usu_Ciudad` varchar(20)
,`Usu_Direccion` varchar(50)
,`Usu_Contraseña` varchar(5000)
,`Usu_Rol` int(1)
,`Usu_Pedidos` int(100)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vistausuarios`
--
DROP TABLE IF EXISTS `vistausuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistausuarios`  AS SELECT `usuario`.`Usu_Identificacion` AS `Usu_Identificacion`, `usuario`.`Usu_Nombre_completo` AS `Usu_Nombre_completo`, `usuario`.`Usu_Telefono` AS `Usu_Telefono`, `usuario`.`Usu_Email` AS `Usu_Email`, `usuario`.`Usu_Ciudad` AS `Usu_Ciudad`, `usuario`.`Usu_Direccion` AS `Usu_Direccion`, `usuario`.`Usu_Contraseña` AS `Usu_Contraseña`, `usuario`.`Usu_Rol` AS `Usu_Rol`, `usuario`.`Usu_Pedidos` AS `Usu_Pedidos` FROM `usuario` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`identificador`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Pe_Cliente` (`Pe_Cliente`),
  ADD KEY `fk_id_producto` (`id_producto`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Cgo_Codigo`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`Identificador`),
  ADD KEY `Pe_Cliente` (`Pe_Cliente`),
  ADD KEY `Pe_Estado` (`Pe_Estado`);

--
-- Indices de la tabla `pedido_estado`
--
ALTER TABLE `pedido_estado`
  ADD PRIMARY KEY (`Es_Codigo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`Identificador`),
  ADD UNIQUE KEY `Pro_Codigo` (`Identificador`),
  ADD KEY `Pro_Categoria` (`Pro_Categoria`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Tipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Usu_Identificacion`),
  ADD KEY `UsuRol` (`Usu_Rol`),
  ADD KEY `Usu_Pedidos` (`Usu_Pedidos`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calendario`
--
ALTER TABLE `calendario`
  MODIFY `identificador` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `Identificador` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `Identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD CONSTRAINT `calendario_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`Usu_Identificacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`Pe_Cliente`) REFERENCES `pedidos` (`Pe_Cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`Identificador`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`Pe_Cliente`) REFERENCES `usuario` (`Usu_Identificacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_3` FOREIGN KEY (`Pe_Estado`) REFERENCES `pedido_estado` (`Es_Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`Pro_Categoria`) REFERENCES `categoria` (`Cgo_Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`Usu_Rol`) REFERENCES `rol` (`Tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`Usu_Pedidos`) REFERENCES `pedidos` (`Identificador`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
