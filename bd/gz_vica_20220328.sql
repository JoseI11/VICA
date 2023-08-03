-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.26 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla vica.ajustes
DROP TABLE IF EXISTS `ajustes`;
CREATE TABLE IF NOT EXISTS `ajustes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `cod_ajuste_motivo` int(11) DEFAULT NULL,
  `cod_maquina` int(11) DEFAULT NULL,
  `cod_componente` int(11) DEFAULT NULL,
  `es_usado` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `observaciones` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.ajustes: 2 rows
DELETE FROM `ajustes`;
/*!40000 ALTER TABLE `ajustes` DISABLE KEYS */;
INSERT INTO `ajustes` (`codigo`, `fecha`, `cod_ajuste_motivo`, `cod_maquina`, `cod_componente`, `es_usado`, `cantidad`, `observaciones`, `usuario_m`, `fecha_m`) VALUES
	(1, '2022-03-28', 1, NULL, 4, NULL, 1.00, ' 123sda', 'pbocchio', '2022-03-28 08:16:18'),
	(2, '2022-03-28', 2, NULL, 4, NULL, 11.00, ' 123sda', 'pbocchio', '2022-03-28 08:19:25');
/*!40000 ALTER TABLE `ajustes` ENABLE KEYS */;

-- Volcando estructura para tabla vica.ajustes_motivos
DROP TABLE IF EXISTS `ajustes_motivos`;
CREATE TABLE IF NOT EXISTS `ajustes_motivos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `impacto` int(11) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.ajustes_motivos: 3 rows
DELETE FROM `ajustes_motivos`;
/*!40000 ALTER TABLE `ajustes_motivos` DISABLE KEYS */;
INSERT INTO `ajustes_motivos` (`codigo`, `descripcion`, `impacto`, `usuario_m`, `fecha_m`) VALUES
	(1, 'Cantidad Inicial', 1, 'pbocchio', '2022-03-28 08:09:35'),
	(2, 'Alta Stock', 1, 'pbocchio', '2022-03-28 08:09:35'),
	(3, 'Baja Stock', -1, 'pbocchio', '2022-03-28 08:09:35');
/*!40000 ALTER TABLE `ajustes_motivos` ENABLE KEYS */;

-- Volcando estructura para tabla vica.componentes
DROP TABLE IF EXISTS `componentes`;
CREATE TABLE IF NOT EXISTS `componentes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `codigo_mp` text,
  `codigo_prov` text,
  `dimension` text,
  `cod_unidad` int(11) DEFAULT NULL,
  `cod_componente_categoria` int(11) DEFAULT NULL,
  `costo_unitario` decimal(10,2) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `costo_unitario_usd` decimal(10,2) DEFAULT NULL,
  `precio_unitario_usd` decimal(10,2) DEFAULT NULL,
  `vigencia` date DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `es_insumo` int(11) NOT NULL DEFAULT '0',
  `stock_minimo` decimal(10,2) DEFAULT NULL,
  `stock_maximo` decimal(10,2) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.componentes: 4 rows
DELETE FROM `componentes`;
/*!40000 ALTER TABLE `componentes` DISABLE KEYS */;
INSERT INTO `componentes` (`codigo`, `descripcion`, `codigo_mp`, `codigo_prov`, `dimension`, `cod_unidad`, `cod_componente_categoria`, `costo_unitario`, `precio_unitario`, `costo_unitario_usd`, `precio_unitario_usd`, `vigencia`, `iva`, `es_insumo`, `stock_minimo`, `stock_maximo`, `usuario_m`, `fecha_m`) VALUES
	(1, 'Producto 1', NULL, NULL, NULL, 1, NULL, 10.00, 20.00, NULL, NULL, NULL, 21.00, 1, 9.00, 9.00, 'pbocchio', '2022-02-06 21:42:04'),
	(4, 'insumo1', NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'pbocchio', '2022-03-28 07:46:43'),
	(3, 'Producto 2', NULL, NULL, NULL, 1, NULL, 20.00, 40.00, NULL, NULL, NULL, 21.00, 1, 1.00, 2.00, 'pbocchio', '2022-02-06 21:42:28'),
	(5, 'produco', NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'pbocchio', '2022-03-28 07:47:06');
/*!40000 ALTER TABLE `componentes` ENABLE KEYS */;

-- Volcando estructura para tabla vica.componentes_categorias
DROP TABLE IF EXISTS `componentes_categorias`;
CREATE TABLE IF NOT EXISTS `componentes_categorias` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.componentes_categorias: 0 rows
DELETE FROM `componentes_categorias`;
/*!40000 ALTER TABLE `componentes_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `componentes_categorias` ENABLE KEYS */;

-- Volcando estructura para tabla vica.componentes_insumos
DROP TABLE IF EXISTS `componentes_insumos`;
CREATE TABLE IF NOT EXISTS `componentes_insumos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_componente` int(11) DEFAULT NULL,
  `cod_insumo` int(11) DEFAULT NULL,
  `cantidad` decimal(10,4) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.componentes_insumos: 2 rows
DELETE FROM `componentes_insumos`;
/*!40000 ALTER TABLE `componentes_insumos` DISABLE KEYS */;
INSERT INTO `componentes_insumos` (`codigo`, `cod_componente`, `cod_insumo`, `cantidad`, `usuario_m`, `fecha_m`) VALUES
	(2, 2, 1, 1.0000, 'pbocchio', '2022-01-28 13:38:04'),
	(5, 2, 3, 2.0000, 'pbocchio', '2022-01-28 13:39:17');
/*!40000 ALTER TABLE `componentes_insumos` ENABLE KEYS */;

-- Volcando estructura para tabla vica.empleados
DROP TABLE IF EXISTS `empleados`;
CREATE TABLE IF NOT EXISTS `empleados` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `activo` int(11) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.empleados: 0 rows
DELETE FROM `empleados`;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;

-- Volcando estructura para tabla vica.eventos
DROP TABLE IF EXISTS `eventos`;
CREATE TABLE IF NOT EXISTS `eventos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.eventos: 0 rows
DELETE FROM `eventos`;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;

-- Volcando estructura para tabla vica.maquinas
DROP TABLE IF EXISTS `maquinas`;
CREATE TABLE IF NOT EXISTS `maquinas` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `cod_maquina_modelo` int(11) DEFAULT NULL,
  `observaciones` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.maquinas: 1 rows
DELETE FROM `maquinas`;
/*!40000 ALTER TABLE `maquinas` DISABLE KEYS */;
INSERT INTO `maquinas` (`codigo`, `descripcion`, `cod_maquina_modelo`, `observaciones`, `usuario_m`, `fecha_m`) VALUES
	(2, 'MAQUINA', 2, 'DESCRIPCION', 'pbocchio', '2022-01-28 14:47:09');
/*!40000 ALTER TABLE `maquinas` ENABLE KEYS */;

-- Volcando estructura para tabla vica.maquinas_componentes
DROP TABLE IF EXISTS `maquinas_componentes`;
CREATE TABLE IF NOT EXISTS `maquinas_componentes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_componente` int(11) DEFAULT NULL,
  `cod_maquina` int(11) DEFAULT NULL,
  `cantidad` decimal(10,4) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.maquinas_componentes: 1 rows
DELETE FROM `maquinas_componentes`;
/*!40000 ALTER TABLE `maquinas_componentes` DISABLE KEYS */;
INSERT INTO `maquinas_componentes` (`codigo`, `cod_componente`, `cod_maquina`, `cantidad`, `usuario_m`, `fecha_m`) VALUES
	(2, 5, 2, 2.0000, 'pbocchio', '2022-03-28 07:47:15');
/*!40000 ALTER TABLE `maquinas_componentes` ENABLE KEYS */;

-- Volcando estructura para tabla vica.maquinas_modelos
DROP TABLE IF EXISTS `maquinas_modelos`;
CREATE TABLE IF NOT EXISTS `maquinas_modelos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.maquinas_modelos: 1 rows
DELETE FROM `maquinas_modelos`;
/*!40000 ALTER TABLE `maquinas_modelos` DISABLE KEYS */;
INSERT INTO `maquinas_modelos` (`codigo`, `descripcion`, `usuario_m`, `fecha_m`) VALUES
	(2, 'Modelo', 'pbocchio', '2022-01-28 14:29:50');
/*!40000 ALTER TABLE `maquinas_modelos` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_compras
DROP TABLE IF EXISTS `orden_compras`;
CREATE TABLE IF NOT EXISTS `orden_compras` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `fecha_estimada_recepcion` date DEFAULT NULL,
  `fecha_recepcion` date DEFAULT NULL,
  `remito` text,
  `observaciones` text,
  `cod_proveedor` int(11) DEFAULT NULL,
  `cod_orden_compra_estado` int(11) DEFAULT NULL,
  `es_interna` int(11) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_compras: 5 rows
DELETE FROM `orden_compras`;
/*!40000 ALTER TABLE `orden_compras` DISABLE KEYS */;
INSERT INTO `orden_compras` (`codigo`, `fecha`, `fecha_estimada_recepcion`, `fecha_recepcion`, `remito`, `observaciones`, `cod_proveedor`, `cod_orden_compra_estado`, `es_interna`, `usuario_m`, `fecha_m`) VALUES
	(1, '2022-01-27', '2022-01-28', '2022-01-29', '1234', '123', 3, 3, NULL, 'pbocchio', '2022-01-28 17:36:37'),
	(4, '2022-02-05', NULL, NULL, NULL, 'Compra de Insumos', 3, 3, NULL, 'pbocchio', '2022-02-05 14:15:25'),
	(5, '2022-03-28', '2022-03-31', '2022-03-31', '', 'descripcion 1', 3, 3, NULL, 'pbocchio', '2022-03-28 07:30:48'),
	(6, '2022-03-31', NULL, NULL, NULL, 'asd', 3, 1, NULL, 'pbocchio', '2022-03-28 07:41:30'),
	(7, '2022-03-30', NULL, NULL, NULL, 'qwe', 3, 1, NULL, 'pbocchio', '2022-03-28 07:42:00');
/*!40000 ALTER TABLE `orden_compras` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_compras_detalles
DROP TABLE IF EXISTS `orden_compras_detalles`;
CREATE TABLE IF NOT EXISTS `orden_compras_detalles` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `es_usado` int(11) NOT NULL DEFAULT '0',
  `cod_orden_compra` int(11) DEFAULT NULL,
  `cod_componente` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `cantidad_recibida` decimal(10,2) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `observaciones` text,
  `usuario_m` text,
  `fecha_m` text,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_compras_detalles: 3 rows
DELETE FROM `orden_compras_detalles`;
/*!40000 ALTER TABLE `orden_compras_detalles` DISABLE KEYS */;
INSERT INTO `orden_compras_detalles` (`codigo`, `es_usado`, `cod_orden_compra`, `cod_componente`, `cantidad`, `cantidad_recibida`, `precio`, `observaciones`, `usuario_m`, `fecha_m`) VALUES
	(2, 0, 1, 3, 2.00, 3.00, 150.00, NULL, 'pbocchio', '2022-01-28 17:36:07'),
	(3, 0, 4, 4, 1.00, 1.00, 120.00, NULL, 'pbocchio', '2022-02-05 14:13:18'),
	(4, 0, 5, 1, 1.00, 150.00, 150.00, NULL, 'pbocchio', '2022-03-28 07:30:18');
/*!40000 ALTER TABLE `orden_compras_detalles` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_compras_estados
DROP TABLE IF EXISTS `orden_compras_estados`;
CREATE TABLE IF NOT EXISTS `orden_compras_estados` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_compras_estados: 4 rows
DELETE FROM `orden_compras_estados`;
/*!40000 ALTER TABLE `orden_compras_estados` DISABLE KEYS */;
INSERT INTO `orden_compras_estados` (`codigo`, `descripcion`, `usuario_m`, `fecha_m`) VALUES
	(1, 'En Proceso', 'pbocchio', '2022-01-28 15:26:07'),
	(2, 'Pendiente de Recepcion', 'pbocchio', '2022-01-28 15:26:07'),
	(3, 'Finalizada', 'pbocchio', '2022-01-28 15:26:07'),
	(4, 'Anulada', 'pbocchio', '2022-01-28 15:26:07');
/*!40000 ALTER TABLE `orden_compras_estados` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_trabajo
DROP TABLE IF EXISTS `orden_trabajo`;
CREATE TABLE IF NOT EXISTS `orden_trabajo` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_recepcion` date DEFAULT NULL,
  `fecha_programada_entrega` date DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `nro_equipo` text,
  `cliente` text,
  `cuit_facturar` text,
  `observaciones` text,
  `cod_empleado` int(11) DEFAULT NULL,
  `cod_orden_trabajo_estado` int(11) DEFAULT NULL,
  `cod_orden_trabajo_tipo` int(11) DEFAULT NULL,
  `cod_orden_venta` int(11) DEFAULT NULL,
  `cod_maquina` int(11) DEFAULT NULL,
  `cod_componente` int(11) DEFAULT NULL,
  `modelo` int(11) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_trabajo: 1 rows
DELETE FROM `orden_trabajo`;
/*!40000 ALTER TABLE `orden_trabajo` DISABLE KEYS */;
INSERT INTO `orden_trabajo` (`codigo`, `fecha_recepcion`, `fecha_programada_entrega`, `fecha_entrega`, `nro_equipo`, `cliente`, `cuit_facturar`, `observaciones`, `cod_empleado`, `cod_orden_trabajo_estado`, `cod_orden_trabajo_tipo`, `cod_orden_venta`, `cod_maquina`, `cod_componente`, `modelo`, `version`, `usuario_m`, `fecha_m`) VALUES
	(1, NULL, '2022-03-28', NULL, NULL, 'q1', NULL, 'a2', NULL, 1, NULL, NULL, NULL, 5, NULL, NULL, 'pbocchio', '2022-03-28 09:49:23');
/*!40000 ALTER TABLE `orden_trabajo` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_trabajo_anexos
DROP TABLE IF EXISTS `orden_trabajo_anexos`;
CREATE TABLE IF NOT EXISTS `orden_trabajo_anexos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_orden_trabajo` int(11) DEFAULT NULL,
  `path_foto` text,
  `observaciones` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_trabajo_anexos: 0 rows
DELETE FROM `orden_trabajo_anexos`;
/*!40000 ALTER TABLE `orden_trabajo_anexos` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_trabajo_anexos` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_trabajo_categorias
DROP TABLE IF EXISTS `orden_trabajo_categorias`;
CREATE TABLE IF NOT EXISTS `orden_trabajo_categorias` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `tipo` text,
  `placeholder` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_trabajo_categorias: 0 rows
DELETE FROM `orden_trabajo_categorias`;
/*!40000 ALTER TABLE `orden_trabajo_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_trabajo_categorias` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_trabajo_componentes
DROP TABLE IF EXISTS `orden_trabajo_componentes`;
CREATE TABLE IF NOT EXISTS `orden_trabajo_componentes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_orden_trabajo` int(11) DEFAULT NULL,
  `cod_componente` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `costo_unitario` decimal(10,2) DEFAULT NULL,
  `costo_unitrario_usd` decimal(10,2) DEFAULT NULL,
  `observaciones` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_trabajo_componentes: 0 rows
DELETE FROM `orden_trabajo_componentes`;
/*!40000 ALTER TABLE `orden_trabajo_componentes` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_trabajo_componentes` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_trabajo_detalles
DROP TABLE IF EXISTS `orden_trabajo_detalles`;
CREATE TABLE IF NOT EXISTS `orden_trabajo_detalles` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_orden_trabajo` int(11) DEFAULT NULL,
  `cod_orden_trabajo_categoria` int(11) DEFAULT NULL,
  `valor` text,
  `observaciones` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_trabajo_detalles: 0 rows
DELETE FROM `orden_trabajo_detalles`;
/*!40000 ALTER TABLE `orden_trabajo_detalles` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_trabajo_detalles` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_trabajo_empleados
DROP TABLE IF EXISTS `orden_trabajo_empleados`;
CREATE TABLE IF NOT EXISTS `orden_trabajo_empleados` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_empleado` int(11) DEFAULT NULL,
  `observaciones` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_trabajo_empleados: 0 rows
DELETE FROM `orden_trabajo_empleados`;
/*!40000 ALTER TABLE `orden_trabajo_empleados` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_trabajo_empleados` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_trabajo_estados
DROP TABLE IF EXISTS `orden_trabajo_estados`;
CREATE TABLE IF NOT EXISTS `orden_trabajo_estados` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_trabajo_estados: 4 rows
DELETE FROM `orden_trabajo_estados`;
/*!40000 ALTER TABLE `orden_trabajo_estados` DISABLE KEYS */;
INSERT INTO `orden_trabajo_estados` (`codigo`, `descripcion`, `usuario_m`, `fecha_m`) VALUES
	(1, 'Emitido', 'pbocchio', '2021-12-17 14:52:25'),
	(2, 'En proceso', 'pbocchio', '2021-12-17 14:52:25'),
	(3, 'Terminado', 'pbocchio', '2021-12-17 14:52:25'),
	(4, 'Cancelado', 'pbocchio', '2021-12-17 14:52:25');
/*!40000 ALTER TABLE `orden_trabajo_estados` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_trabajo_eventos
DROP TABLE IF EXISTS `orden_trabajo_eventos`;
CREATE TABLE IF NOT EXISTS `orden_trabajo_eventos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_orden_trabajo` int(11) DEFAULT NULL,
  `cod_evento` int(11) DEFAULT NULL,
  `observaciones` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_trabajo_eventos: 0 rows
DELETE FROM `orden_trabajo_eventos`;
/*!40000 ALTER TABLE `orden_trabajo_eventos` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_trabajo_eventos` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_trabajo_tipos
DROP TABLE IF EXISTS `orden_trabajo_tipos`;
CREATE TABLE IF NOT EXISTS `orden_trabajo_tipos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_trabajo_tipos: 2 rows
DELETE FROM `orden_trabajo_tipos`;
/*!40000 ALTER TABLE `orden_trabajo_tipos` DISABLE KEYS */;
INSERT INTO `orden_trabajo_tipos` (`codigo`, `descripcion`, `usuario_m`, `fecha_m`) VALUES
	(1, 'Fabricación', 'pbocchio', '2021-12-17 14:47:35'),
	(2, 'Reparación', 'pbocchio', '2021-12-17 14:47:35');
/*!40000 ALTER TABLE `orden_trabajo_tipos` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_ventas
DROP TABLE IF EXISTS `orden_ventas`;
CREATE TABLE IF NOT EXISTS `orden_ventas` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `cod_cliente` int(11) DEFAULT NULL,
  `nombre_facturacion` text,
  `cuit` text,
  `cod_componente` int(11) DEFAULT NULL,
  `cod_orden_venta_estado_general` int(11) DEFAULT NULL,
  `cod_orden_venta_estado_entrega` int(11) DEFAULT NULL,
  `cod_orden_venta_estado_cobranza` int(11) DEFAULT NULL,
  `cod_orden_venta_tipo` int(11) DEFAULT NULL,
  `entrega_maquina` text,
  `precio_maquina` decimal(10,2) DEFAULT NULL,
  `descuentos` text,
  `entrega_valores` text,
  `fecha_entrega_maquina` text,
  `destino` text,
  `flete` text,
  `cod_vendedor` int(11) DEFAULT NULL,
  `comision_vendedor` decimal(10,2) DEFAULT NULL,
  `observaciones` text,
  `nro_factura_erp` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_ventas: 2 rows
DELETE FROM `orden_ventas`;
/*!40000 ALTER TABLE `orden_ventas` DISABLE KEYS */;
INSERT INTO `orden_ventas` (`codigo`, `fecha`, `cod_cliente`, `nombre_facturacion`, `cuit`, `cod_componente`, `cod_orden_venta_estado_general`, `cod_orden_venta_estado_entrega`, `cod_orden_venta_estado_cobranza`, `cod_orden_venta_tipo`, `entrega_maquina`, `precio_maquina`, `descuentos`, `entrega_valores`, `fecha_entrega_maquina`, `destino`, `flete`, `cod_vendedor`, `comision_vendedor`, `observaciones`, `nro_factura_erp`, `usuario_m`, `fecha_m`) VALUES
	(1, '2022-03-28', 3, NULL, NULL, 5, 1, 6, 8, NULL, NULL, 25.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ok', NULL, 'pbocchio', '2022-03-28 11:02:02'),
	(2, '2022-03-31', 3, NULL, NULL, 5, 3, 5, 9, NULL, NULL, 250.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, 'pbocchio', '2022-03-28 10:58:48');
/*!40000 ALTER TABLE `orden_ventas` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_ventas_estados
DROP TABLE IF EXISTS `orden_ventas_estados`;
CREATE TABLE IF NOT EXISTS `orden_ventas_estados` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `general` int(11) DEFAULT NULL,
  `entrega` int(11) DEFAULT NULL,
  `cobranza` int(11) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_ventas_estados: 10 rows
DELETE FROM `orden_ventas_estados`;
/*!40000 ALTER TABLE `orden_ventas_estados` DISABLE KEYS */;
INSERT INTO `orden_ventas_estados` (`codigo`, `descripcion`, `general`, `entrega`, `cobranza`, `usuario_m`, `fecha_m`) VALUES
	(1, 'Preliminar', 1, 0, 0, 'pbocchio', '2021-12-17 14:44:56'),
	(2, 'Aprobado', 1, 0, 0, 'pbocchio', '2021-12-17 14:44:56'),
	(3, 'Rechazado', 1, 0, 0, 'pbocchio', '2021-12-17 14:44:56'),
	(4, 'Cerrado', 1, 0, 0, 'pbocchio', '2021-12-17 14:44:56'),
	(5, 'Pendiente', 0, 1, 0, 'pbocchio', '2021-12-17 14:44:56'),
	(6, 'A retirar', 0, 1, 0, 'pbocchio', '2021-12-17 14:44:56'),
	(7, 'Entregada', 0, 1, 0, 'pbocchio', '2021-12-17 14:44:56'),
	(8, 'A cobrar', 0, 0, 1, 'pbocchio', '2021-12-17 14:44:56'),
	(9, 'Cobrado (Parcial)', 0, 0, 1, 'pbocchio', '2021-12-17 14:44:56'),
	(10, 'Cobrado', 0, 0, 1, 'pbocchio', '2021-12-17 14:44:56');
/*!40000 ALTER TABLE `orden_ventas_estados` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_ventas_tipos
DROP TABLE IF EXISTS `orden_ventas_tipos`;
CREATE TABLE IF NOT EXISTS `orden_ventas_tipos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_ventas_tipos: 3 rows
DELETE FROM `orden_ventas_tipos`;
/*!40000 ALTER TABLE `orden_ventas_tipos` DISABLE KEYS */;
INSERT INTO `orden_ventas_tipos` (`codigo`, `descripcion`, `usuario_m`, `fecha_m`) VALUES
	(1, 'Fabricación', 'pbocchio', '2021-12-17 14:47:35'),
	(2, 'Reparación', 'pbocchio', '2021-12-17 14:47:35'),
	(3, 'Repuestos', 'pbocchio', '2021-12-17 14:47:35');
/*!40000 ALTER TABLE `orden_ventas_tipos` ENABLE KEYS */;

-- Volcando estructura para tabla vica.paises
DROP TABLE IF EXISTS `paises`;
CREATE TABLE IF NOT EXISTS `paises` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.paises: 1 rows
DELETE FROM `paises`;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` (`codigo`, `descripcion`, `usuario_m`, `fecha_m`) VALUES
	(1, 'Argentina', 'pbocchio', '2021-12-17 14:32:01');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;

-- Volcando estructura para tabla vica.personas
DROP TABLE IF EXISTS `personas`;
CREATE TABLE IF NOT EXISTS `personas` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `telefono` text,
  `localidad` text,
  `cod_provincia` int(11) DEFAULT NULL,
  `cod_pais` int(11) DEFAULT NULL,
  `cliente` int(11) DEFAULT NULL,
  `proveedor` int(11) DEFAULT NULL,
  `transportista` int(11) DEFAULT NULL,
  `vendedor` int(11) DEFAULT NULL,
  `cuit` text,
  `mail` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.personas: 1 rows
DELETE FROM `personas`;
/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
INSERT INTO `personas` (`codigo`, `descripcion`, `telefono`, `localidad`, `cod_provincia`, `cod_pais`, `cliente`, `proveedor`, `transportista`, `vendedor`, `cuit`, `mail`, `usuario_m`, `fecha_m`) VALUES
	(3, 'Pablo Bocchio', '3406411105', 'Rafaela', 1, 1, 1, 1, 0, 0, '20350635115', 'pablobocchio@gmail.com', 'pbocchio', '2022-02-05 10:38:52');
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;

-- Volcando estructura para tabla vica.provincias
DROP TABLE IF EXISTS `provincias`;
CREATE TABLE IF NOT EXISTS `provincias` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `cod_pais` int(11) DEFAULT '1',
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.provincias: 2 rows
DELETE FROM `provincias`;
/*!40000 ALTER TABLE `provincias` DISABLE KEYS */;
INSERT INTO `provincias` (`codigo`, `descripcion`, `cod_pais`, `usuario_m`, `fecha_m`) VALUES
	(1, 'Santa Fe', 1, 'pbocchio', '2021-12-17 14:32:29'),
	(2, 'Córdoba', 1, 'pbocchio', '2021-12-17 14:32:29');
/*!40000 ALTER TABLE `provincias` ENABLE KEYS */;

-- Volcando estructura para tabla vica.reparaciones
DROP TABLE IF EXISTS `reparaciones`;
CREATE TABLE IF NOT EXISTS `reparaciones` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `descripcion` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.reparaciones: 0 rows
DELETE FROM `reparaciones`;
/*!40000 ALTER TABLE `reparaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `reparaciones` ENABLE KEYS */;

-- Volcando estructura para tabla vica.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.roles: 6 rows
DELETE FROM `roles`;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`codigo`, `descripcion`, `usuario_m`, `fecha_m`) VALUES
	(1, 'Administrador', 'pbocchio', '2021-12-17 14:30:52'),
	(2, 'Comercial', 'pbocchio', '2021-12-17 14:30:52'),
	(3, 'Administración', 'pbocchio', '2021-12-17 14:30:52'),
	(4, 'Producción', 'pbocchio', '2021-12-17 14:30:52'),
	(5, 'Gerencia', 'pbocchio', '2021-12-17 14:30:52'),
	(6, 'Compras', 'pbocchio', '2021-12-17 14:30:52');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Volcando estructura para tabla vica.unidades
DROP TABLE IF EXISTS `unidades`;
CREATE TABLE IF NOT EXISTS `unidades` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `descrip_abrev` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.unidades: 2 rows
DELETE FROM `unidades`;
/*!40000 ALTER TABLE `unidades` DISABLE KEYS */;
INSERT INTO `unidades` (`codigo`, `descripcion`, `descrip_abrev`, `usuario_m`, `fecha_m`) VALUES
	(1, 'Unidad', 'Unid', 'pbocchio', '2021-12-24 00:00:00'),
	(2, 'Litros', 'Lts', 'pbocchio', '2022-02-05 10:49:13');
/*!40000 ALTER TABLE `unidades` ENABLE KEYS */;

-- Volcando estructura para tabla vica.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` text,
  `password` text,
  `cod_rol` int(11) DEFAULT NULL,
  `nombre` text,
  `mail` text,
  `usuario_m` text,
  `fecha_m` date DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla vica.usuarios: ~1 rows (aproximadamente)
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`codigo`, `usuario`, `password`, `cod_rol`, `nombre`, `mail`, `usuario_m`, `fecha_m`) VALUES
	(1, 'pbocchio', '827ccb0eea8a706c4c34a16891f84e7b', 1, 'Pablo Bocchio', 'pablobocchio@gmail.com', 'pbocchio', '2021-11-02'),
	(2, 'facu', 'f8e0920f29985ad1a2724161e86faa65', 1, 'Facundo Curbelo', 'fcurbelo@mywork.com.ar', 'pbocchio', '2022-02-05');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla vica.ventas
DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_maquina` int(11) DEFAULT NULL,
  `fecha_venta` date DEFAULT NULL,
  `venta_con_iva` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `cod_cliente` int(11) DEFAULT NULL,
  `reintegro` decimal(10,2) DEFAULT NULL,
  `cod_reparacion` int(11) DEFAULT NULL,
  `entrega_usada` int(11) DEFAULT NULL,
  `precio_usado` decimal(10,2) DEFAULT NULL,
  `cod_orden_venta` int(11) DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `cod_vendedor` int(11) DEFAULT NULL,
  `localidad` text,
  `cod_provincia` int(11) DEFAULT NULL,
  `cod_pais` int(11) DEFAULT NULL,
  `pago_a_cuenta` decimal(10,2) DEFAULT NULL,
  `cobrado` int(11) DEFAULT NULL,
  `por_mes` decimal(10,2) DEFAULT NULL,
  `cheque_1_cdo` decimal(10,2) DEFAULT NULL,
  `cheque_2_30` decimal(10,2) DEFAULT NULL,
  `cheque_3_60` decimal(10,2) DEFAULT NULL,
  `cheque_4_90` decimal(10,2) DEFAULT NULL,
  `cheque_5_120` decimal(10,2) DEFAULT NULL,
  `cheque_6_150` decimal(10,2) DEFAULT NULL,
  `cheque_7_180` decimal(10,2) DEFAULT NULL,
  `cheque_8_210` decimal(10,2) DEFAULT NULL,
  `cheque_9_240` decimal(10,2) DEFAULT NULL,
  `cheque_10_270` decimal(10,2) DEFAULT NULL,
  `cheque_11_300` decimal(10,2) DEFAULT NULL,
  `cheque_12_330` decimal(10,2) DEFAULT NULL,
  `cheque_13_360` decimal(10,2) DEFAULT NULL,
  `mat_prima` decimal(10,2) DEFAULT NULL,
  `saldo_gastos` decimal(10,2) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.ventas: 0 rows
DELETE FROM `ventas`;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;

-- Volcando estructura para tabla vica.ventas_detalles
DROP TABLE IF EXISTS `ventas_detalles`;
CREATE TABLE IF NOT EXISTS `ventas_detalles` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_venta` int(11) DEFAULT NULL,
  `cod_componente` int(11) DEFAULT NULL,
  `cod_reparacion` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.ventas_detalles: 0 rows
DELETE FROM `ventas_detalles`;
/*!40000 ALTER TABLE `ventas_detalles` DISABLE KEYS */;
/*!40000 ALTER TABLE `ventas_detalles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
