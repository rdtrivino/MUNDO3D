-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2024 a las 02:17:17
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

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
-- Estructura de tabla para la tabla `auditoria_pedidos`
--

CREATE TABLE `auditoria_pedidos` (
  `identificador` int(4) NOT NULL,
  `usuario` int(20) NOT NULL,
  `fecha` date NOT NULL,
  `pedido` int(4) NOT NULL,
  `acciones` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoria_pedidos`
--

INSERT INTO `auditoria_pedidos` (`identificador`, `usuario`, `fecha`, `pedido`, `acciones`) VALUES
(1, 0, '2024-09-06', 437, 'Se realiza actualización del pedido relacionado'),
(2, 0, '2024-09-06', 416, 'Se realiza eliminación del pedido relacionado'),
(3, 0, '2024-09-06', 417, 'Se realiza eliminación del pedido relacionado'),
(4, 0, '2024-09-06', 418, 'Se realiza eliminación del pedido relacionado'),
(5, 0, '2024-09-06', 422, 'Se realiza eliminación del pedido relacionado'),
(6, 0, '2024-09-06', 423, 'Se realiza eliminación del pedido relacionado'),
(7, 0, '2024-09-06', 424, 'Se realiza eliminación del pedido relacionado'),
(8, 0, '2024-09-06', 425, 'Se realiza eliminación del pedido relacionado'),
(9, 0, '2024-09-06', 426, 'Se realiza eliminación del pedido relacionado'),
(10, 0, '2024-09-06', 427, 'Se realiza eliminación del pedido relacionado'),
(11, 0, '2024-09-06', 428, 'Se realiza eliminación del pedido relacionado'),
(12, 0, '2024-09-06', 429, 'Se realiza eliminación del pedido relacionado'),
(13, 0, '2024-09-06', 430, 'Se realiza eliminación del pedido relacionado'),
(14, 0, '2024-09-06', 431, 'Se realiza eliminación del pedido relacionado'),
(15, 0, '2024-09-06', 432, 'Se realiza eliminación del pedido relacionado'),
(16, 0, '2024-09-06', 433, 'Se realiza eliminación del pedido relacionado'),
(17, 0, '2024-09-06', 434, 'Se realiza eliminación del pedido relacionado'),
(18, 0, '2024-09-06', 435, 'Se realiza eliminación del pedido relacionado'),
(19, 0, '2024-09-06', 436, 'Se realiza eliminación del pedido relacionado'),
(20, 0, '2024-09-06', 437, 'Se realiza eliminación del pedido relacionado');

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
  `observaciones` varchar(50) NOT NULL,
  `hora_inicio` time(6) NOT NULL,
  `hora_fin` time(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calendario`
--

INSERT INTO `calendario` (`identificador`, `evento`, `color_evento`, `fecha_inicio`, `fecha_fin`, `usuario`, `observaciones`, `hora_inicio`, `hora_fin`) VALUES
(3, 'Terminar El Proyecto', '#2196F3', '2024-10-03', '0000-00-00', 1000000, 'Ajuste de errores y condicionales', '12:00:00.000000', '13:00:00.000000');

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
(281, 2222222, 1, 'pendiente', 14),
(282, 1131110766, 2, 'pendiente', 1);

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
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id` int(11) NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `numero_documento` varchar(20) NOT NULL,
  `producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `nombre_imagen` varchar(50) NOT NULL,
  `Compra_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `pedidos`
--
DELIMITER $$
CREATE TRIGGER `Actividad_Tabla_Pedidosdelete` AFTER DELETE ON `pedidos` FOR EACH ROW BEGIN
    INSERT INTO auditoria_pedidos(usuario, fecha, pedido, acciones)
    VALUES (CURRENT_USER(), NOW(), OLD.Identificador, "Se realiza eliminación del pedido relacionado");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Actividad_Tabla_Pedidosinsert` AFTER INSERT ON `pedidos` FOR EACH ROW BEGIN
    INSERT INTO auditoria_pedidos(usuario, fecha, pedido, acciones)
    VALUES (CURRENT_USER(), NOW(), NEW.Identificador, "Se realiza inserción del nuevo pedido relacionado");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Actividad_Tabla_Pedidosupdate` AFTER UPDATE ON `pedidos` FOR EACH ROW BEGIN
    INSERT INTO auditoria_pedidos(usuario, fecha, pedido, acciones)
    VALUES (CURRENT_USER(), NOW(), NEW.Identificador, "Se realiza actualización del pedido relacionado");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Actualizacion_Productos_Cantdelete` AFTER DELETE ON `pedidos` FOR EACH ROW BEGIN
    UPDATE productos
    SET Pro_Cantidad = Pro_Cantidad + OLD.Pe_Cantidad
    WHERE Identificador = OLD.Pe_Producto;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Actualizacion_Productos_Cantinsert` AFTER INSERT ON `pedidos` FOR EACH ROW BEGIN
    UPDATE productos
    SET Pro_Cantidad = Pro_Cantidad - NEW.Pe_Cantidad
    WHERE Identificador = NEW.Pe_Producto;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Actualizacion_Productos_Cantupdate` AFTER UPDATE ON `pedidos` FOR EACH ROW BEGIN
    UPDATE productos
    SET Pro_Cantidad = Pro_Cantidad - NEW.Pe_Cantidad
    WHERE Identificador = NEW.Pe_Producto;
END
$$
DELIMITER ;

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
  `descripcion_imagen` varchar(100) NOT NULL,
  `Pro_Pvdolar` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Identificador`, `Pro_Nombre`, `Pro_Descripcion`, `Pro_Categoria`, `Pro_Cantidad`, `Pro_PrecioVenta`, `Pro_Costo`, `Pro_Estado`, `nombre_imagen`, `descripcion_imagen`, `Pro_Pvdolar`) VALUES
(1, 'IMPRESORA 3D BAMBU LAB X1 - CARBON COMBO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 256 x 256 x 256 mm\r\nMateriales de impresión: PLA/ABS/PETG/ PETG PRO/TPU 95A\r\n\r\nCaracterísticas diferenciales de la impresora 3D Bambú Lab:\r\n\r\nCapacidad de varios colores y ', 1, 4, 18000000, 9000000, 'activo', '../images/imagenes_catalogo/catalogo-22.webp', '', 4313.96),
(2, 'IMPRESORA 3D FLASHFORGE ADVENTURER 5M', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 220 x 220 x 220 mm.\r\nMateriales de impresión: *PLA/*PETG/*TPU（Boquilla 0.4mm ） PLA-CF/PETG-CF（ Boquilla 0.6/0.8mm\r\n\r\nCaracterísticas diferenciales de la impresora 3D Flashf', 1, 9, 3600000, 1800000, 'activo', '../images/imagenes_catalogo/catalogo-21.webp', '', 862.79),
(3, 'BOQUILLA O NOZZLE DE 0.2/0.3/0.4/0.6/0.8/1.0/1.2 M', 'Material: Latón\r\nPrecisión de la boquilla: 0.4mm\r\nDiámetro de entrada: 1.75mm\r\nDiámetro de la rosca externa: 6 mm\r\nDiámetro del hexágono: 6 mm', 2, 0, 12000, NULL, 'activo', '../images/imagenes_catalogo/catalogo-3.webp', '', 2.88),
(4, 'RUEDA / RODAMIENTO TIPO V-SLOT DE ACERO CARBONO PA', 'Componente de repuesto para impresora 3D. Unos rodamientos en mal estado repercutirá en una mala calidad de impresión 3D.\r\n\r\nRodamientos de goma silenciosos compatibles con ARTILLERY GENIUS / Genius Pro y SIDEWINDER X1 / X2\r\n\r\nMaterial: Acero al carbono y', 2, 50, 13000, 6500, 'activo', '../images/imagenes_catalogo/catalogo-4.webp', '', 3.12),
(5, 'Crealily  Ender 3 Pro', 'Crealily  Ender 3 Pro, se le va a realizar limpieza y cambio del rodamiento ', 3, 0, 200000, 0, 'activo', '../images/imagenes_catalogo/catalogo-5.png', '', 47.93),
(6, 'Tairona XL  Doble Ext.', 'Tairona XL Doble Ext, se va a realizar el cambio de PIÑÓN DENTADO EXTRUSOR TITAN ARTILLERY GENIUS/X1 y cargar el filamento ', 3, 5, 230000, 0, 'activo', '../images/imagenes_catalogo/catalogo-6.png', '', 55.12),
(7, 'impresión de un dragón ', 'impresión de un dragón en el color rojo con ojos negros ', 4, 8, 500000, 0, 'activo', '../images/imagenes_catalogo/catalogo-7.jpg', '', 119.83),
(8, 'figura de acción de luffy de one piece', 'impresión 3d de una figura de acción de luffy de one piece con los colores (negro, rojo, piel, café, azul y rojo) ', 4, 2, 850000, 400000, 'activo', '../images/imagenes_catalogo/catalogo-8.jpg', '', 203.71),
(10, 'imagen de calavera', 'imagen en 3d de calavera ', 5, 3, 0, 0, 'activo', '../images/imagenes_catalogo/catalogo-10.png', '', 0.00),
(11, 'IMPRESORA 3D CREALITY ENDER 5 PLUS', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 350x350x400 mm.\r\nMateriales: ABS, PLA, TPU y PETG.\r\n\r\nCaracterísticas diferenciales de la impresora 3D Creality:\r\n\r\nCama fija en Z extra grande de 350 x 350 mm.\r\nDoble torn', 1, 36, 40, 2000000, 'activo', '../images/imagenes_catalogo/catalogo-11.webp', '', 0.01),
(12, 'IMPRESORA 3D ARTILLERY SIDEWINDER X3 PRO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 240 x 240 x 260 mm\r\nMateriales de impresión: PLA, ABS, TPU, PETG\r\n\r\nCaracterísticas diferenciales de la impresora 3D Artillery:\r\n\r\nPlataforma de impresión magnética PEI.\r\nN', 1, 31, 20, 1000000, 'activo', '../images/imagenes_catalogo/catalogo-12.webp', '', 0.00),
(13, 'IMPRESORA 3D ARTILLERY GENIUS PRO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 220 x 220 x 250 mm.\r\nMateriales de impresión: PLA, ABS, PETG, TPU, WOOD.\r\n\r\nCaracterísticas diferenciales de la impresora 3D Artillery:\r\n\r\nSensor de auto nivelación ABL, qu', 1, 0, 16, 800000, 'activo', '../images/imagenes_catalogo/catalogo-13.webp', '', 0.00),
(14, 'IMPRESORA 3D ARTILLERY SIDEWINDER X4 PRO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 240 x 240 x 260 mm\r\nMateriales de impresión: PLA, ABS, PETG, TPU, NYLON\r\n\r\nCaracterísticas diferenciales de la impresora 3D Artillery:\r\n\r\nRieles lineales de metal.\r\nPantall', 1, 21, 30, 1500000, 'activo', '../images/imagenes_catalogo/catalogo-14.webp', '', 0.01),
(15, 'IMPRESORA 3D RESINA CREALITY HALOT ONE PRO', 'Tecnología de impresión: LCD UV\r\nÁrea de impresión: 130x122x160 mm\r\nResinas de impresión: RESINA 405nm (Standard, Casteable, Hard, Flexible)\r\n\r\nCaracterísticas diferenciales de la impresora 3D resina Creality HALOT ONE PRO:\r\n\r\nEje Z con rieles lineales du', 1, 25, 2000000, 1000000, 'activo', '../images/imagenes_catalogo/catalogo-15.webp', '', 479.33),
(16, 'IMPRESORA 3D CREALITY SERMOON V1', 'DESCRIPCIÓN:\r\nTecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 175x175x165mm\r\nMateriales de impresión: PLA, ABS, PETG, TPU, WOOD\r\n\r\nCaracterísticas diferenciales de la impresora 3D Creality:\r\n\r\nOperación silenciosa sin im', 1, 10, 4000000, 2000000, 'activo', '../images/imagenes_catalogo/catalogo-16.webp', '', 958.66),
(17, 'IMPRESORA 3D CREALITY CR 30 EJE Z INFINITO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 200*170*∞mm\r\nMateriales de impresión: ABS, PLA, PETG, PET, TPU, PA, ASA, WOOD\r\n\r\nCaracterísticas diferenciales de la impresora 3D Creality:\r\n\r\nLa impresión por lotes de gra', 1, 30, 7000000, 3500000, 'activo', '../images/imagenes_catalogo/catalogo-17.webp', '', 1677.65),
(18, 'IMPRESORA 3D RESINA ANYCUBIC PHOTON MONO M5S PRO', 'Tecnología de impresión: LCD UV\r\nÁrea de impresión: 200 x 223.78 x 126.38 mm\r\nMateriales de impresión: RESINA 405 nm (alta velocidad, lavable con agua, estándar, tipo ABS, de origen vegetal, etc.)\r\n\r\nCaracterísticas diferenciales de la impresora 3D Anycub', 1, 10, 5000000, 2500000, 'activo', '../images/imagenes_catalogo/catalogo-18.webp', '', 1198.32),
(19, 'IMPRESORA 3D FLASHFORGE ADVENTURER 5M PRO', 'Tecnología de impresión: FDM (Modelado por deposición fundida)\r\nÁrea de impresión: 220 x 220 x 220 mm.\r\nMateriales de impresión: *PLA/*PETG/*TPU（Boquilla 0.4mm ） PLA-CF/PETG-CF（ Boquilla 0.6/0.8mm\r\n\r\nCaracterísticas diferenciales de la impresora 3D Flashf', 1, 7, 5000000, 2500000, 'activo', '../images/imagenes_catalogo/catalogo-19.webp', '', 1198.32),
(20, 'IMPRESORA 3D ANYCUBIC PHOTON MONO 2', 'Tecnología de impresión: LCD UV\r\nÁrea de impresión: 165x89x143mm(HWD)\r\nMateriales de impresión: RESINA 405nm (Standard, Casteable, Hard, Flexible)\r\n\r\nCaracterísticas diferenciales de la impresora 3D Anycubic:\r\n\r\nPantalla LCD 4K de 6,6 pulgadas\r\nProtector ', 1, 2, 1600000, 800000, 'activo', '../images/imagenes_catalogo/catalogo-20.webp', '', 383.46),
(21, 'KITS EXTRUSOR COMPLETAMENTE MONTADO CREALITY CR-10', 'Kit completo de extrusor CR-10 V2 con bloque de calefacción de aluminio de 0.016 in.\r\n\r\nEn caso de que el extrusor de la impresora 3D este dañado o la fuga de consumibles no se puede reparar, por favor, no reemplaces la nueva máquina, puedes mantenerlo.\r\n', 2, 10, 400000, 200000, 'activo', '../images/imagenes_catalogo/catalogo-37.webp', '', 95.87),
(23, 'TAPA DE PLÁSTICO DE ENFRIAMIENTO EXTRUSOR TITAN', 'Tapa de enfriamiento para extrusor titán con barrel liso. El barrel se fija con 2 tornillos prisioneros.', 2, 150, 24000, 12000, 'activo', '../images/imagenes_catalogo/catalogo-23.webp', '', 5.75),
(24, 'BLOQUE CALEFACTOR ALUMINIO ARTILLERY X1/GENIUS', 'Bloque calefactor térmico tipo Volcano original de Artillery. Se recomienda ser usado junto con el protector térmico el cual ayuda a mantener de forma más estable el calor dentro del bloque calentador del fusor de la impresora 3D.', 2, 15, 30000, 15000, 'activo', '../images/imagenes_catalogo/catalogo-24.webp', '', 7.19),
(25, 'ENGRANAJE EXTRUSORTINTAN ARTILLERY X1 Y GENIUS', 'Repuesto Original de los engranajes centrales del extrusor de la impresora 3D ARTILLERY X1 y ARTILLERY GENIUS.\r\n\r\nLos engranajes centrales del extrusor titán Aero usado en la Artillery SideWinder X1 y Artillery Genius es una pieza fundamental en el sistem', 2, 10, 30000, 15000, 'activo', '../images/imagenes_catalogo/catalogo-25.webp', '', 7.19),
(26, 'DISCIPADORES CREALITY', 'Características:  Este radiador de disipador de calor es compatible con impresoras 3D Serie CR-10 y Serie Ender-3.CR-10 incluyen CR-10 CR-10Mini CR-10S CR-10S4 y CR-10S5. Ender-3/CR-10 Series (CR-10/CR-10mini/CR-10S/CR-10S4/CR-10S5) Material de aluminio s', 2, 5, 24000, 12000, 'activo', '../images/imagenes_catalogo/catalogo-26.webp', '', 5.75),
(27, 'VENTILADOR REFRIGERADOR DEL FUSOR CREALITY ENDER S', 'Componente de repuesto para tu impresora 3D. Una mala ventilación del sistema del fusor en tu impresora 3D repercutirá en la vida útil de tu impresora y podrá ocasionar atascos.  Compatible con Creality Ender 3, Creality Ender 3 Pro, Creality Ender 3 V2. ', 2, 30, 30000, 15000, 'activo', '../images/imagenes_catalogo/catalogo-27.webp', '', 7.19),
(28, 'FINAL DE CARRERA SERIE ENDER', 'Interruptor de límite de 3 pines N / ON / C de control fácil de usar. Interruptor de límite de eje X/Y/Z. Compatible con CR-10 Series, Ender-3 u otras impresoras 3D. Pequeño y compacto, fácil de instalar, plug and play. Tensión máxima: 125 V, corriente má', 2, 15, 24000, 12000, 'inactivo', '../images/imagenes_catalogo/catalogo-28.webp', '', 5.75),
(29, 'BARREL LISO ARTILLERY', 'Barrel Liso que se ajusta al extrusor mediante un tornillo prisionero. Requiere el uso de un tubo de teflón en su interior.', 2, 5, 30000, 15000, 'inactivo', '../images/imagenes_catalogo/catalogo-29.webp', '', 7.19),
(30, 'TUBO DE TEFLON 1 METRO', 'Accesorio de tubo de teflón kit_L1000_D6×d4_PTEE_Blanco  Distancia: 1 m  Teflón PTFE Genérico', 2, 40, 24000, 12000, 'inactivo', '../images/imagenes_catalogo/catalogo-30.webp', '', 5.75),
(31, 'CORREA DISTRIBUCIÓN 1GT LM1000MM', 'Utilizado como elemento de transmisión de los ejes X e Y en las impresoras 3D Creality . El producto está hecho de material de alta calidad con alta durabilidad y larga vida. Proporciona un movimiento silencioso y preciso. La tolerancia del espesor de la ', 2, 20, 30000, 15000, 'inactivo', '../images/imagenes_catalogo/catalogo-31.webp', '', 7.19),
(32, 'AGUJAS DE LIMPIEZAS 0.2/0.35/0.4/0.6/0.8/1 MM', 'Agujas para limpieza de boquilla. Diferentes diámetros. ', 2, 15, 4000, 2000, 'inactivo', '../images/imagenes_catalogo/catalogo-32.webp', '', 0.96),
(33, 'RESISTENCIAS CREALITY ENDER', '• Cartucho calefactor resistencia original• Marca Creality • Compatibilidad: Ender 3, Ender 3 Pro, Ender 3 v2, etc. • 24 V   • 40 W', 2, 200, 26000, 13000, 'inactivo', '../images/imagenes_catalogo/catalogo-33.webp', '', 6.23),
(34, 'SENSOR AUTONIVELACION CR6 / CR6 MAX', 'Con alta precisión, rendimiento estable, trabajo, mejora la tasa de éxito de impresión y precisión de impresión. Con una excelente tecnología de producción, tiene la calidad de alta dureza y función de resistencia al desgaste. Pequeño en tamaño y peso lig', 2, 20, 114000, 57000, 'inactivo', '../images/imagenes_catalogo/catalogo-34.webp', '', 27.32),
(35, 'CORREA GT2 X/Y', 'Un juego de correas X/Y cortas de repuesto.  Modelos compatibles  Zortrax M200 Zortrax M200 Plus Zortrax M300 Plus Zortrax M300 Zortrax M300 Doble', 2, 10, 160000, 80000, 'inactivo', '../images/imagenes_catalogo/catalogo-35.webp', '', 38.35),
(36, 'EXTRUSOR METALICO DOBLE PIÑON CREALITY', 'Hecho en aleación de aluminio Color rojo y gris Adecuado para CR-10, para CR-10S, para Ender-3, para Ender-3 PRO.  1. Mecanismo de extrusión de doble engranaje, alta fuerza de extrusión, asegurando una alimentación suave 2. El controlador original de alea', 2, 19, 200000, 100000, 'inactivo', '../images/imagenes_catalogo/catalogo-36.webp', '', 47.93),
(38, 'Sandia', 'representación digital tridimensional de esta fruta popular y refrescante. Este modelo 3D captura los detalles realistas de una sandía', 5, 2, 0, 0, 'activo', '../images/imagenes_catalogo/catalogo-38.png', '', 0.00),
(39, 'JIRAFA', 'es una representación digital tridimensional de este majestuoso animal. Este modelo 3D captura los detalles distintivos de una jirafa', 5, 2, 0, 0, 'activo', '../images/imagenes_catalogo/catalogo-39.png', '', 0.00),
(40, 'ROBOT', 'es una representación digital tridimensional de una máquina programable capaz de realizar diversas tareas de manera automática o semiautomática.', 5, 2, 0, 0, 'activo', '../images/imagenes_catalogo/catalogo-40.png', '', 0.00),
(41, 'DRAGON', 'es una representación digital tridimensional de una criatura mítica que ha capturado la imaginación de culturas en todo el mundo', 5, 2, 0, 0, 'activo', '../images/imagenes_catalogo/catalogo-41.png', '', 0.00),
(42, 'ELF', ' es una representación digital tridimensional de una criatura mitológica que se encuentra en numerosas tradiciones folclóricas y literarias', 5, 2, 0, 0, 'activo', '../images/imagenes_catalogo/catalogo-42.png', '', 0.00),
(43, 'DINOSAURIO', 'es una representación digital tridimensional de estas fascinantes criaturas prehistóricas que dominaron la Tierra durante la era Mesozoica', 5, 2, 0, 0, 'activo', '../images/imagenes_catalogo/catalogo-43.png', '', 0.00),
(44, 'fantacia guerrera', 'mujer', 5, 2, 0, 0, 'activo', '../images/imagenes_catalogo/catalogo-44.png', '', 0.00);

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
-- Estructura de tabla para la tabla `trm`
--

CREATE TABLE `trm` (
  `identificador` int(4) NOT NULL,
  `fecha` date NOT NULL,
  `tasa` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trm`
--

INSERT INTO `trm` (`identificador`, `fecha`, `tasa`) VALUES
(1, '2024-09-06', 4172.50);

--
-- Disparadores `trm`
--
DELIMITER $$
CREATE TRIGGER `Actualizacion_Productos_Pvdolarinsert` AFTER INSERT ON `trm` FOR EACH ROW BEGIN
    UPDATE productos
    SET Pro_Pvdolar = Pro_PrecioVenta / NEW.tasa;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Actualizacion_Productos_Pvdolarupdate` AFTER UPDATE ON `trm` FOR EACH ROW BEGIN
    UPDATE productos
    SET Pro_pvdolar = Pro_PrecioVenta / NEW.tasa;
END
$$
DELIMITER ;

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
(1000000, 'Cliente prueba', '3210000000', 'prueba@gmail.com', 'Medellin', 'cl 1 23 65', '$2y$10$1FD6PUYuKx1t8S4LO9Frg.Gf9eAr0vpeWsmOYdZfPVLukXnSnc6aK', 2, 'activo'),
(2222222, 'Ruben Dario Triviño ', '3113287379', 'rudatrivi@hotmail.com', 'Bogota D.C.', 'diagonal 146 #136a-79', '$2y$10$tqEAPDd2wtrRquybzwOY9uX72YYlUQSpSChTWrptDRFy6x.1JVPde', 3, 'activo'),
(1000698993, 'Juan David Penagos', '3108199377', 'jjuandavid2003@gmail.com', 'Bogotá', 'Calle 19 El Bronx', '$2y$10$4YSTOtpwRnNK9lRF83yC7eQNbp4XuykCGhOGzhE4K3B.fixR3309i', 3, 'activo'),
(1014307293, 'Sebastian Lammy', '3194599719', 'sebastiancamilo@gmail.com', 'Bogota D.C.', 'CR 101 23 05 ', '$2y$10$ofavOWpSlCymMmhvQPuDpePeLq7h97SUiVLSmOMG1ttGucY4esdTO', 3, 'activo'),
(1026577616, 'Yordy Suárez Bonilla', '3214996400', 'ysuarez61@misena.edu.co', 'Bogotá', 'Calle Falsa # 123-4', '$2y$10$DjDdnVOHHBR6rnG2yc73Iut2xUU8c0n5O53n0DdAVbvayZ1smsdU.', 2, 'activo'),
(1026577618, 'Yordy Suarez', 'Usuario', 'yordy_9328@hotmail.com', 'Bogota D.C.', 'CL 72 SUR 22 26', '$2y$10$WNVnjb/exohqd3hKbyqfQuKk5HcCd5IgBBZOE9bFBOD5OX9IdXvwu', 3, 'activo'),
(1131110766, 'Ruben Dario Triviño', '3113287379', 'darioruben876@gmail.com', 'Bogotá', 'suba-bogota', '$2y$10$PGM06.gFmaiE7JxFpl9Fz.4TkyqEwW4IkOHsRg/pbjvyNVKzBt5Sm', 3, 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria_pedidos`
--
ALTER TABLE `auditoria_pedidos`
  ADD PRIMARY KEY (`identificador`);

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
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`Identificador`),
  ADD KEY `Pe_Cliente` (`Pe_Cliente`),
  ADD KEY `Pe_Estado` (`Pe_Estado`),
  ADD KEY `Pe_Producto` (`Pe_Producto`),
  ADD KEY `fk_compra_id` (`Compra_ID`);

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
-- Indices de la tabla `trm`
--
ALTER TABLE `trm`
  ADD PRIMARY KEY (`identificador`);

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
-- AUTO_INCREMENT de la tabla `auditoria_pedidos`
--
ALTER TABLE `auditoria_pedidos`
  MODIFY `identificador` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `calendario`
--
ALTER TABLE `calendario`
  MODIFY `identificador` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `Identificador` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=439;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `Identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `trm`
--
ALTER TABLE `trm`
  MODIFY `identificador` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `usuario` (`Usu_Identificacion`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`Compra_ID`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_compra_id` FOREIGN KEY (`Compra_ID`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`Pe_Cliente`) REFERENCES `usuario` (`Usu_Identificacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_3` FOREIGN KEY (`Pe_Estado`) REFERENCES `pedido_estado` (`Es_Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_4` FOREIGN KEY (`Pe_Producto`) REFERENCES `productos` (`Identificador`) ON DELETE CASCADE ON UPDATE CASCADE;

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
