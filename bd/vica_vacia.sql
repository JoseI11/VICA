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

-- Volcando estructura para tabla vica.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `telefono` text,
  `localidad` text,
  `cod_pais` int(11) DEFAULT NULL,
  `cod_provincia` int(11) DEFAULT NULL,
  `mail` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.clientes: 0 rows
DELETE FROM `clientes`;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Volcando estructura para tabla vica.componentes
CREATE TABLE IF NOT EXISTS `componentes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `codigo_mp` text,
  `codigo_prov` text,
  `dimension` text,
  `cod_unidad` int(11) DEFAULT NULL,
  `cod_componente_categoria` int(11) DEFAULT NULL,
  `costo_unitario` decimal(10,2) DEFAULT NULL,
  `vigencia` date DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.componentes: 0 rows
DELETE FROM `componentes`;
/*!40000 ALTER TABLE `componentes` DISABLE KEYS */;
/*!40000 ALTER TABLE `componentes` ENABLE KEYS */;

-- Volcando estructura para tabla vica.componentes_categorias
CREATE TABLE IF NOT EXISTS `componentes_categorias` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.componentes_categorias: 0 rows
DELETE FROM `componentes_categorias`;
/*!40000 ALTER TABLE `componentes_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `componentes_categorias` ENABLE KEYS */;

-- Volcando estructura para tabla vica.empleados
CREATE TABLE IF NOT EXISTS `empleados` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.empleados: 0 rows
DELETE FROM `empleados`;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;

-- Volcando estructura para tabla vica.maquinas
CREATE TABLE IF NOT EXISTS `maquinas` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `cod_maquina_modelo` int(11) DEFAULT NULL,
  `descripcion` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.maquinas: 0 rows
DELETE FROM `maquinas`;
/*!40000 ALTER TABLE `maquinas` DISABLE KEYS */;
/*!40000 ALTER TABLE `maquinas` ENABLE KEYS */;

-- Volcando estructura para tabla vica.maquinas_componentes
CREATE TABLE IF NOT EXISTS `maquinas_componentes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_componente` int(11) DEFAULT NULL,
  `cod_maquina` int(11) DEFAULT NULL,
  `cantidad` decimal(10,4) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.maquinas_componentes: 0 rows
DELETE FROM `maquinas_componentes`;
/*!40000 ALTER TABLE `maquinas_componentes` DISABLE KEYS */;
/*!40000 ALTER TABLE `maquinas_componentes` ENABLE KEYS */;

-- Volcando estructura para tabla vica.maquinas_modelos
CREATE TABLE IF NOT EXISTS `maquinas_modelos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.maquinas_modelos: 0 rows
DELETE FROM `maquinas_modelos`;
/*!40000 ALTER TABLE `maquinas_modelos` DISABLE KEYS */;
/*!40000 ALTER TABLE `maquinas_modelos` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_reparaciones
CREATE TABLE IF NOT EXISTS `orden_reparaciones` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_recepcion` date DEFAULT NULL,
  `fecha_programada_entrega` date DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `nro_equipo` text,
  `cliente` text,
  `cuit_facturar` text,
  `cod_empleado` int(11) DEFAULT NULL,
  `modelo` int(11) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_reparaciones: 0 rows
DELETE FROM `orden_reparaciones`;
/*!40000 ALTER TABLE `orden_reparaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_reparaciones` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_reparaciones_categorias
CREATE TABLE IF NOT EXISTS `orden_reparaciones_categorias` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `tipo` text,
  `placeholder` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_reparaciones_categorias: 0 rows
DELETE FROM `orden_reparaciones_categorias`;
/*!40000 ALTER TABLE `orden_reparaciones_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_reparaciones_categorias` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_reparaciones_detalles
CREATE TABLE IF NOT EXISTS `orden_reparaciones_detalles` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_orden_trabajo` int(11) DEFAULT NULL,
  `cod_orden_trabajo_categoria` int(11) DEFAULT NULL,
  `valor` text,
  `observaciones` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_reparaciones_detalles: 0 rows
DELETE FROM `orden_reparaciones_detalles`;
/*!40000 ALTER TABLE `orden_reparaciones_detalles` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_reparaciones_detalles` ENABLE KEYS */;

-- Volcando estructura para tabla vica.orden_ventas
CREATE TABLE IF NOT EXISTS `orden_ventas` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `cod_cliente` int(11) DEFAULT NULL,
  `nombre_facturacion` text,
  `cuit` text,
  `cod_maquina` int(11) DEFAULT NULL,
  `entrega_maquina` text,
  `precio_maquina` text,
  `descuentos` text,
  `entrega_valores` text,
  `fecha_entrega_maquina` text,
  `destino` text,
  `flete` text,
  `cod_vendedor` int(11) DEFAULT NULL,
  `comision_vendedor` decimal(10,2) DEFAULT NULL,
  `observaciones` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.orden_ventas: 0 rows
DELETE FROM `orden_ventas`;
/*!40000 ALTER TABLE `orden_ventas` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_ventas` ENABLE KEYS */;

-- Volcando estructura para tabla vica.paises
CREATE TABLE IF NOT EXISTS `paises` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.paises: 0 rows
DELETE FROM `paises`;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;

-- Volcando estructura para tabla vica.provincias
CREATE TABLE IF NOT EXISTS `provincias` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `cod_pais` int(11) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` text,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.provincias: 0 rows
DELETE FROM `provincias`;
/*!40000 ALTER TABLE `provincias` DISABLE KEYS */;
/*!40000 ALTER TABLE `provincias` ENABLE KEYS */;

-- Volcando estructura para tabla vica.reparaciones
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
CREATE TABLE IF NOT EXISTS `roles` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.roles: 0 rows
DELETE FROM `roles`;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Volcando estructura para tabla vica.unidades
CREATE TABLE IF NOT EXISTS `unidades` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `abrev` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.unidades: 0 rows
DELETE FROM `unidades`;
/*!40000 ALTER TABLE `unidades` DISABLE KEYS */;
/*!40000 ALTER TABLE `unidades` ENABLE KEYS */;

-- Volcando estructura para tabla vica.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` text,
  `password` text,
  `cod_rol` int(11) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` date DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla vica.usuarios: ~0 rows (aproximadamente)
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`codigo`, `usuario`, `password`, `cod_rol`, `usuario_m`, `fecha_m`) VALUES
	(1, 'pbocchio', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'pbocchio', '2021-11-02');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla vica.vendedores
CREATE TABLE IF NOT EXISTS `vendedores` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `telefono` text,
  `localidad` text,
  `provincia` text,
  `mail` text,
  `cuit` text,
  `comision` decimal(10,2) DEFAULT NULL,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.vendedores: 0 rows
DELETE FROM `vendedores`;
/*!40000 ALTER TABLE `vendedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendedores` ENABLE KEYS */;

-- Volcando estructura para tabla vica.ventas
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
  `cod_venta_estado` int(11) DEFAULT NULL,
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

-- Volcando estructura para tabla vica.ventas_estados
CREATE TABLE IF NOT EXISTS `ventas_estados` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `usuario_m` text,
  `fecha_m` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla vica.ventas_estados: 0 rows
DELETE FROM `ventas_estados`;
/*!40000 ALTER TABLE `ventas_estados` DISABLE KEYS */;
/*!40000 ALTER TABLE `ventas_estados` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
