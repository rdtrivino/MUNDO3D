-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2024 a las 18:04:35
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
  `usuario` int(10) NOT NULL,
  `observaciones` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calendario`
--

INSERT INTO `calendario` (`identificador`, `evento`, `color_evento`, `fecha_inicio`, `fecha_fin`, `usuario`, `observaciones`) VALUES
(1, 'Maximo', '#FFC107', '2024-06-05', '2024-06-06', 1026577616, 'maximo');

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
(84, 1014307293, 1, 'pendiente', 12);

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
(3, 'BOQUILLA O NOZZLE DE 0.2/0.3/0.4/0.6/0.8/1.0/1.2 M', 'Material: Latón\r\nPrecisión de la boquilla: 0.4mm\r\nDiámetro de entrada: 1.75mm\r\nDiámetro de la rosca externa: 6 mm\r\nDiámetro del hexágono: 6 mm', 2, 100, 12000, NULL, 'activo', '../images/imagenes_catalogo/catalogo-3.webp', ''),
(4, 'RUEDA / RODAMIENTO TIPO V-SLOT DE ACERO CARBONO PA', 'Componente de repuesto para impresora 3D. Unos rodamientos en mal estado repercutirá en una mala calidad de impresión 3D.\r\n\r\nRodamientos de goma silenciosos compatibles con ARTILLERY GENIUS / Genius Pro y SIDEWINDER X1 / X2\r\n\r\nMaterial: Acero al carbono y', 2, 50, 13000, 6500, 'activo', '../images/imagenes_catalogo/catalogo-4.webp', ''),
(5, 'Crealily  Ender 3 Pro', 'Crealily  Ender 3 Pro, se le va a realizar limpieza y cambio del rodamiento ', 3, 1, 200000, 0, 'activo', '../images/imagenes_catalogo/catalogo-5.png', ''),
(6, 'Tairona XL  Doble Ext.', 'Tairona XL Doble Ext, se va a realizar el cambio de PIÑÓN DENTADO EXTRUSOR TITAN ARTILLERY GENIUS/X1 y cargar el filamento ', 3, 5, 230000, 0, 'activo', '../images/imagenes_catalogo/catalogo-6.png', ''),
(7, 'impresión de un dragón ', 'impresión de un dragón en el color rojo con ojos negros ', 4, 8, 500000, 0, 'activo', '../images/imagenes_catalogo/catalogo-7.jpg', ''),
(8, 'figura de acción de luffy de one piece', 'impresión 3d de una figura de acción de luffy de one piece con los colores (negro, rojo, piel, café, azul y rojo) ', 4, 2, 850000, 400000, 'activo', '../images/imagenes_catalogo/catalogo-8.jpg', ''),
(9, 'Fiat-Abarth 750 GT Zagota', 'Modelo para impresora en modelo FDM\r\nPARÁMETROS DE IMPRESIÓN 3D\r\nAltura de capa 0.2\r\nTemperatura hotend 205\r\nCama 50\r\nRelleno 10% giroide\r\nTiempo de impresión carrocería 17 horas aprox.\r\nResto de piezas 10 horas\r\nMedidas:\r\nAncho 62 mm\r\nLargo 146 mm\r\nAlto ', 5, 6, 500000, 250000, 'activo', '../images/imagenes_catalogo/catalogo-9.jpg', ''),
(10, 'imagen de calavera', 'imagen en 3d de calavera ', 5, 3, 0, NULL, 'activo', '../images/imagenes_catalogo/catalogo-10.jpg', ''),
(11, 'IMPRESORA 3D CREALITY ENDER 5 PLUS', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 350x350x400 mm.\r\nMateriales: ABS, PLA, TPU y PETG.\r\n\r\nCaracterísticas diferenciales de la impresora 3D Creality:\r\n\r\nCama fija en Z extra grande de 350 x 350 mm.\r\nDoble torn', 1, 20, 4000000, 2000000, 'activo', '../images/imagenes_catalogo/catalogo-11.webp', ''),
(12, 'IMPRESORA 3D ARTILLERY SIDEWINDER X3 PRO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 240 x 240 x 260 mm\r\nMateriales de impresión: PLA, ABS, TPU, PETG\r\n\r\nCaracterísticas diferenciales de la impresora 3D Artillery:\r\n\r\nPlataforma de impresión magnética PEI.\r\nN', 1, 15, 2000000, 1000000, 'activo', '../images/imagenes_catalogo/catalogo-12.webp', ''),
(13, 'IMPRESORA 3D ARTILLERY GENIUS PRO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 220 x 220 x 250 mm.\r\nMateriales de impresión: PLA, ABS, PETG, TPU, WOOD.\r\n\r\nCaracterísticas diferenciales de la impresora 3D Artillery:\r\n\r\nSensor de auto nivelación ABL, qu', 1, 10, 1600000, 800000, 'activo', '../images/imagenes_catalogo/catalogo-13.webp', ''),
(14, 'IMPRESORA 3D ARTILLERY SIDEWINDER X4 PRO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 240 x 240 x 260 mm\r\nMateriales de impresión: PLA, ABS, PETG, TPU, NYLON\r\n\r\nCaracterísticas diferenciales de la impresora 3D Artillery:\r\n\r\nRieles lineales de metal.\r\nPantall', 1, 5, 3000000, 1500000, 'activo', '../images/imagenes_catalogo/catalogo-14.webp', ''),
(15, 'IMPRESORA 3D RESINA CREALITY HALOT ONE PRO', 'Tecnología de impresión: LCD UV\r\nÁrea de impresión: 130x122x160 mm\r\nResinas de impresión: RESINA 405nm (Standard, Casteable, Hard, Flexible)\r\n\r\nCaracterísticas diferenciales de la impresora 3D resina Creality HALOT ONE PRO:\r\n\r\nEje Z con rieles lineales du', 1, 25, 2000000, 1000000, 'activo', '../images/imagenes_catalogo/catalogo-15.webp', ''),
(16, 'IMPRESORA 3D CREALITY SERMOON V1', 'DESCRIPCIÓN:\r\nTecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 175x175x165mm\r\nMateriales de impresión: PLA, ABS, PETG, TPU, WOOD\r\n\r\nCaracterísticas diferenciales de la impresora 3D Creality:\r\n\r\nOperación silenciosa sin im', 1, 10, 4000000, 2000000, 'activo', '../images/imagenes_catalogo/catalogo-16.webp', ''),
(17, 'IMPRESORA 3D CREALITY CR 30 EJE Z INFINITO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 200*170*∞mm\r\nMateriales de impresión: ABS, PLA, PETG, PET, TPU, PA, ASA, WOOD\r\n\r\nCaracterísticas diferenciales de la impresora 3D Creality:\r\n\r\nLa impresión por lotes de gra', 1, 30, 7000000, 3500000, 'activo', '../images/imagenes_catalogo/catalogo-17.webp', ''),
(18, 'IMPRESORA 3D RESINA ANYCUBIC PHOTON MONO M5S PRO', 'Tecnología de impresión: LCD UV\r\nÁrea de impresión: 200 x 223.78 x 126.38 mm\r\nMateriales de impresión: RESINA 405 nm (alta velocidad, lavable con agua, estándar, tipo ABS, de origen vegetal, etc.)\r\n\r\nCaracterísticas diferenciales de la impresora 3D Anycub', 1, 10, 5000000, 2500000, 'activo', '../images/imagenes_catalogo/catalogo-18.webp', ''),
(19, 'IMPRESORA 3D FLASHFORGE ADVENTURER 5M PRO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 220 x 220 x 220 mm.\r\nMateriales de impresión: *PLA/*PETG/*TPU（Boquilla 0.4mm ） PLA-CF/PETG-CF（ Boquilla 0.6/0.8mm\r\n\r\nCaracterísticas diferenciales de la impresora 3D Flashf', 1, 7, 5000000, 2500000, 'activo', '../images/imagenes_catalogo/catalogo-19.webp', ''),
(20, 'IMPRESORA 3D ANYCUBIC PHOTON MONO 2', 'Tecnología de impresión: LCD UV\r\nÁrea de impresión: 165x89x143mm(HWD)\r\nMateriales de impresión: RESINA 405nm (Standard, Casteable, Hard, Flexible)\r\n\r\nCaracterísticas diferenciales de la impresora 3D Anycubic:\r\n\r\nPantalla LCD 4K de 6,6 pulgadas\r\nProtector ', 1, 2, 1600000, 800000, 'activo', '../images/imagenes_catalogo/catalogo-20.webp', ''),
(21, 'IMPRESORA 3D FLASHFORGE ADVENTURER 5M', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 220 x 220 x 220 mm.\r\nMateriales de impresión: *PLA/*PETG/*TPU（Boquilla 0.4mm ） PLA-CF/PETG-CF（ Boquilla 0.6/0.8mm\r\n\r\nCaracterísticas diferenciales de la impresora 3D Flashf', 1, 9, 3600000, 1800000, 'activo', '../images/imagenes_catalogo/catalogo-21.webp', ''),
(22, 'IMPRESORA 3D BAMBU LAB X1 - CARBON COMBO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 256 x 256 x 256 mm\r\nMateriales de impresión: PLA/ABS/PETG/ PETG PRO/TPU 95A\r\n\r\nCaracterísticas diferenciales de la impresora 3D Bambú Lab:\r\n\r\nCapacidad de varios colores y ', 1, 2, 18000000, 9000000, 'activo', '../images/imagenes_catalogo/catalogo-22.webp', ''),
(23, 'TAPA DE PLÁSTICO DE ENFRIAMIENTO EXTRUSOR TITAN', 'Tapa de enfriamiento para extrusor titán con barrel liso. El barrel se fija con 2 tornillos prisioneros.', 2, 150, 24000, 12000, 'activo', '../images/imagenes_catalogo/catalogo-23.webp', ''),
(24, 'BLOQUE CALEFACTOR ALUMINIO ARTILLERY X1/GENIUS', 'Bloque calefactor térmico tipo Volcano original de Artillery. Se recomienda ser usado junto con el protector térmico el cual ayuda a mantener de forma más estable el calor dentro del bloque calentador del fusor de la impresora 3D.', 2, 15, 30000, 15000, 'activo', '../images/imagenes_catalogo/catalogo-24.webp', ''),
(25, 'ENGRANAJE EXTRUSORTINTAN ARTILLERY X1 Y GENIUS', 'Repuesto Original de los engranajes centrales del extrusor de la impresora 3D ARTILLERY X1 y ARTILLERY GENIUS.\r\n\r\nLos engranajes centrales del extrusor titán Aero usado en la Artillery SideWinder X1 y Artillery Genius es una pieza fundamental en el sistem', 2, 10, 30000, 15000, 'activo', '../images/imagenes_catalogo/catalogo-.webp', ''),
(26, 'DISCIPADORES CREALITY', 'Características:  Este radiador de disipador de calor es compatible con impresoras 3D Serie CR-10 y Serie Ender-3.CR-10 incluyen CR-10 CR-10Mini CR-10S CR-10S4 y CR-10S5. Ender-3/CR-10 Series (CR-10/CR-10mini/CR-10S/CR-10S4/CR-10S5) Material de aluminio s', 2, 5, 24000, 12000, 'inactivo', '../images/imagenes_catalogo/catalogo-26.webp', ''),
(27, 'VENTILADOR REFRIGERADOR DEL FUSOR CREALITY ENDER S', 'Componente de repuesto para tu impresora 3D. Una mala ventilación del sistema del fusor en tu impresora 3D repercutirá en la vida útil de tu impresora y podrá ocasionar atascos.  Compatible con Creality Ender 3, Creality Ender 3 Pro, Creality Ender 3 V2. ', 2, 30, 30000, 15000, 'inactivo', '../images/imagenes_catalogo/catalogo-27.webp', ''),
(28, 'FINAL DE CARRERA SERIE ENDER', 'Interruptor de límite de 3 pines N / ON / C de control fácil de usar. Interruptor de límite de eje X/Y/Z. Compatible con CR-10 Series, Ender-3 u otras impresoras 3D. Pequeño y compacto, fácil de instalar, plug and play. Tensión máxima: 125 V, corriente má', 2, 15, 24000, 12000, 'inactivo', '../images/imagenes_catalogo/catalogo-28.webp', ''),
(29, 'BARREL LISO ARTILLERY', 'Barrel Liso que se ajusta al extrusor mediante un tornillo prisionero. Requiere el uso de un tubo de teflón en su interior.', 2, 5, 30000, 15000, 'inactivo', '../images/imagenes_catalogo/catalogo-29.webp', ''),
(30, 'TUBO DE TEFLON 1 METRO', 'Accesorio de tubo de teflón kit_L1000_D6×d4_PTEE_Blanco  Distancia: 1 m  Teflón PTFE Genérico', 2, 40, 24000, 12000, 'inactivo', '../images/imagenes_catalogo/catalogo-30.webp', ''),
(31, 'CORREA DISTRIBUCIÓN 1GT LM1000MM', 'Utilizado como elemento de transmisión de los ejes X e Y en las impresoras 3D Creality . El producto está hecho de material de alta calidad con alta durabilidad y larga vida. Proporciona un movimiento silencioso y preciso. La tolerancia del espesor de la ', 2, 20, 30000, 15000, 'inactivo', '../images/imagenes_catalogo/catalogo-31.webp', ''),
(32, 'AGUJAS DE LIMPIEZAS 0.2/0.35/0.4/0.6/0.8/1 MM', 'Agujas para limpieza de boquilla. Diferentes diámetros. ', 2, 15, 4000, 2000, 'inactivo', '../images/imagenes_catalogo/catalogo-32.webp', ''),
(33, 'RESISTENCIAS CREALITY ENDER', '• Cartucho calefactor resistencia original• Marca Creality • Compatibilidad: Ender 3, Ender 3 Pro, Ender 3 v2, etc. • 24 V   • 40 W', 2, 200, 26000, 13000, 'inactivo', '../images/imagenes_catalogo/catalogo-33.webp', '');

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
  `Usu_Estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Usu_Identificacion`, `Usu_Nombre_completo`, `Usu_Telefono`, `Usu_Email`, `Usu_Ciudad`, `Usu_Direccion`, `Usu_Contraseña`, `Usu_Rol`, `Usu_Estado`) VALUES
(1000000, 'Cliente prueba', '3210000000', 'prueba@gmail.com', 'Medellin', 'cl 1 23 65', '$2y$10$1FD6PUYuKx1t8S4LO9Frg.Gf9eAr0vpeWsmOYdZfPVLukXnSnc6aK', 3, 'activo'),
(1000698993, 'Juan David Penagos', '3108199377', 'jjuandavid2003@gmail.com', 'Bogotá', 'Calle 19 El Bronx', '$2y$10$4YSTOtpwRnNK9lRF83yC7eQNbp4XuykCGhOGzhE4K3B.fixR3309i', 3, 'activo'),
(1014307293, 'Sebastian Lammy', '3194599719', 'sebastiancamilo@gmail.com', 'Bogota D.C.', 'CR 101 23 05 ', '$2y$10$ofavOWpSlCymMmhvQPuDpePeLq7h97SUiVLSmOMG1ttGucY4esdTO', 3, 'activo'),
(1026577616, 'Yordy Suárez Bonilla', '3214996400', 'ysuarez61@misena.edu.co', 'Bogotá', 'Calle Falsa # 123-4', '$2y$10$DjDdnVOHHBR6rnG2yc73Iut2xUU8c0n5O53n0DdAVbvayZ1smsdU.', 2, 'activo'),
(1026577618, 'Yordy Suarez', 'Usuario', 'yordy_9328@hotmail.com', 'Bogota D.C.', 'CL 72 SUR 22 26', '$2y$10$WNVnjb/exohqd3hKbyqfQuKk5HcCd5IgBBZOE9bFBOD5OX9IdXvwu', 1, 'activo'),
(1131110766, 'Ruben Dario Triviño', '3113287379', 'darioruben876@gmail.com', 'Bogotá', 'suba-bogota', '$2y$10$PGM06.gFmaiE7JxFpl9Fz.4TkyqEwW4IkOHsRg/pbjvyNVKzBt5Sm', 3, 'activo'),
(2147483647, 'Ronal', '3210000000', 'rudatrivi@hotmail.com', 'Bogotá', 'Calle 19', '$2y$10$lqk4gNcPvTNZZTKddPOl6OuNQQc8bPxJEF.FmhUNGHPZX0HJHbCr6', 2, 'activo');

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
  ADD KEY `fk_id_producto` (`id_producto`),
  ADD KEY `Pe_Cliente` (`Pe_Cliente`);

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
  ADD KEY `UsuRol` (`Usu_Rol`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

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
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`Pe_Cliente`) REFERENCES `usuario` (`Usu_Identificacion`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`Usu_Rol`) REFERENCES `rol` (`Tipo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
