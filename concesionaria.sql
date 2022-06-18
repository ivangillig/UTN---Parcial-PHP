-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.33 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para concesionaria
CREATE DATABASE IF NOT EXISTS `concesionaria` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci */;
USE `concesionaria`;

-- Volcando estructura para tabla concesionaria.auto
CREATE TABLE IF NOT EXISTS `auto` (
  `cod_auto` int(11) NOT NULL AUTO_INCREMENT,
  `marca` text NOT NULL,
  `modelo` text NOT NULL,
  `color` text NOT NULL,
  `pventa` decimal(10,0) NOT NULL,
  `km` decimal(10,0) NOT NULL,
  `cod_cliente` int(11) NOT NULL,
  PRIMARY KEY (`cod_auto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla concesionaria.auto: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `auto` DISABLE KEYS */;
INSERT INTO `auto` (`cod_auto`, `marca`, `modelo`, `color`, `pventa`, `km`, `cod_cliente`) VALUES
	(1, 'Fiat', 'Palio', 'blanco', 900000, 21500, 1),
	(2, 'Volkswagen', 'Golf', 'rojo', 950000, 20000, 2);
/*!40000 ALTER TABLE `auto` ENABLE KEYS */;

-- Volcando estructura para tabla concesionaria.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `cod_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nomyape` text NOT NULL,
  `direccion` text NOT NULL,
  `ciudad` text NOT NULL,
  `telefono` int(11) NOT NULL,
  `falta` date NOT NULL,
  PRIMARY KEY (`cod_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla concesionaria.cliente: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`cod_cliente`, `nomyape`, `direccion`, `ciudad`, `telefono`, `falta`) VALUES
	(1, 'Patricio Montenegro', 'Perito Moreno 111', 'Río Grande', 15555555, '2022-06-01'),
	(2, 'Guillermo Obando', 'San Martín 222', 'Río Grande', 15555551, '2022-06-01');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;

-- Volcando estructura para tabla concesionaria.revision
CREATE TABLE IF NOT EXISTS `revision` (
  `cod_revision` int(11) NOT NULL AUTO_INCREMENT,
  `fingreso` date NOT NULL,
  `fegreso` date DEFAULT NULL,
  `estado` text NOT NULL,
  `cambio_filtro` text NOT NULL,
  `cambio_aceite` text NOT NULL,
  `cambio_freno` text NOT NULL,
  `descripcion` text NOT NULL,
  `cod_auto` int(11) NOT NULL,
  PRIMARY KEY (`cod_revision`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla concesionaria.revision: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `revision` DISABLE KEYS */;
INSERT INTO `revision` (`cod_revision`, `fingreso`, `fegreso`, `estado`, `cambio_filtro`, `cambio_aceite`, `cambio_freno`, `descripcion`, `cod_auto`) VALUES
	(1, '2022-06-16', '2022-06-17', 'Finalizado', '1', '1', '0', 'no frena', 1),
	(13, '2022-06-17', NULL, 'En revisiÃ³n', 'Si', 'No', 'No', 'prueba 1', 2),
	(14, '2022-07-18', NULL, 'En revisiÃ³n', 'Si', 'No', 'No', 'Prueba de carga', 1),
	(15, '2022-07-20', '2022-06-18', 'Finalizado', 'No', 'Si', 'No', 'asd', 2);
/*!40000 ALTER TABLE `revision` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
