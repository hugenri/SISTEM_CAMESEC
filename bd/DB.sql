-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         10.2.3-MariaDB-log - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla golem.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidoPaterno` varchar(100) NOT NULL,
  `apellidoMaterno` varchar(100) DEFAULT NULL,
  `calle` varchar(100) NOT NULL,
  `numero` varchar(100) NOT NULL,
  `colonia` varchar(100) NOT NULL,
  `municipio` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `cp` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `password` varchar(80),
  `rfc` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.cotizaciones
CREATE TABLE IF NOT EXISTS `cotizaciones` (
  `idCotizacion` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `observaciones` varchar(150) DEFAULT NULL,
  `idSolicitudCotizacion` int(11) DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `descuento` int(11) DEFAULT NULL,
  `costo_instalacion` decimal(10,2) DEFAULT NULL,
  `estatus` varchar(20) DEFAULT 'enviada',
  PRIMARY KEY (`idCotizacion`),
  KEY `fk_solicitud_cotizacion_id` (`idSolicitudCotizacion`),
  CONSTRAINT `fk_solicitud_cotizacion_id` FOREIGN KEY (`idSolicitudCotizacion`) REFERENCES `solicitudes_cotizacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.facturas
CREATE TABLE IF NOT EXISTS `facturas` (
  `idFactura` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `idCotizacion` int(11) NOT NULL,
  `estatus` varchar(20) DEFAULT 'pendiente',
  PRIMARY KEY (`idFactura`),
  KEY `fk_cotizacionId` (`idCotizacion`),
  CONSTRAINT `fk_cotizacionId` FOREIGN KEY (`idCotizacion`) REFERENCES `cotizaciones` (`idCotizacion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.orden_compras
CREATE TABLE IF NOT EXISTS `orden_compras` (
  `idOrdenCompra` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `observaciones` varchar(150) DEFAULT NULL,
  `idCotizacion` int(11) DEFAULT NULL,
  `estado` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`idOrdenCompra`),
  KEY `fk_cotizacion_id` (`idCotizacion`),
  CONSTRAINT `fk_cotizacion_id` FOREIGN KEY (`idCotizacion`) REFERENCES `cotizaciones` (`idCotizacion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.producto
CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idProveedor` int(10) DEFAULT 0,
  `nombre` varchar(25) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `precio` float(8,2) NOT NULL,
  `stock` int(10) NOT NULL,
  `imagen` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idProveedor` (`idProveedor`),
  CONSTRAINT `fk_idProveedor` FOREIGN KEY (`idProveedor`) REFERENCES `proveedor` (`idProveedor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.productos_cotizacion
CREATE TABLE IF NOT EXISTS `productos_cotizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCotizacion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idCotizacion` (`idCotizacion`),
  CONSTRAINT `fk_idCotizacion` FOREIGN KEY (`idCotizacion`) REFERENCES `cotizaciones` (`idCotizacion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.proveedor
CREATE TABLE IF NOT EXISTS `proveedor` (
  `idProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellidoPaterno` varchar(100) DEFAULT NULL,
  `apellidoMaterno` varchar(100) DEFAULT NULL,
  `informacionContacto` varchar(100) DEFAULT NULL,
  `calle` varchar(100) DEFAULT NULL,
  `numero` varchar(100) DEFAULT NULL,
  `colonia` varchar(100) DEFAULT NULL,
  `municipio` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `cp` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `otrosDetalles` varchar(100) DEFAULT NULL,
  `idCategoria` varchar(50) DEFAULT 'sin categoría ',
  PRIMARY KEY (`idProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `idServicio` int(11) NOT NULL AUTO_INCREMENT,
  `idOrdenCompra` int(11) DEFAULT NULL,
  `detalles` varchar(150) DEFAULT NULL,
  `idEmpleado` int(11) DEFAULT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`idServicio`),
  KEY `fk_orden_compra_id` (`idOrdenCompra`),
  KEY `fk_empleado_id` (`idEmpleado`),
  CONSTRAINT `fk_empleado_id` FOREIGN KEY (`idEmpleado`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_orden_compra_id` FOREIGN KEY (`idOrdenCompra`) REFERENCES `orden_compras` (`idOrdenCompra`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.solicitudes_cotizacion
CREATE TABLE IF NOT EXISTS `solicitudes_cotizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `servicio` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fecha_solicitud` date DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_idCliente` (`id_cliente`),
  CONSTRAINT `fk_cliente_idCliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`idCliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.t_estado
CREATE TABLE IF NOT EXISTS `t_estado` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.t_municipio
CREATE TABLE IF NOT EXISTS `t_municipio` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `id_estado` smallint(6) NOT NULL,
  `municipio` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_municipio_estado` (`id_estado`),
  CONSTRAINT `fk_municipio_estado` FOREIGN KEY (`id_estado`) REFERENCES `t_estado` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2457 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `apellidoPaterno` varchar(40) NOT NULL,
  `apellidoMaterno` varchar(40) NOT NULL,
  `rol_usuario` varchar(10) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla golem.ventas_productos
CREATE TABLE IF NOT EXISTS `ventas_productos` (
  `id_venta` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_venta` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
