-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-07-2024 a las 22:35:31
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
-- Base de datos: `acueducto_aranda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abonos`
--

CREATE TABLE `abonos` (
  `cod_cliente` int(11) NOT NULL,
  `cod_abono` int(11) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `abonos`
--

INSERT INTO `abonos` (`cod_cliente`, `cod_abono`, `concepto`, `fecha`, `valor`) VALUES
(1, 48, 'abono de facturas', '2024-07-28', 6000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `estrato` int(3) NOT NULL,
  `sector` varchar(20) NOT NULL,
  `uso` varchar(50) NOT NULL,
  `codigo_medidor` varchar(50) NOT NULL,
  `diametro_medidor` varchar(50) NOT NULL,
  `fundador` varchar(3) NOT NULL,
  `activo` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`codigo`, `nombre`, `apellido`, `direccion`, `estrato`, `sector`, `uso`, `codigo_medidor`, `diametro_medidor`, `fundador`, `activo`) VALUES
(1, 'HERNANDO ', 'BURGOS ', 'CRA 40CASA 40A', 1, '1', 'Comercial', '15131250', '1/2 PULGADA ', 'NO', 'SI'),
(2, 'CARMEN ', 'BURGOS ', 'CRA 40 CASA 40 A ', 1, '1', 'Residencial', '15019662 ', '1/2 PULGADA ', 'SI', 'SI'),
(3, 'MARILIN ESTRELLA ', 'BENAVIDES ', 'CRA 40 ARANDA ', 1, '1', 'Comercial', '15131256 ', '1/2 PULGADA ', 'NO', 'SI'),
(4, 'GRACELIANA ', 'DIAZ SAVEEDRA', 'CRA 40 CSA 045 ', 1, '1', 'Comercial', '15131255', '1/2 PULGADA ', 'SI', 'SI'),
(5, 'NELSON', 'SANTACRUZ ', 'ARANDA', 1, '1', 'Comercial', '21305921', '1/2 PULGADA', 'NO', 'SI'),
(6, 'LAURA ', 'B DE CANTUCA', 'CLLE 40 ARANDA ', 1, '1', 'Comercial', '15016233', '1/2 PULGADA', 'SI', 'SI'),
(7, 'ALEJANDRINA', 'BURBANO', 'CASA 46 ARANDA', 1, '1', 'Comercial', '15014225 ', '1/2 PULGADA ', 'NO', 'SI'),
(8, 'MAXIMO', 'CHINCHAJOA POTOSI', 'CLLE 40 CASA 46', 1, '1', 'Comercial', '15010595 ', '1/2 PULGADA ', 'NO', 'SI'),
(9, 'JESUS ', 'TUTISTAR', 'ARANDA ', 1, '1', 'Comercial', '15010259', '1/2 PULGADA ', 'SI', 'SI'),
(10, 'JESUS', 'ZAMBRANO', 'ARANDA ', 1, '1', 'Comercial', '17526146', '1/2 PULGADA ', 'NO', 'SI'),
(11, 'SANDRA P', 'CHINCHAJOA', 'CSA 40 ARANDA ', 1, '1', 'Comercial', '15014234 ', '1/2 PULGADA ', 'NO', 'SI'),
(12, 'LUCIA ESPERANZA', 'ZAMBRANO', 'ARANDA ', 1, '1', 'Comercial', '0173552', '1/2 PULGADA ', 'NO', 'SI'),
(13, 'DAVID', 'CHINCHAJOA ', 'CASA 49 ', 1, '1', 'Comercial', '15016218 ', '1/2 PULGADA ', 'NO', 'SI'),
(14, 'PASTOR', 'CHINCHAJOA', 'CRA 40 CSA 044', 1, '1', 'Comercial', '15010594', '1/2 PULGADA', 'NO', 'SI'),
(15, 'ROSAURA', 'CHINCHAJOA', 'ARANDA ', 1, '1', 'Comercial', '20242060', '1/2 PULGADA', 'NO', 'SI'),
(16, 'MARUJITA', 'CHINCHAJOA', 'CRA 40 CSA 47 ', 1, '1', 'Comercial', '071221999', '1/2 PULGADA', 'NO', 'SI'),
(17, 'CLAUDIA MILENA', 'CHINCHAJOA ', 'CASA 51B ARANDA', 1, '1', 'Comercial', '15016221 ', '1/2 PULGADA ', 'NO', 'SI'),
(18, 'ARCENIS DARIO', 'CHINCHAJOA', 'ARANDA ', 1, '1', 'Comercial', '14078897', '1/2 PULGADA', 'NO', 'SI'),
(19, 'PEDRO ANTONIO', 'CHINCHAJOA', 'ARANDA ', 1, '1', 'Comercial', '15014228', '1/2 PULGADA', 'NO', 'SI'),
(20, 'MERCEDES ', 'POTOSI DE MUÑOZ', 'CLLE 40 CSA 55B', 1, '1', 'Comercial', '15014244', '1/2 PULGADA', 'NO', 'SI'),
(21, 'BEATRIZ', 'TULCAN NUPAN', 'CLLE 40 CSA 55B', 1, '1', 'Comercial', '0', '1/2 PULGADA', 'NO', 'SI'),
(22, 'GABRIELA', 'VALLEJO', 'CALLE 40 CASA 56B ', 1, '1', 'Residencial', '15131253 ', '1/2 PULGADA ', 'SI', 'SI'),
(23, 'CARLOS ALBERTO', 'RUALES', 'ARANDA ', 1, '1', 'Comercial', '15810590', '1/2 PULGADA', 'NO', 'SI'),
(24, 'GERMAN', 'MUÑOZ POTOSI', 'CRA 40 CSA 58', 1, '1', 'Comercial', '15014329', '1/2 PULGADA', 'NO', 'SI'),
(25, 'RAUL ', 'VILLOTA BURGOS', 'CLLE 40 CSA 28A-22', 1, '1', 'Comercial', '15016216', '1/2 PULGADA', 'NO', 'SI'),
(26, 'AMPARO ', 'BOTINA DE MUÑOZ', 'CLLE 40 CSA 28A-22', 1, '1', 'Comercial', '15016215', '1/2 PULGADA', 'NO', 'SI'),
(27, 'MARIA EDILMA ', 'GONZALEZ 1', 'CLLE 40 CSA 28A-22 ', 1, '1', 'Comercial', '0', '1/2 PULGADA', 'NO', 'SI'),
(28, 'MARIA EDILMA', 'GONZALEZ 2', 'CLLE 40 CSA 95', 1, '1', 'Comercial', '15010591', '1/2 PULGADA', 'NO', 'SI'),
(29, 'MARIA EDILMA', 'GONZALEZ 3', 'ARANDA ', 1, '1', 'Comercial', '21085043', '1/2 PULGADA ', 'NO', 'SI'),
(30, 'JESUS REMIGIO', 'NARVAEZ', 'ARANDA ', 1, '1', 'Comercial', '18582250 ', '1/2 PULGADA ', 'NO', 'SI'),
(31, 'AGUSTIN', 'VILLOTA', 'CASA 51 A ', 1, '1', 'Comercial', '15016220 ', '1/2 PULGADA ', 'NO', 'SI'),
(32, 'MARIA MIGUELINA ', 'NARVAEZ', 'CRA 40 CSA 57 ARANDA ', 1, '1', 'Comercial', '15016222', '1/2 PULGADA ', 'NO', 'SI'),
(33, 'IRMA CATERINE', 'NARVAEZ', 'ARANDA ', 1, '1', 'Comercial', '15014243 ', '1/2 PULGADA ', 'NO', 'SI'),
(34, 'JUDITH', 'NARVAEZ', 'CSA 49 ARANDA ', 1, '1', 'Comercial', '15016219', '1/2 PULGADA', 'NO', 'SI'),
(35, 'JULIA', 'MAINGUEZ', 'ARANDA ', 1, '1', 'Comercial', '0', '1/2 PULGADA', 'NO', 'SI'),
(36, 'PATRICIA', 'SANTACRUZ ', 'ARANDA ', 1, '1', 'Comercial', '0', '1/2 PULGADA', 'NO', 'SI'),
(37, 'DANIEL', 'VELEZ SANTACRUZ', 'CLLE 40 CSA 52', 1, '1', 'Comercial', '150142358', '1/2 PULGADA', 'NO', 'SI'),
(38, 'PATRICIA', 'SANTACRUZ', 'CRA 40 CSA 58 ', 1, '1', 'Comercial', '15014230', '1/2 PULGADA', 'NO', 'SI'),
(39, 'JORGE', 'SANTACRUZ', 'ARANDA ', 1, '1', 'Residencial', '15016230', '1/2 PULGADA', 'SI', 'SI'),
(40, 'MONICA L', 'CHINCHAJOA', 'ARANDA ', 1, '1', 'Comercial', '0', '1/2 PULGADA', 'NO', 'SI'),
(41, 'LUIS FELIPE', 'SANTACRUZ', 'CLLE 40 ARANDA ', 1, '1', 'Comercial', '15131254', '1/2 PULGADA', 'NO', 'SI'),
(42, 'AURA', 'PAEZ', 'ARANDA ', 1, '1', 'Comercial', '20256597', '1/2 PULGADA', 'NO', 'SI'),
(43, 'WILLIAN FERNEY ', 'MENA', 'CSA 15 ARANDA ', 1, '1', 'Comercial', '15131133', '1/2 PULGADA ', 'NO', 'SI'),
(44, 'YAQUELINE', 'PEREZ', 'ARANDA ', 1, '1', 'Comercial', '0', '1/2 PULGADA ', 'NO', 'SI'),
(45, 'JAVIER', 'TUTISTAR', 'ARANDA ', 1, '1', 'Comercial', '1735352018 ', '1/2 PULGADA ', 'NO', 'SI'),
(46, 'JAIRO ANIBAL', 'MORA', 'ARANDA ', 1, '2', 'Residencial', '15131215', '1/2 PULGADA ', 'SI', 'SI'),
(47, 'ARMANDO', 'BASANTE', 'CLLE 40 ARANDA', 1, '2', 'Comercial', '0117642', '1/2 PULGADA', 'NO', 'SI'),
(48, 'MARIA HELENA', 'LUCANO', 'CALLE 24 CASA 17 ', 1, '2', 'Comercial', '16053078 ', '1/2 PULGADA ', 'NO', 'SI'),
(49, 'OLGA CRISTINA', 'VELASQUEZ', 'ARANDA ', 1, '2', 'Comercial', '16043904', '1/2 PULGADA ', 'NO', 'SI'),
(50, 'LUIS', 'ZAMBRANO', 'CLLE 40 CSA 56-A ARANDA ', 1, '2', 'Residencial', '15131260', '1/2 PULGADA', 'NO', 'SI'),
(51, 'DIEGO', 'LOPEZ', 'CALLE 24 CASA 17 ', 1, '2', 'Residencial', '01533821', '1/2 PULGADA ', 'NO', 'SI'),
(52, 'JUAN DAVID', 'LUNA', 'CSA 15 ARANDA ', 1, '2', 'Residencial', '15131133', '1/2 PULGADA ', 'NO', 'SI'),
(53, 'ZATURIA ', 'ZAMBRANO', 'ARANDA ', 1, '2', 'Residencial', '13CP6904', '1/2 PULGADA', 'NO', 'SI'),
(54, 'MARIA ZATURIA', 'ZAMBRANO', 'ARANDA ', 1, '2', 'Residencial', '15013265', '1/2 PULGADA ', 'NO', 'SI'),
(55, 'TEREZA', 'TUMAL PAZ', 'LOTE ', 1, '2', 'Residencial', '0', '1/2 PULGADA ', 'NO', 'SI'),
(56, 'JOSE VICENTE', 'TUMAL', 'CLLE 40 # 21-256 ', 1, '2', 'Residencial', '15016232', '1/2 PULGADA ', 'NO', 'SI'),
(57, 'AMPARO', 'TUMAL PAZ', 'ARANDA ', 1, '2', 'Residencial', '15010592 ', '1/2 PULGADA ', 'NO', 'SI'),
(58, 'JESUS', 'TUMAL PAZ', 'CSA 16 ARANDA ', 1, '2', 'Residencial', '15131208', '1/2 PULGADA ', 'NO', 'SI'),
(59, 'ANTONIO', 'TUMAL PAZ', 'CLLE 40 CSA 56 ', 1, '2', 'Residencial', '15131214', '1/2 PULGADA ', 'NO', 'SI'),
(60, 'MARTHA CECILIA ', 'HERNANDES', 'CLLE 40 CSA 55', 1, '2', 'Residencial', '14068990', '1/2 PULGADA', 'NO', 'SI'),
(61, 'MARTHA CECILIA', 'HERNANDES', 'ARANDA ', 1, '2', 'Residencial', '15131207 ', '1/2 PULGADA', 'NO', 'SI'),
(62, 'SERGIO LEONEL', 'QUENAN', 'ARANDA ', 1, '2', 'Residencial', '15010592', '1/2 PULGADA ', 'NO', 'SI'),
(63, 'DORIS ESLINDA', 'CANTUCA', 'CASA 55 ', 1, '3', 'Residencial', '14068985 ', '1/2 PULGADA', 'NO', 'SI'),
(64, 'JOSE OMAR ', 'SANTACRUZ', 'CALLE 40 CASA 54', 1, '3', 'Residencial', '15016226 ', '1/2 PULGADA ', 'NO', 'SI'),
(65, 'HELEN FERNANDA', 'SANTACRUZ', 'CLLE 40 CSA 54 ', 1, '3', 'Residencial', '15016723', '1/2 PULGADA', 'NO', 'SI'),
(66, 'MOISES ALFREDO ', 'CANTUCA ', 'CLLE 40 ARANDA ', 1, '3', 'Residencial', '15131213', '1/2 PULGADA ', 'NO', 'SI'),
(67, 'AURA DEL CARMEN', 'CANTUCA', 'CLLE 40 CSA 53A ', 1, '3', 'Residencial', '15014242', '1/2 PULGADA', 'NO', 'SI'),
(68, 'ROSMIRA', 'CANTUCA BURGOS', 'CLLE 24 CSA 17 ARANDA ', 1, '3', 'Residencial', '16053078', '1/2 PULGADA ', 'NO', 'SI'),
(69, 'JESUS', 'CANTUCA BURGOS', 'CALLE 24 41B-134', 1, '3', 'Residencial', '14031497 ', '1/2 PULGADA', 'NO', 'SI'),
(70, 'OLGA LUCIA ', 'CABRERA', 'CASA 42 C1', 1, '3', 'Residencial', '15014231 ', '1/2 PULGADA', 'NO', 'SI'),
(71, 'DALILA', 'PEREZ HERNANDEZ', 'CLLE 24 # 41B-66', 1, '3', 'Residencial', '14013673 ', '1/2 PULGADA', 'NO', 'SI'),
(72, 'JOSE ROBERTO ', 'BURGOS', 'LOTE ', 1, '3', 'Residencial', '0', '1/2 PULGADA', 'NO', 'SI'),
(73, 'JOSE HERIBERTO', 'BURGOS', 'ARANDA ', 1, '3', 'Residencial', '15019695 ', '1/2 PULGADA', 'NO', 'SI'),
(74, 'LEONEL RAMIRO', 'BURGOS', 'ARANDA', 1, '3', 'Residencial', '15019684 ', '1/2 PULGADA', 'NO', 'SI'),
(75, 'ROSA ANGELICA', 'TUTISTAR', 'CALLE 24 CASA 18', 1, '3', 'Residencial', '15014221 ', '1/2 PULGADA ', 'NO', 'SI'),
(76, 'FABIO ADOLFO', 'VILLOTA', 'CARRERA 28 CASA 18', 1, '3', 'Residencial', '15131037 ', '1/2 PULGADA', 'NO', 'SI'),
(77, 'ALVARO RENE', 'VILLOTA', 'CASA 42A ', 1, '3', 'Residencial', '15016231 ', '1/2 PULGADA', 'NO', 'SI'),
(78, 'MERCEDES ', 'BURGOS', 'ARANDA ', 1, '3', 'Comercial', '15526198 ', '1/2 PULGADA', 'SI', 'SI'),
(79, 'ORFELINA', 'BURGOS', 'ARANDA ', 1, '3', 'Residencial', '14013672 ', '1/2 PULGADA', 'NO', 'SI'),
(80, 'RUFINA', 'SALAZAR', 'ARANDA ', 1, '3', 'Residencial', '15014239 ', '1/2 PULGADA', 'NO', 'SI'),
(81, 'MARGARITA', 'LOPEZ', 'CALLE 24 # 41B-134', 1, '3', 'Residencial', '14031495 ', '1/2 PULGADA', 'NO', 'SI'),
(82, 'BLANCA ', 'SALAZAR', 'CASA 41C', 1, '3', 'Residencial', '15016224 ', '1/2 PULGADA', 'NO', 'SI'),
(83, 'CARLOS LAUREANO', 'SALAZAR', 'ARANDA ', 1, '3', 'Residencial', '15014239 ', '1/2 PULGADA', 'NO', 'SI'),
(84, 'MIRIAM', 'SALAZAR', 'CASA 42B ', 1, '3', 'Residencial', '15016228 ', '1/2 PULGADA', 'NO', 'SI'),
(85, 'VIVIANA ', 'ROJAS SALAZAR', 'LOTE', 1, '3', 'Residencial', '0', '1/2 PULGADA ', 'NO', 'SI'),
(86, 'GLORIA LENIS', 'ORTEGA', 'CASA 42B', 1, '3', 'Residencial', '15131252 ', '1/2 PULGADA ', 'NO', 'SI'),
(87, 'GLORIA', 'PORTILLA', 'ARANDA ', 1, '3', 'Residencial', '14013671 ', '1/2 PULGADA', 'NO', 'SI'),
(88, 'CANCIO', 'PELAYO', 'LOTE ', 1, '4', 'Residencial', '0', '1/2 PULGADA', 'NO', 'SI'),
(89, 'MIRIAM', 'CHAVEZ CADENA', 'CASA 42C', 1, '4', 'Residencial', '15014233 ', '1/2 PULGADA ', 'SI', 'SI'),
(90, 'ISLENA DEL TRANSITO', 'DIAZ', 'ARANDA ', 1, '4', 'Residencial', '15014218 ', '1/2 PULGADA ', 'SI', 'SI'),
(91, 'GLADIS HELENA ', 'ROSERO', 'CALLE 41 # 41B-1', 1, '4', 'Residencial', '16020355 ', '1/2 PULGADA', 'SI', 'SI'),
(92, 'ANGELA MARIA ', 'ITACUAR', 'ARANDA ', 1, '4', 'Comercial', '14013677 ', '1/2 PULGADA ', 'NO', 'SI'),
(93, 'AIDA OLADIS', 'DE LA CRUZ', 'ARANDA ', 1, '4', 'Residencial', '14031490 ', '1/2 PULGADA', 'SI', 'SI'),
(94, 'ANA LUCIA ', 'MENECES', 'ARANDA ', 1, '4', 'Comercial', '14013675 ', '1/2 PULGADA', 'SI', 'SI'),
(95, 'ANA LUCIA ', 'MENECES', 'LOTE ', 1, '4', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(96, 'ANDRES ', 'PALACIOS', 'CASA 42C', 1, '4', 'Residencial', '15016223 ', '1/2 PULGADA', 'SI', 'SI'),
(97, 'IRENE ', 'ALMEIDA', 'CALLE 24 # 41B-4', 1, '4', 'Residencial', '15014235 ', '1/2 PULGADA', 'SI', 'SI'),
(98, 'AURELIO', 'BURBANO', 'ARANDA ', 1, '4', 'Residencial', '15014239 ', '1/2 PULGADA', 'SI', 'SI'),
(99, 'ADRIANA ', 'LUCANO BASTIDAS', 'CASA 42A', 1, '4', 'Residencial', '15131117 ', '1/2 PULGADA', 'SI', 'SI'),
(100, 'JOHANA', 'YACELGA BASTIDAS', 'CASA 42A ', 1, '4', 'Residencial', '15131118 ', '1/2 PULGADA', 'SI', 'SI'),
(101, 'ORLANDO', 'GUZMAN', 'CASA 42A', 1, '4', 'Residencial', '15131119 ', '1/2 PULGADA', 'SI', 'SI'),
(102, 'CLEMENCIA ', 'ROMERO', 'CASA 42A', 1, '4', 'Residencial', '4042142 ', '1/2 PULGADA', 'SI', 'SI'),
(103, 'DANIEL ENOC', 'MORA', 'ARANDA ', 1, '4', 'Residencial', '14013670 ', '1/2 PULGADA', 'SI', 'SI'),
(104, 'PORFIRIO', 'RUANO', 'CALLE 24 CASA 18 ', 1, '4', 'Residencial', '15014240 ', '1/2 PULGADA ', 'SI', 'SI'),
(105, 'JORGE ALFREDO', 'VALENCIA', 'ARANDA', 1, '4', 'Comercial', '15014220 ', '1/2 PULGADA ', 'SI', 'SI'),
(106, 'LIGIO', 'BASTIDAS', 'CALLE 24 # 41B-38 ', 1, '4', 'Residencial', '15014215 ', '1/2 PULGADA ', 'SI', 'SI'),
(107, 'GERMAN MAURICIO', 'TREJO', 'CASA 42B', 1, '4', 'Residencial', '15016235 ', '1/2 PULGADA ', 'SI', 'SI'),
(108, 'MARIA TRANSITO ', 'BASTIDAS', 'ARANDA ', 1, '4', 'Residencial', '15019686 ', '1/2 PULGADA', 'SI', 'SI'),
(109, 'MARIA LEONILA', 'DELGADO', 'CALLE 44 CASA 41B ', 1, '4', 'Residencial', '14013670 ', '1/2 PULGADA ', 'SI', 'SI'),
(110, 'LUIS ALBERTO', 'BASTIDAS', 'CRA 28 # 38-102 ', 1, '4', 'Residencial', '15014239 ', '1/2 PULGADA ', 'SI', 'SI'),
(111, 'HELENA ', 'ROSERO 2', 'ARANDA ', 1, '5', 'Residencial', '18053376 ', '1/2 PULGADA', 'SI', 'SI'),
(112, 'YENI ', 'MARTINEZ ROSERO', 'CRA 24 CASA 21', 1, '5', 'Residencial', '14013668 ', '1/2 PULGADA ', 'SI', 'SI'),
(113, 'YENI ', 'MARTINEZ ROSERO', 'ARANDA ', 1, '5', 'Residencial', '16506778 ', '1/2 PULGADA', 'SI', 'SI'),
(114, 'LUIS EDUARDO', 'ALMEIDA', 'CRA 34 # 41-191', 1, '5', 'Residencial', '14013676 ', '1/2 PULGADA', 'SI', 'SI'),
(115, 'LUIS JAVIER ', 'BASQUEZ', 'ARANDA ', 1, '5', 'Residencial', '18560601 ', '1/2 PULGADA', 'SI', 'SI'),
(116, 'LUIS ANTONIO', 'ERAZO', 'ARANDA ', 1, '5', 'Residencial', '18560603 ', '1/2 PULGADA ', 'SI', 'SI'),
(117, 'ZOILA', 'TUTALCHA', 'ARANDA ', 1, '5', 'Residencial', '18555011 ', '1/2 PULGADA', 'SI', 'SI'),
(118, 'AMPARO LORENA ', 'CHINCHAJOA', 'ARANDA ', 1, '5', 'Residencial', '15014223 ', '1/2 PULGADA ', 'SI', 'SI'),
(119, 'CLAUDIA ROBIRA ', 'JOSSA', 'CASA 21A', 1, '5', 'Residencial', '14031494 ', '1/2 PULGADA', 'SI', 'SI'),
(120, 'CLAUIDA ROBIRA ', 'JOSSA', 'CLLE 38 # 28-36', 1, '5', 'Residencial', '14013669 ', '1/2 PULGADA', 'SI', 'SI'),
(121, 'ANDRES FELIPE', 'BURBANO 3', 'CASA 15', 1, '5', 'Residencial', '71223489 ', '1/2 PULGADA', 'SI', 'SI'),
(122, 'ANDRES FELIPE', 'BURBANO 2', 'CLLE 37C # 28-44 IN ARANDA', 1, '5', 'Residencial', '14013666 ', '1/2 PULGADA', 'SI', 'SI'),
(123, 'ANDRES FELIPE ', 'BURBANO 1', 'ARANDA ', 1, '5', 'Residencial', '19584142 ', '1/2 PULGADA', 'SI', 'SI'),
(124, 'GLORIA MERCEDES', 'BASTIDAS 1', 'ARANDA ', 1, '5', 'Comercial', '14013662 ', '1/2 PULGADA ', 'SI', 'SI'),
(125, 'GLORIA MERCEDES ', 'BASTIDAS 2', 'CRA 28 # 37C-21 ', 1, '5', 'Residencial', '14013650 ', '1/2 PULGADA ', 'SI', 'SI'),
(126, 'SANDRA AURELINA', 'VILLOTA 1', 'LOTE ', 1, '5', 'Residencial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(127, 'SANDRA AURELINA', 'VILLOTA 2', 'ARANDA ', 1, '5', 'Residencial', '14031709 ', '1/2 PULGADA ', 'SI', 'SI'),
(128, 'MANUEL', 'CORTEZ', 'CRA 37C # 28-101 BRR ARANDA', 1, '5', 'Residencial', '15016213 ', '1/2 PULGADA', 'SI', 'SI'),
(129, 'MANUEL ', 'CORTEZ', 'CRA 28 # 38-57 ', 1, '5', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(130, 'YONI ESTEBAN', 'MARTINEZ', 'ARANDA ', 1, '5', 'Residencial', '15016213 ', '1/2 PULGADA ', 'SI', 'SI'),
(131, 'CATERINE ', 'BASTIDAS BARRERA', 'CASA 13 ', 1, '5', 'Residencial', '14031704 ', '1/2 PULGADA', 'SI', 'SI'),
(132, 'NILDA', 'CABRERA', 'CASA 13 ', 1, '5', 'Residencial', '15133367 ', '1/2 PULGADA', 'SI', 'SI'),
(133, 'HELENA ', 'ROSERO 1', 'CRA 24 # 2-91 ', 1, '5', 'Residencial', '15014222 ', '1/2 PULGADA', 'SI', 'SI'),
(134, 'NANCI', 'ROSERO MONTENEGRO', 'ARANDA ', 1, '5', 'Residencial', '16024875 ', '1/2 PULGADA', 'SI', 'SI'),
(135, 'EDGAR CLAUDIO', 'LOPEZ', 'ARANDA ', 1, '5', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(136, 'JOSEFINA', 'TUMAL', 'CLLE 37 # 28-90 ', 1, '5', 'Residencial', '14031701 ', '1/2 PULGADA', 'SI', 'SI'),
(137, 'JESUS ALEJANDRO', 'ROSERO', 'ARANDA ', 1, '5', 'Residencial', '14013654 ', '1/2 PULGADA', 'SI', 'SI'),
(138, 'JOSE GUILLERMO', 'HURTADO', 'ARANDA ', 1, '5', 'Residencial', '14013676 ', '1/2 PULGADA', 'SI', 'SI'),
(139, 'FAUSTO ', 'DE LA CRUZ CUSIS', 'ARANDA ', 1, '6', 'Residencial', '18570575 ', '1/2 PULGADA', 'SI', 'SI'),
(140, 'JUAN JOSE ', 'DE LA CRUZ CUSIS', 'ARANDA ', 1, '6', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(141, 'OSWALDO E', 'DE LA CRUZ CUSIS', 'ARANDA ', 1, '6', 'Residencial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(142, 'JUVENCIO ', 'DE LA CRUZ 1', 'ARANDA ', 1, '6', 'Residencial', '17039497 ', '1/2 PULGADA', 'SI', 'SI'),
(143, 'JUVENCIO ', 'DE LA CRUZ 2', 'CASA 14C', 1, '6', 'Residencial', '14013655 ', '1/2 PULGADA', 'SI', 'SI'),
(144, 'JUVENCIO', 'DE LA CRUZ 3', 'CASA 14', 1, '6', 'Residencial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(145, 'JUVENCIO', 'DE LA CRUZ 4', 'ARANDA ', 1, '6', 'Residencial', '14013662 ', '1/2 PULGADA ', 'SI', 'SI'),
(146, 'ELICENIA', 'DE LA CRUZ', 'CASA 14 ', 1, '6', 'Residencial', '14032302 ', '1/2 PULGADA ', 'SI', 'SI'),
(147, 'LINA', 'DE LA CRUZ CUSIS', 'ARANDA ', 1, '6', 'Residencial', '15131120 ', '1/2 PULGADA', 'SI', 'SI'),
(148, 'NEPTALI', 'DE LA CRUZ', 'LOTE', 1, '6', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(149, 'LIDIA ', 'CUSIS CHINCHAJOA', 'CASA 14', 1, '6', 'Residencial', '14013649 ', '1/2 PULGADA', 'SI', 'SI'),
(150, 'JORGE LIGIO', 'PAZ', 'CASA 14C', 1, '6', 'Residencial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(151, 'MODESTO', 'NUPAN', 'ARANDA ', 1, '6', 'Residencial', '14013670', '1/2 PULGADA ', 'SI', 'SI'),
(152, 'SEGUNDO', 'GUANCHA', 'ARANDA ', 1, '6', 'Residencial', '14019040', '1/2 PULGADA', 'SI', 'SI'),
(153, 'LIGIA MATILDE', 'REINA', 'ARANDA ', 1, '6', 'Residencial', '18053376', '1/02 PULGADA ', 'SI', 'SI'),
(154, 'ARNOLDO ', 'ORTEGA', 'ARANDA ', 1, '6', 'Residencial', '13011108', '1/2 PULGADA ', 'SI', 'SI'),
(155, 'MARIA CLEOFE', 'NUPAN', 'ARANDA ', 1, '6', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(156, 'NAVOR ', 'NUPAN', 'ARANDA ', 1, '6', 'Residencial', '15013265', '1/2 PULGADA ', 'SI', 'SI'),
(157, 'MARTHA MAGALI ', 'NUPAN', 'ARANDA ', 1, '6', 'Residencial', '14013662 ', '1/2 PULGADA ', 'SI', 'SI'),
(158, 'NAVOR', 'NUPAN', 'CLLE 40 # 21-256', 1, '6', 'Residencial', '15016227', '1/2 PULGADA', 'SI', 'SI'),
(159, 'AIDA ', 'NUPAN PINCHAO', 'ARANDA ', 1, '6', 'Residencial', '0155599', '1/2 PULGADA', 'SI', 'SI'),
(160, 'JANETH', 'NUPAN PINCHAO', 'CLLE 40 CSA 53A ', 1, '6', 'Residencial', '18CP89015', '1/2 PULGADA ', 'SI', 'SI'),
(161, 'MARLEN ', 'NUPAN PINCHAO', 'CASA 42B ', 1, '6', 'Residencial', '15016228 ', '1/2 PULGADA', 'SI', 'SI'),
(162, 'ROSA C', 'BUESAQUILLO', 'CRA 34 # 41-191 ', 1, '6', 'Residencial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(163, 'DIMAS GUSTAVO', 'NUPAN', 'ARANDA ', 1, '6', 'Residencial', '15014223', '1/2 PULGADA', 'SI', 'SI'),
(164, 'LUZ MARIA', 'SALAZAR', 'ARANDA ', 1, '6', 'Residencial', '13CD6904', '1/2 PULGADA ', 'SI', 'SI'),
(165, 'WILSON', 'PUPIALES', 'ARANDA ', 1, '6', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(166, 'ROMELIA', 'MESIAS REALPE', 'ARANDA', 1, '6', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(167, 'WILSON', 'BOTINA', 'CSA 13 ARANDA', 1, '6', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(168, 'BEATRIZ', 'BOTINA DE MARTINEZ', 'ARANDA ', 1, '6', 'Residencial', '14016654', '1/2 PULGADA', 'SI', 'SI'),
(169, 'NELY DEL CARMEN', 'TUMAL', 'ARANDA ', 1, '6', 'Residencial', '13011108', '1/2 PULGADA', 'SI', 'SI'),
(170, 'BERNARDO', 'QUETAMA', 'ARANDA ', 1, '6', 'Residencial', '140019046', '1/2 PULGADA', 'SI', 'SI'),
(171, 'LUIS OLMEDO ', 'DIAZ', 'ARANDA ', 1, '6', 'Residencial', '13CP70553', '1/2 PULGADA', 'SI', 'SI'),
(172, 'SEGUNDO MANUEL ', 'BUESAQUILLO', 'C 23 # 41-46 ', 1, '6', 'Residencial', '14013660', '1/2 PULGADA', 'SI', 'SI'),
(173, 'WILLIAM', 'GUZMAN', 'C 29 # 13-74 ', 1, '7', 'Residencial', '14013667', '1/2 PULGADA', 'SI', 'SI'),
(174, 'ANSELMO ', 'BURBANO', 'C41 # 23-34 ', 1, '7', 'Residencial', '15014219', '1/2 PULGADA', 'SI', 'SI'),
(175, 'IGLESIA ', 'PENTECOSTA', 'ARANDA ', 1, '7', 'Residencial', '15131111', '1/2 PULGADA ', 'SI', 'SI'),
(176, 'FIDENCIO', 'CAICEDO', 'ARANDA ', 1, '7', 'Residencial', '13CP77742', '1/2 PULGADA', 'SI', 'SI'),
(177, 'MARCELA', 'LANDAZURI', 'ARANDA ', 1, '7', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(178, 'GRACIELA', 'ROMO', 'ARANDA', 1, '7', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(179, 'SONIA', 'YELA ROMO', 'ARANDA ', 1, '7', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(180, 'MERCI YASMIN ', 'BOLAÑOS 1', 'ARANDA ', 1, '7', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(181, 'MERCI YASMIN ', 'BOLAÑOS 2', 'ARANDA ', 1, '7', 'Residencial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(182, 'MERCI YASMIN', 'BOLAÑOS 3', 'ARANDA ', 1, '7', 'Residencial', '14031439', '1/2 PULGADA ', 'SI', 'SI'),
(183, 'MERCI YASMIN', 'BOLAÑOS 4', 'LOTE ARANDA', 1, '7', 'Residencial', '0', '1/2 PULGADA', 'SI', 'SI'),
(184, 'MERCI YASMISN', 'BOLAÑOS 5', 'CLLE 28 # 37-53', 1, '7', 'Residencial', '14013658', '1/2 PULGADA', 'SI', 'SI'),
(185, 'MERCI YASMIN', 'BOLAÑOS 6', 'ARANDA ', 1, '7', 'Residencial', '17039494', '1/2 PULGADA', 'SI', 'SI'),
(186, 'NUBIA', 'ANDRADE', 'ARANDA CSA 5A', 1, '7', 'Residencial', '13CP77743', '1/2 PULGADA', 'SI', 'SI'),
(187, 'ANGEL MARIA ', 'ZAMBRANO', 'ARANDA CSA 5A', 1, '7', 'Residencial', '13CP77748', '1/2 PULGADA', 'SI', 'SI'),
(188, 'CARLOS', 'FLORES', 'ARANDA CSA 5A', 1, '7', 'Residencial', '13CP77745', '1/2 PULGADA ', 'SI', 'SI'),
(189, 'SEGUNDO ROBINSON', 'CORTEZ', 'ARANDA CSA 5A', 1, '7', 'Residencial', '13CP77774', '1/2 PULGADA', 'SI', 'SI'),
(190, 'MARIA', 'MARCILLO', 'ARANDA CSA 5A ', 1, '8', 'Residencial', '13CP77748', '1/2 PULGADA', 'SI', 'SI'),
(191, 'ANA LUCIA', 'MARCILLO ', 'ARANDA CSA 5A ', 1, '8', 'Residencial', '13CP77747', '1/2 PULGADA', 'SI', 'SI'),
(192, 'HUMBERTO ', 'JOSSA', 'ARANDA CSA 5A ', 1, '8', 'Residencial', '16020354', '1/2 PULGADA', 'SI', 'SI'),
(193, 'JESUS RICARDO ', 'PORTILLA', 'ARANDA CSA 5 ', 1, '8', 'Residencial', '13CP76170', '1/2 PULGADA', 'SI', 'SI'),
(194, 'ROSA LIA ', 'ACHICANOY ', 'ARANDA CSA 6 ', 1, '8', 'Residencial', '14013659', '1/2 PULGADA', 'SI', 'SI'),
(195, 'LUIS GERARDO', 'MARCILLO', 'CRA 34 # 57-50 ', 1, '8', 'Residencial', '13CP76170', '1/2 PULGADA', 'SI', 'SI'),
(196, 'ALVARO ALFREDO ', 'MARCILLO', 'CRA 34 # 57-50 ', 1, '8', 'Residencial', '13CP76177', '1/2 PULGADA', 'SI', 'SI'),
(197, 'FIDEL', 'TATICUAN ANACUAN', 'CRA 34 # 57-50 ', 1, '8', 'Residencial', '13CP76178', '1/2 PULGADA', 'SI', 'SI'),
(198, 'LUIS JESUS', 'ACHICANOY', 'CRA 34 # 57-50 ', 1, '8', 'Residencial', '13CP76171', '1/2 PULGADA', 'SI', 'SI'),
(199, 'RUBIELA ', 'HURTADO DE LOPEZ 1', 'CRA 34 # 37-42 ', 1, '8', 'Residencial', '1376175', '1/2 PULGADA', 'SI', 'SI'),
(200, 'RUBIELA ', 'HURTADO DE LOPEZ 2', 'CRA 34 # 37-42', 1, '8', 'Residencial', '16020712', '1/2 PULGADA', 'SI', 'SI'),
(201, 'RUBIELA ', 'HURTADO DE LOPEZ 3', 'CRA 34 # 37-42 ', 1, '8', 'Comercial', '13CP76176', '1/2 PULGADA', 'SI', 'SI'),
(202, 'RUBIELA', 'HURTADO DE LOPEZ 4', 'ARANDA CSA 5A ', 1, '8', 'Comercial', '14019042', '1/2 PULGADA ', 'SI', 'SI'),
(203, 'MARI', 'VELASQUEZ MORA', 'CLLE 27 # 40A-20', 1, '8', 'Comercial', '14019041', '1/2 PULGADA', 'SI', 'SI'),
(204, 'DEIVI', 'LARA NUPAN', 'CLLE 27 # 40A-04 ', 1, '8', 'Comercial', '14019033', '1/2 PULGADA ', 'SI', 'SI'),
(205, 'BERTHA LIGIA', 'NUPAN', 'CSA 23-18 ARANDA ', 1, '8', 'Comercial', '14019037', '1/2 PULGADA ', 'SI', 'SI'),
(206, 'MARTHA CECILIA ', 'TABLA', 'ARANDA ', 1, '8', 'Comercial', '14019040', '1/2 PULGADA', 'SI', 'SI'),
(207, 'HECTOR ', 'PUPIALES', 'ARANDA ', 1, '8', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(208, 'NANCY ', 'MARTINEZ ', 'LOTE ', 1, '8', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(209, 'OSCAR EMILIO', 'TUMAL', 'ARANDA ', 1, '8', 'Comercial', '14019036', '1/2 PULGADA', 'SI', 'SI'),
(210, 'JUAN CARLOS ', 'MARTINEZ TABLA', 'ARANDA ', 1, '8', 'Comercial', '9725986', '1/2 PULGADA', 'SI', 'SI'),
(211, 'JUAN CARLOS ', 'MARTINEZ TABLA', 'ARANDA ', 1, '8', 'Comercial', '04092144', '1/2 PULGADA', 'SI', 'SI'),
(212, 'LUIS CARLOS', 'MARTINEZ ZAMBRANO', 'ARANDA ', 1, '8', 'Comercial', '14019015', '1/2 PULGADA', 'SI', 'SI'),
(213, 'HILDE EUGENIO', 'BUESAQUILLO', 'ARANDA ', 1, '8', 'Comercial', '14019051', '1/2 PULGADA ', 'SI', 'SI'),
(214, 'HERNAN', 'PALMA 1', 'ARANDA ', 1, '9', 'Comercial', '13011110', '1/2 PULGADA', 'SI', 'SI'),
(215, 'HERNAN', 'PALMA 2', 'ARANDA ', 1, '9', 'Comercial', '14019043', '1/2 PULGADA', 'SI', 'SI'),
(216, 'HERNAN', 'PALMA 3', 'ARANDA ', 1, '9', 'Comercial', '13CP76174', '1/2 PULGADA', 'SI', 'SI'),
(217, 'ROBERTO', ' BUESAQUILLO ', 'ARANDA ', 1, '9', 'Comercial', '16006295', '1/2 PULGADA ', 'SI', 'SI'),
(218, 'SANDRA ', 'BUESAQUILLO ', 'ARANDA ', 1, '9', 'Comercial', '13CP76175', '1/2 PULGADA', 'SI', 'SI'),
(219, 'CARLOS', 'RIVERA BUESAQUILLO ', 'ARANDA ', 1, '9', 'Comercial', '14019038', '1/2 PULGADA ', 'SI', 'SI'),
(220, 'MARIELA ', 'BUESAQUILLO ', 'ARANDA ', 1, '9', 'Comercial', '14019039', '1/2 PULGADA', 'SI', 'SI'),
(221, 'MARCELA ', 'MUÑOZ BUESAQUILLO ', 'ARANDA ', 1, '9', 'Comercial', '13CP77799', '1/2 PULGADA ', 'SI', 'SI'),
(222, 'ROSARIO', 'BUESAQUILLO', 'ARANDA ', 1, '9', 'Comercial', '16024866', '1/2 PULGADA ', 'SI', 'SI'),
(223, 'BLANCA ESTELA ', 'BUESAQUILLO', 'ARANDA ', 1, '9', 'Comercial', '16020419', '1/2 PULGADA', 'SI', 'SI'),
(224, 'DORIS ', 'VIVEROS BUESAQUILLO ', 'ARANDA ', 1, '9', 'Comercial', '0173661', '1/2 PULGADA', 'SI', 'SI'),
(225, 'JOSE DEL CARMEN', 'BUESAQUILLO', 'ARANDA ', 1, '9', 'Comercial', '13CP77790', '1/2 PULGADA', 'SI', 'SI'),
(226, 'SEGUNDO B', 'MALES', 'ARANDA ', 1, '9', 'Comercial', '13CP77791', '1/2 PULGADA', 'SI', 'SI'),
(227, 'SANDRA PATRICIA ', 'MADROÑERO', 'ARANDA ', 1, '9', 'Comercial', '18062430', '1/2 PULGADA', 'SI', 'SI'),
(228, 'ROSA CLEMENCIA ', 'BUESAQUILLO', 'ARANDA ', 1, '9', 'Comercial', '13CP77792', '1/2 PULGADA', 'SI', 'SI'),
(229, 'SANDRA PATRICIA', 'MELO M', 'ARANDA ', 1, '9', 'Comercial', '07042051', '1/2 PULGADA', 'SI', 'SI'),
(230, 'MARIA CRISTINA', 'MARTINEZ ', 'ARANDA ', 1, '9', 'Comercial', '70242058', '1/2 PULGADA', 'SI', 'SI'),
(231, 'LUIS JAVIER ', 'MELO MARTINEZ', 'ARANDA ', 1, '9', 'Comercial', '13CP77749', '1/2 PULGADA', 'SI', 'SI'),
(232, 'MIGUEL ANGEL ', 'MARTINEZ', 'ARANDA ', 1, '9', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(233, 'MARIA ELVIRA ', 'GUINCHIN', 'ARANDA ', 1, '9', 'Comercial', '14013663', '1/2 PULGADA', 'SI', 'SI'),
(234, 'JHONATAN C ', 'MARTINEZ', 'ARANDA ', 1, '9', 'Comercial', '16560851', '1/2 PULGADA', 'SI', 'SI'),
(235, 'MARIA DEL TRANSITO ', 'BUESAQUILLO', 'ARANDA ', 1, '9', 'Comercial', '1401336', '1/2 PULGADA ', 'SI', 'SI'),
(236, 'MARIA DEL TRANSITO ', 'BUESAQUILLO', 'ARANDA ', 1, '9', 'Comercial', '14019019', '1/2 PULGADA', 'SI', 'SI'),
(237, 'ALFONSO RAMIRO ', 'BOTINA', 'ARANDA ', 1, '9', 'Comercial', '0118268', '1/2 PULGADA', 'SI', 'SI'),
(238, 'ALFONSO ', 'BOTINA ROSERO', 'ARANDA ', 1, '9', 'Comercial', '20CP005277', '1/2 PULGADA', 'SI', 'SI'),
(239, 'JOSE ', 'TABLAS ROSERO', 'ARANDA ', 1, '9', 'Comercial', '14019050', '1/2 PULGADA', 'SI', 'SI'),
(240, 'CARMEN AMELIA', 'PIANDA', 'ARANDA ', 1, '9', 'Comercial', '16009184', '1/2 PULGADA', 'SI', 'SI'),
(241, 'CARMEN AMELIA ', 'PIANDA', 'ARANDA ', 1, '9', 'Comercial', '14019047', '1/2 PULGADA ', 'SI', 'SI'),
(242, 'ANA ROSA ', 'BUESAQUILLO ', 'ARANDA ', 1, '9', 'Comercial', '14019045', '1/2 PULGADA ', 'SI', 'SI'),
(243, 'JUAN CARLOS ', 'BUESAQUILLO ', 'ARANDA ', 1, '9', 'Comercial', '14019044', '1/2 PULGADA ', 'SI', 'SI'),
(244, 'WILFREDO ', 'BUESAQUILLO', 'ARANDA ', 1, '9', 'Comercial', '14031703', '1/2 PULGADA', 'SI', 'SI'),
(245, 'CARLOS ALBERTO', 'BUESAQUILLO', 'ARANDA ', 1, '9', 'Comercial', '1409048', '1/2 PULGADA ', 'SI', 'SI'),
(246, 'MARIA DEL CARMEN', 'BUESAQUILLO', 'ARANDA ', 1, '9', 'Comercial', '19584126', '1/2 PULGADA ', 'SI', 'SI'),
(247, 'MARGOTH', 'VIVEROS BUESAQUILLO', 'ARANDA', 1, '9', 'Comercial', '13CP77796', '1/2 PULGADA ', 'SI', 'SI'),
(248, 'RIBIELA S', 'GORDILLO 1', 'ARANDA ', 1, '9', 'Comercial', '0154486', '1/2 PULGADA', 'SI', 'SI'),
(249, 'RUBIELA S', 'GORDILLO 2', 'ARANDA ', 1, '9', 'Comercial', '0153439', '1/2 PULGADA ', 'SI', 'SI'),
(250, 'RUBIELA S ', 'GORDILLO 3', 'ARANDA ', 1, '9', 'Comercial', '13CP77798', '1/2 PULGADA', 'SI', 'SI'),
(251, 'VICTORIA', 'RAMOS', 'C24 40-12', 1, '10', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(252, 'VICTORIA', 'RAMOS', 'KRA 24 ', 1, '10', 'Comercial', '13CP77797', '1/2 PULGADA', 'SI', 'SI'),
(253, 'RICARDO ORLANDO ', 'ROSERO', 'ARANDA ', 1, '10', 'Comercial', '14019021', '1/2 PULGADA', 'SI', 'SI'),
(254, 'ROSALBA NORI ', 'BOTINA', 'ARANDA ', 1, '10', 'Comercial', '13CP77769', '1/2 PULGADA', 'SI', 'SI'),
(255, 'JOSE GILBERTO ', 'TELLO', 'ARANDA ', 1, '10', 'Comercial', '181383', '1/2 PULGADA', 'SI', 'SI'),
(256, 'ROCIO ', 'BURBANO', 'ARANDA ', 1, '10', 'Comercial', '160500318', '1/2 PULGADA', 'SI', 'SI'),
(257, 'MONICA ', 'TELLO', 'ARANDA ', 1, '10', 'Comercial', '14019013', '1/2 PULGADA', 'SI', 'SI'),
(258, 'WILLIAM', 'SINSAJOA 1', 'ARANDA ', 1, '10', 'Comercial', '1019017', '1/2 PULGADA', 'SI', 'SI'),
(259, 'WILLIAM', 'SINSAJOA 2', 'ARANDA ', 1, '10', 'Comercial', '191783', '1/2 PULGADA', 'SI', 'SI'),
(260, 'LUZ  MARINA ', 'YANGUATIN', 'ARANDA ', 1, '10', 'Comercial', '13CP77790', '1/2 PULGADA', 'SI', 'SI'),
(261, 'LUZ MARINA ', 'YANGUATIN', 'ARANDA', 1, '10', 'Comercial', '13CP77793', '1/2 PULGADA', 'SI', 'SI'),
(262, 'LUIS ', 'YANGUATIN ROSERO', 'ARANDA ', 1, '10', 'Comercial', '20248178', '1/2 PULGADA', 'SI', 'SI'),
(263, 'SOCORRO ', 'YANGUATIN', 'CSA 8A ARANDA ', 1, '10', 'Comercial', '14013648', '1/2 PULGADA', 'SI', 'SI'),
(264, 'SOCORRO', 'YANGUATIN', 'CLLE 24 # 41-50', 1, '10', 'Comercial', '14031706', '1/2 PULGADA', 'SI', 'SI'),
(265, 'SOCORRO', 'YANGUATIN', 'ARANDA ', 1, '10', 'Comercial', '16024865', '1/2 PULGADA', 'SI', 'SI'),
(266, 'ELSON ', 'YANGUATIN 1', 'ARANDA ', 1, '10', 'Comercial', '14013657', '1/2 PULGADA', 'SI', 'SI'),
(267, 'ELSON', 'YANGUATIN 2', 'CSA 12 ARANDA ', 1, '10', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(268, 'ELSON', 'YANGUATIN 3', 'CSA 12 ARANDA ', 1, '10', 'Comercial', '14032301', '1/2 PULGADA', 'SI', 'SI'),
(269, 'LUCIO', 'NUPAN', 'ARANDA ', 1, '10', 'Comercial', '14032297', '1/2 PULGADA', 'SI', 'SI'),
(270, 'LUCIO', 'NUPAN', 'CRA 27 37-15', 1, '10', 'Comercial', '14013656', '1/2 PULGADA', 'SI', 'SI'),
(271, 'LUCIO', 'NUPAN', 'CLLE 41 A 29-52 ', 1, '10', 'Comercial', '09142705', '1/2 PULGADA', 'SI', 'SI'),
(272, 'LEIDER HERNANDO ', 'VALLEJO', 'CRA 27 # 37-13', 1, '10', 'Comercial', '21005927', '1/2 PULGADA', 'SI', 'SI'),
(273, 'ANDER', 'REYES', 'CLLE 41# 26-28 ', 1, '10', 'Comercial', '14013653', '1/2 PULGADA', 'SI', 'SI'),
(274, 'ABELARDO ', 'PERES ASCUNTAR', 'CLLE 41 # 26-28 ', 1, '10', 'Comercial', '14013652', '1/2 PULGADA', 'SI', 'SI'),
(275, 'OSCAR ', 'VALLEJO', 'CSA 9 # 132 ', 1, '11', 'Comercial', '14031298', '1/2 PULGADA ', 'SI', 'SI'),
(276, 'FABIO LAURENTINO', 'MADROÑERO', 'CSA 9 ARANDA ', 1, '11', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(277, 'FABIO LAURENTINO', 'MADROÑERO', 'LOTE', 1, '11', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(278, 'ANDRES ', 'ABAHONZA', 'ARANDA ', 1, '11', 'Comercial', '14031705', '1/2 PULGADA', 'SI', 'SI'),
(279, 'NANCY', 'DE LA CRUZ', 'CRA 41A # 29-82', 1, '11', 'Comercial', '14032303', '1/2 PULGADA ', 'SI', 'SI'),
(280, 'WILTON', 'ABAHONZA', 'CRA 41A # 29-82 ', 1, '11', 'Comercial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(281, 'MARINO', 'ABAHONZA', 'ARANDA ', 1, '11', 'Comercial', '14032296', '1/2 PULGADA ', 'SI', 'SI'),
(282, 'DERLI AMPARO', 'CUSIS 1', 'CLLE 41A # 29A-82 ', 1, '11', 'Comercial', '14013664', '1/2 PULGADA ', 'SI', 'SI'),
(283, 'DERLI AMPARO ', 'CUSIS 2', 'CLLE 41A # 29-82 ', 1, '11', 'Comercial', '14013651', '1/2 PULGADA ', 'SI', 'SI'),
(284, 'NOHORA ', 'CUSIS YANGUATIN', 'LOTE ', 1, '11', 'Comercial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(285, 'SULMA LIZETH ', 'CUSIS', 'LOTE ', 1, '11', 'Comercial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(286, 'JORGE JAVIER', 'CUSIS', 'ARANDA ', 1, '11', 'Comercial', '0173556', '1/2 PULGADA ', 'SI', 'SI'),
(287, 'JOSE FELIX', 'TABLA 1', 'CSA 41 # 40', 1, '11', 'Comercial', '14032604', '1/2 PULGADA ', 'SI', 'SI'),
(288, 'JOSE FELIZ ', 'TABLA 2', 'CSA 5 ARANDA ', 1, '11', 'Comercial', '162003', '1/2 PULGADA ', 'SI', 'SI'),
(289, 'ISABEL', 'BOTINA', 'CSA 20C ARANDA ', 1, '11', 'Comercial', '14013665', '1/2 PULGADA ', 'SI', 'SI'),
(300, 'JAIME HERNAN', 'GUERRERO', 'CRA 28 # 37C-38 ', 1, '11', 'Comercial', '16070412', '1/2 PULGADA ', 'SI', 'SI'),
(301, 'LUZ ', 'CHICHAJOA BOTINA', 'ARANDA ', 1, '11', 'Comercial', '14031708', '1/2 PULGADA ', 'SI', 'SI'),
(302, 'GILBERTO', 'LEON', 'CLLE 38A # 29C-33', 1, '11', 'Comercial', '14068986', '1/2 PULGADA ', 'SI', 'SI'),
(303, 'CLEMENCIA', 'CHINCHAJOA', 'CLLE 38A # 36C-31 ', 1, '11', 'Comercial', '15014216', '1/2 PULGADA ', 'SI', 'SI'),
(304, 'ANA MILENA ', 'CUASQUER', 'CLLE 38A # 36C-31 ', 1, '12', 'Comercial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(305, 'JULIO', 'CUASQUER', 'CSA 38A # 27F-21', 1, '12', 'Comercial', '15014232', '1/2 PULGADA ', 'SI', 'SI'),
(306, 'NELSON ENRIQUE', 'DIAZ', 'CSA 38A # 27F-21 ', 1, '12', 'Comercial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(307, 'ROLANDO', 'CHINCHAJOA', 'CRA 45 # 25-86 ', 1, '12', 'Comercial', '4031498', '1/2 PULGADA ', 'SI', 'SI'),
(308, 'SARA', 'TUMAL PESILLO', 'CLLE 38D # 32C-03 ', 1, '12', 'Comercial', '14031499', '1/2 PULGADA ', 'SI', 'SI'),
(309, 'ANDRES ', 'TUMAL PESILLO', 'CSA 24A ', 1, '12', 'Comercial', '15014217', '1/2 PULGADA', 'SI', 'SI'),
(310, 'ROSA MARIA ', 'PESILLO', 'ARANDA ', 1, '12', 'Comercial', '1402013', '1/2 PULGADA ', 'SI', 'SI'),
(311, 'MARGARITA ', 'TUMAL PESILLO', 'ARANDA ', 1, '12', 'Comercial', '16048609', '1/2 PULGADA ', 'SI', 'SI'),
(312, 'JESUS ORLANDO', 'PUPIALES', 'CSA 9B ', 1, '12', 'Comercial', '14031496', '1/2 PULGADA ', 'SI', 'SI'),
(313, 'ROSA', 'TUMAL', 'CLLE 38A # 27C-07 ', 1, '12', 'Comercial', '14031491', '1/2 PULGADA ', 'SI', 'SI'),
(314, 'LUIS ALEJANDRO', 'TUMAL', 'CSA 9B ', 1, '12', 'Comercial', '14031492', '1/2 PULGADA ', 'SI', 'SI'),
(315, 'MARIBEL', 'TUMAL', 'ARANDA ', 1, '12', 'Comercial', '14031707', '1/2 PULGADA ', 'SI', 'SI'),
(316, 'OSCAR ', 'VILLOTA 1', 'ARANDA ', 1, '12', 'Comercial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(317, 'OSCAR ', 'VILLOTA 2', 'ARANDA ', 1, '12', 'Comercial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(318, 'JOSE ANTONIO', 'CHAVEZ', 'ARANDA ', 1, '12', 'Comercial', '16008189', '1/2 PULGADA', 'SI', 'SI'),
(319, 'ROMULO', 'CONSTAIN', 'ARANDA ', 1, '12', 'Comercial', '14032300', '1/2 PULGADA ', 'SI', 'SI'),
(320, 'SANDRA', 'TUMAL', 'CLLE 38A # 28E-06', 1, '12', 'Comercial', '15014224', '1/2 PULGADA ', 'SI', 'SI'),
(321, 'GENARO', 'CUASQUER', 'CSA 38A # 27B-14 ', 1, '12', 'Comercial', '14020309', '1/2 PULGADA ', 'SI', 'SI'),
(322, 'DORIS ', 'CUASQUER', 'CSA 38A # 27-14 ', 1, '12', 'Comercial', '13CP56849', '1/2 PULGADA ', 'SI', 'SI'),
(323, 'CRUZ', 'CUASQUER', 'CLLE 28 # 27B-24 ', 1, '12', 'Comercial', '14020451', '1/2 PULGADA ', 'SI', 'SI'),
(324, 'SANDRA MARLENI', 'LEON', 'CLLE 28 # 27B-24 ', 1, '13', 'Comercial', '14068904', '1/2 PULGADA ', 'SI', 'SI'),
(325, 'MARIA EUGENIA ', 'HIGIDIO', 'CLLE 28 # 27B-24 ', 1, '13', 'Comercial', '14068568', '1/2 PULGADA ', 'SI', 'SI'),
(326, 'ADRIANA ', 'MARTINEZ B', 'ARANDA ', 1, '13', 'Comercial', '14031702', '1/2 PULGADA ', 'SI', 'SI'),
(327, 'JIMENA ', 'BURBANO CH', 'CLLE 26 # 41-25 ', 1, '13', 'Comercial', '15016229', '1/2 PULGADA ', 'SI', 'SI'),
(328, 'ARNULFO', 'BURBANO', 'CLLE 39 # 32E-29 ', 1, '13', 'Comercial', '20248174', '1/2 PULGADA ', 'SI', 'SI'),
(329, 'ESPERANZA ', 'GUANCHA', 'ARANDA ', 1, '13', 'Comercial', '071221831', '1/2 PULGADA ', 'SI', 'SI'),
(330, 'JOSE GEOVANNI', 'GUANCHA 1', 'CRA 27B # 38A-19 ', 1, '13', 'Comercial', '071223440', '1/2 PULGADA ', 'SI', 'SI'),
(331, 'JOSE GEOVANNI', 'GUANCHA 2', 'ARANDA ', 1, '13', 'Comercial', '15012847', '1/2 PULGADA', 'SI', 'SI'),
(332, 'GLORIA ISABEL ', 'SALAZAR 1', 'CRA 24 # 41B-28 ', 1, '13', 'Comercial', '0153600', '1/2 PULGADA ', 'SI', 'SI'),
(333, 'GLORIA ISABEL', 'SALAZAR 2', 'ARANDA ', 1, '13', 'Comercial', '14068963', '1/2 PULGADA ', 'SI', 'SI'),
(334, 'HERMES OLIVO', 'CHACHINOY', 'ARANDA ', 1, '13', 'Comercial', '15133380', '1/2 PULGADA ', 'SI', 'SI'),
(335, 'ESTELA ', 'VASQUEZ', 'ARANDA ', 1, '13', 'Comercial', '19224101', '1/2 PULGADA ', 'SI', 'SI'),
(336, 'ILARIO', 'OBANDO', 'ARANDA', 1, '13', 'Comercial', '15012806', '1/2 PULGADA', 'SI', 'SI'),
(337, 'FREDI ILARIO', 'OBANDO 1', 'ARANDA ', 1, '13', 'Comercial', '15012867', '1/2 PULGADA', 'SI', 'SI'),
(338, 'FREDI ILARIO', 'OBANDO 2', 'ARANDA ', 1, '13', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(339, 'FLOR ALBA ', 'CHAVEZ', 'ARANDA ', 1, '13', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(340, 'ANA MILENA ', 'ADARME', 'CASA 25', 1, '13', 'Comercial', '15012876', '1/2 PULGADA', 'SI', 'SI'),
(341, 'BAYARDO', 'CUSIS', 'KRA 27 F 38A 102', 1, '13', 'Comercial', '15012848', '1/2 PULGADA', 'SI', 'SI'),
(342, 'MERARIO', 'MENA 1', 'C26 41B 116', 1, '13', 'Comercial', '15012851', '1/2 PULGADA', 'SI', 'SI'),
(343, ' MERARIO', 'MENA 2', 'CASA 16', 1, '13', 'Comercial', '15012845', '1/2 PULGADA', 'SI', 'SI'),
(344, 'MERARIO ', 'MENA 3', 'KRA 37 B 37-51', 1, '13', 'Comercial', '15012854', '1/2 PULGADA', 'SI', 'SI'),
(345, 'SANDRA MILENA ', 'ACOSTA', 'ARANDA ', 1, '13', 'Comercial', '15012850', '1/2 PULGADA ', 'SI', 'SI'),
(346, 'MARIA MERCEDES ', 'LOPEZ', 'ARANDA ', 1, '13', 'Comercial', '15011582', '1/2 PULGADA', 'SI', 'SI'),
(347, 'GEOVANNI ', 'CHINCHAJOA', 'ARANDA ', 1, '14', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(348, 'HERNANDO', 'GUERRERO', 'ARANDA ', 1, '14', 'Comercial', '15012853', '1/2 PULGADA', 'SI', 'SI'),
(349, 'LUIS ', 'MARTINEZ', 'CSA 39B # 21B-23 ', 1, '14', 'Comercial', '15012852', '1/2 PULGADA', 'SI', 'SI'),
(350, 'SAMIR', 'PANTOJA 1', 'CRA 39 # 32A-15 ', 1, '14', 'Comercial', '15011597', '1/2 PULGADA', 'SI', 'SI'),
(351, 'SAMIR ', 'PANTOJA 2', 'ARANDA ', 1, '14', 'Comercial', '15012849', '1/2 PULGADA', 'SI', 'SI'),
(352, 'SAMIR ', 'PANTOJA 3', 'ARANDA ', 1, '14', 'Comercial', '15012847', '1/2 PULGADA', 'SI', 'SI'),
(353, 'AMANDA L ', 'CHINCHAJOA', 'ARANDA ', 1, '14', 'Comercial', '15012846', '1/2 PULGADA', 'SI', 'SI'),
(354, 'WILLINTON', 'OBANDO', 'ARANDA ', 1, '14', 'Comercial', '21322340', '1/2 PULGADA', 'SI', 'SI'),
(355, 'JOSE ', 'CERON', 'ARANDA ', 1, '14', 'Comercial', '16010593', '1/2 PULGADA', 'SI', 'SI'),
(356, 'MARCELA ', 'PORTILLA', 'CRA 27D # 38B-72 ', 1, '14', 'Comercial', '20056531', '1/2 PULGADA', 'SI', 'SI'),
(357, 'GEOVANNI ', 'CHINCHAJOA', 'CRA 27 # 38B-72 ', 1, '14', 'Comercial', '20256532', '1/2 PULGADA', 'SI', 'SI'),
(358, 'HERNANDO', 'GUERRERO', 'CRA 27 # 38B-72 ', 1, '14', 'Comercial', '29178383', '1/2 PULGADA', 'SI', 'SI'),
(359, 'ANGELA KAROL', 'HENAO', 'CRA 27 # 38B-72', 1, '14', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(360, 'LUZ ', 'CHINCHAJOA BURBANO', 'ARANDA ', 1, '14', 'Comercial', '15131032', '1/2 PULGADA', 'SI', 'SI'),
(361, 'LUZ ', 'CHINCHAJOA BURBANO', 'CRA 44 # 28-22 ', 1, '14', 'Comercial', '15131039', '1/2 PULGADA', 'SI', 'SI'),
(362, 'CARLOS ', 'DIMAS PEÑA', 'ARANDA ', 1, '14', 'Comercial', '15131251', '1/2 PULGADA', 'SI', 'SI'),
(363, 'TULIO', 'LEON', 'LOTE ', 1, '15', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(364, 'MAGOLA ', 'DIAZ DE LEON', 'ARANDA ', 1, '15', 'Comercial', '15131038', '1/2 PULGADA', 'SI', 'SI'),
(365, 'MAGOLA', 'DIAZ', 'ARANDA ', 1, '15', 'Comercial', '15131036', '1/2 PULGADA', 'SI', 'SI'),
(366, 'GILBERTO', 'LEON', 'ARANDA ', 1, '15', 'Comercial', '18049718', '1/2 PULGADA', 'SI', 'SI'),
(367, 'GRACIELA ', 'LEON', 'ARANDA ', 1, '15', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(368, 'SILVIO', 'LEON', 'CRA 44 # 24-14 ', 1, '15', 'Comercial', '15131040', '1/2 PULGADA', 'SI', 'SI'),
(369, 'JHON JAIRO', 'MARTINEZ', 'CRA 44 # 24-14 ', 1, '15', 'Comercial', '15131034', '1/2 PULGADA', 'SI', 'SI'),
(370, 'JUAN JOSE ', 'MARTINEZ', 'LOTE', 1, '15', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(371, 'TEREZA', 'MARTINEZ', 'ARANDA ', 1, '15', 'Comercial', '15131031', '1/2 PULGADA', 'SI', 'SI'),
(372, 'JAIME ', 'DELGADO MARTINEZ', 'ARANDA ', 1, '15', 'Comercial', '15131212', '1/2 PULGADA', 'SI', 'SI'),
(373, 'AIDA DEL SOCORRO', 'MARTINEZ', 'ARANDA ', 1, '15', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(374, 'AIDA DEL SOCORRO', 'MARTINEZ', 'ARANDA ', 1, '15', 'Comercial', '15131035', '1/2 PULGADA', 'SI', 'SI'),
(375, 'INES ', 'MARTINEZ', 'ARANDA ', 1, '15', 'Comercial', '16009185', '1/2 PULGADA', 'SI', 'SI'),
(376, 'VICENTE ', 'LEON', 'ARANDA ', 1, '15', 'Comercial', '15131033', '1/2 PULGADA', 'SI', 'SI'),
(377, 'BENIGNO', 'DE LA CRUZ', 'ARANDA ', 1, '15', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(378, 'VICENTE ', 'ALBEAR MARTINEZ', 'ARANDA ', 1, '15', 'Comercial', '19188370', '1/2 PULGADA', 'SI', 'SI'),
(379, 'CARMELO ', 'MARTINEZ', 'ARANDA ', 1, '15', 'Comercial', '15014227', '1/2 PULGADA', 'SI', 'SI'),
(380, 'PATRICIA ', 'MARTINEZ 1', 'ARANDA ', 1, '15', 'Comercial', '071218083', '1/2 PULGADA', 'SI', 'SI'),
(381, 'PATRICIA ', 'MARTINEZ 2', 'ARANDA ', 1, '15', 'Comercial', '15131140', '1/2 PULGADA', 'SI', 'SI'),
(382, 'PATRICIA ', 'MARTINEZ 3', 'ARANDA ', 1, '15', 'Comercial', '15131206', '1/2 PULGADA', 'SI', 'SI'),
(383, 'FERNANDO ', 'LEON', 'ARANDA ', 1, '15', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(384, 'LEIDI', 'DE LA CRUZ', 'LOTE ', 1, '15', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(385, 'ODILA', 'RIVERA', 'ARANDA ', 1, '15', 'Comercial', '15131257', '1/2 PULGADA', 'SI', 'SI'),
(386, 'ODILA', 'RIVERA', 'ARANDA ', 1, '15', 'Comercial', '14068972', '1/2 PULGADA', 'SI', 'SI'),
(387, 'JANETH', 'VIVAS', 'ARANDA ', 1, '15', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(388, 'FLORA ', 'TUMAL', 'ARANDA ', 1, '15', 'Comercial', '10068981', '1/2 PULGADA', 'SI', 'SI'),
(389, 'EMILIANO', 'PUPIALES', 'ARANDA ', 1, '15', 'Comercial', '14068982', '1/2 PULGADA', 'SI', 'SI'),
(390, 'ROSA DEL C', 'NAUSIL', 'ARANDA ', 1, '15', 'Comercial', '071218093', '1/2 PULGADA', 'SI', 'SI'),
(391, 'ROSAURA ', 'GUERRERO DEL CH', 'ARANDA ', 1, '16', 'Comercial', '10068405', '1/2 PULGADA', 'SI', 'SI'),
(392, 'CARMEN EDILIA ', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(393, 'MAURICIO', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(394, 'HERNAN', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '15011584', '1/2 PULGADA', 'SI', 'SI'),
(395, 'HECTOR ', 'QUITIAQUEZ 1', 'ARANDA ', 1, '16', 'Comercial', '15015580', '1/2 PULGADA', 'SI', 'SI'),
(396, 'HECTOR ', 'QUITIAQUEZ 2', 'ARANDA ', 1, '16', 'Comercial', '15019693', '1/2 PULGADA', 'SI', 'SI'),
(397, 'WILLINTON ', 'MUÑOZ', 'ARANDA ', 1, '16', 'Comercial', '15011577', '1/2 PULGADA', 'SI', 'SI'),
(398, 'LEONOR', 'POTOSI', 'ARANDA ', 1, '16', 'Comercial', '15051576', '1/2 PULGADA', 'SI', 'SI'),
(399, 'LORENZO', 'CHINCHAJOA', 'CLLE 40 # 27A-07', 1, '16', 'Comercial', '15133399', '1/2 PULGADA', 'SI', 'SI'),
(400, 'LORENZO', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '15131116', '1/2 PULGADA', 'SI', 'SI'),
(401, 'MODESTO', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '15011583', '1/2 PULGADA', 'SI', 'SI'),
(402, 'LUZ ESMERALDA', 'CONTRERAS', 'CRA 27 # 39B-25', 1, '16', 'Comercial', '12028984', '1/2 PULGADA', 'SI', 'SI'),
(403, 'JOSE ', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '15133778', '1/2 PULGADA', 'SI', 'SI'),
(404, 'FRANKLIN', 'BURBANO', 'ARANDA ', 1, '16', 'Comercial', '15016234', '1/2 PULGADA', 'SI', 'SI'),
(405, 'ISABEL', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '171783', '1/2 PULGADA', 'SI', 'SI'),
(406, 'ROSA', 'BENAVIDES', 'ARANDA ', 1, '16', 'Comercial', '321322554', '1/2 PULGADA', 'SI', 'SI'),
(407, 'SOCORRO ', 'BENAVIDES', 'ARANDA ', 1, '16', 'Comercial', '0136200', '1/2 PULGADA', 'SI', 'SI'),
(408, 'ALBERTO ', 'BENAVIDES', 'ARANDA ', 1, '16', 'Comercial', '15012873', '1/2 PULGADA', 'SI', 'SI'),
(409, 'HELENA ', 'GUERRERO', 'ARANDA ', 1, '16', 'Comercial', '15012865', '1/2 PULGADA', 'SI', 'SI'),
(410, 'SALON ', 'COMUNAL', 'ARANDA ', 1, '16', 'Comercial', '15012874', '1/2 PULGADA', 'SI', 'SI'),
(411, 'LUIS ', 'DELGADO CH', 'ARANDA ', 1, '16', 'Comercial', '15011364', '1/2 PULGADA', 'SI', 'SI'),
(412, 'JUAN', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '0016467', '1/2 PULGADA', 'SI', 'SI'),
(413, 'FREDISULINDA', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '15012871', '1/2 PULGADA', 'SI', 'SI'),
(414, 'IRMA LILIANA', 'CUSIS', 'ARANDA ', 1, '16', 'Comercial', '14008987', '1/2 PULGADA', 'SI', 'SI'),
(415, 'RAUL', 'CUSIS', 'ARANDA ', 1, '16', 'Comercial', '16010853', '1/2 PULGADA', 'SI', 'SI'),
(416, 'TRINIDAD', 'CUSIS', 'ARANDA ', 1, '16', 'Comercial', '15011575', '1/2 PULGADA', 'SI', 'SI'),
(417, 'BERTHA', 'VALLEJO', 'ARANDA ', 1, '16', 'Comercial', '15011581', '1/2 PULGADA', 'SI', 'SI'),
(418, 'GUILLERMO ', 'AYALA', 'ARANDA ', 1, '16', 'Comercial', '15011579', '1/2 PULGADA', 'SI', 'SI'),
(419, 'ALICIA', 'GUERRERO', 'ARANDA ', 1, '16', 'Comercial', '15011578', '1/2 PULGADA', 'SI', 'SI'),
(420, 'MARTHA ', 'GOMAJOA', 'ARANDA ', 1, '16', 'Comercial', '15011558', '1/2 PULGADA', 'SI', 'SI'),
(421, 'RITHA ', 'ROSERO', 'ARANDA ', 1, '16', 'Comercial', '20256860', '1/2 PULGADA', 'SI', 'SI'),
(422, 'FIDENCIO', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '15011562', '1/2 PULGADA', 'SI', 'SI'),
(423, 'ANA LUCIA', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '15011863', '1/2 PULGADA', 'SI', 'SI'),
(424, 'SIQUIFREDO', 'GUTIERREZ', 'ARANDA ', 1, '16', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(425, 'SOCORRO', 'NUPAN', 'ARANDA ', 1, '16', 'Comercial', '15011560', '1/2 PULGADA', 'SI', 'SI'),
(426, 'LUIS HERNANDO', 'ORTEGA', 'ARANDA ', 1, '16', 'Comercial', '15010196', '1/2 PULGADA', 'SI', 'SI'),
(427, 'MARIA EUGENIA', 'RODRIGUEZ', 'ARANDA ', 1, '16', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(428, 'EDGAR ', 'CUSIS MARTINEZ', 'ARANDA ', 1, '16', 'Comercial', '15016238', '1/2 PULGADA', 'SI', 'SI'),
(429, 'LUIS GONZALO', 'IGUA', 'ARANDA ', 1, '16', 'Comercial', '15016240', '1/2 PULGADA', 'SI', 'SI'),
(430, 'MARIA LEOPOLDINA', 'LAGOS', 'ARANDA ', 1, '16', 'Comercial', '15016241', '1/2 PULGADA', 'SI', 'SI'),
(431, 'ESTER', 'NUPAN CH', 'ARANDA ', 1, '16', 'Comercial', '15016237', '1/2 PULGADA', 'SI', 'SI'),
(432, 'YENI LORENA', 'DAVID', 'ARANDA ', 1, '16', 'Comercial', '15016242', '1/2 PULGADA', 'SI', 'SI'),
(433, 'ANA MILENA', 'GONZALES', 'ARANDA ', 1, '16', 'Comercial', '1800728', '1/2 PULGADA', 'SI', 'SI'),
(434, 'YINET CATERINE', 'ORDOÑEZ', 'ARANDA ', 1, '16', 'Comercial', '15010598', '1/2 PULGADA', 'SI', 'SI'),
(435, 'MARIA', 'CHINCHAJOA BURBANO', 'ARANDA ', 1, '16', 'Comercial', '15010597', '1/2 PULGADA', 'SI', 'SI'),
(436, 'OMAR ', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '15010596', '1/2 PULGADA', 'SI', 'SI'),
(437, 'OMAR', 'CHINCHAJOA', 'ARANDA ', 1, '16', 'Comercial', '15016279', '1/2 PULGADA', 'SI', 'SI'),
(438, 'AURA ', 'NUPAN', 'ARANDA ', 1, '17', 'Comercial', '15016236', '1/2 PULGADA', 'SI', 'SI'),
(439, 'MARIA ISABEL', 'IRQUA', 'ARANDA ', 1, '17', 'Comercial', '15017561', '1/2 PULGADA', 'SI', 'SI'),
(440, 'LUIS ', 'CHINCHAJOA BURBANO', 'ARANDA ', 1, '17', 'Comercial', '15011559', '1/2 PULGADA', 'SI', 'SI'),
(441, 'LUIS ', 'CHINCHAJOA BURBANO', 'ARANDA ', 1, '17', 'Comercial', '1191783', '1/2 PULGADA', 'SI', 'SI'),
(442, 'MARIA DEL CARMEN', 'ROMERO', 'ARANDA ', 1, '17', 'Comercial', '15011155', '1/2 PULGADA', 'SI', 'SI'),
(443, 'EDILMA ', 'CHINCHAJOA 1', 'ARANDA ', 1, '17', 'Comercial', '15131112', '1/2 PULGADA', 'SI', 'SI'),
(444, 'EDILMA', 'CHINCHAJOA 2', 'ARANDA ', 1, '17', 'Comercial', '15131113', '1/2 PULGADA', 'SI', 'SI'),
(445, 'EDGAR', 'CASTRO 1', 'ARANDA ', 1, '17', 'Comercial', '0118628', '1/2 PULGADA', 'SI', 'SI'),
(446, 'EDGAR', 'CASTRO 2', 'ARANDA ', 1, '17', 'Comercial', '071216523', '1/2 PULGADA', 'SI', 'SI'),
(447, 'EDGAR ', 'CASTRO 3', 'ARANDA ', 1, '17', 'Comercial', '15131114', '1/2 PULGADA', 'SI', 'SI'),
(448, 'EDGAR ', 'CASTRO 4', 'ARANDA ', 1, '17', 'Comercial', '15131115', '1/2 PULGADA', 'SI', 'SI'),
(449, 'DEFIN ', 'GUERRERO', 'ARANDA ', 1, '17', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(450, 'ANA PASTORA ', 'GUERRERO', 'ARANDA', 1, '17', 'Comercial', '16020711', '1/2 PULGADA', 'SI', 'SI'),
(451, 'ROSARIO', 'GUERRERO', 'CRA 40 ARANDA', 1, '17', 'Comercial', '13CP70565', '1/2 PULGADA', 'SI', 'SI'),
(452, 'LUCEIDA ', 'GUERRERO', 'CASA 47 ARANDA', 1, '17', 'Comercial', '15010593', '1/2 PULGADA', 'SI', 'SI'),
(453, 'OMRY', 'CHINCHAJOA ', 'CSA 49A ARANDA ', 1, '17', 'Comercial', '15014226', '1/2 PULGADA', 'SI', 'SI'),
(454, 'OMRY', 'CHINCHAJOA', 'ARANDA', 1, '17', 'Comercial', '15131258', '1/2 PULGADA ', 'SI', 'SI'),
(455, 'JORGE A', 'CUASQUER', 'CLLE 40 ARANDA ', 1, '17', 'Comercial', '14020348', '1/2 PULGADA', 'SI', 'SI'),
(456, 'ERMERITA', 'CUASQUER', 'CLLE 41 # 29-52 ', 1, '17', 'Comercial', '14032305', '1/2 PULGADA ', 'SI', 'SI'),
(457, 'FLORENTINO', 'CHINCHAJOA', 'ARANDA ', 1, '17', 'Comercial', '1564925', '1/2 PULGADA', 'SI', 'SI'),
(458, 'LUIS ', 'GUTIERRES', 'CSA 16 ARANDA ', 1, '17', 'Comercial', '15131132', '1/2 PULGADA', 'SI', 'SI'),
(459, 'CLEMENCIA', 'CUSIS', 'CALLE 24 CASA 18 ', 1, '17', 'Comercial', '15133376 ', '1/2 PULGADA ', 'SI', 'SI'),
(460, 'CARLOS', 'CUASQUER', 'CSA 15 ARANDA ', 1, '17', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(461, 'MARIA AMELIA', 'BOTINA', 'ARANDA ', 1, '17', 'Comercial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(462, 'MARIA AMELIA ', 'BOTINA', 'ARANDA ', 1, '17', 'Comercial', '16017475', '1/2 PULGADA ', 'SI', 'SI'),
(463, 'PEDRO ', 'BOTINA', 'ARANDA ', 1, '17', 'Comercial', '15016228', '1/2 PULGADA ', 'SI', 'SI'),
(464, 'CLEMENCIA', 'NUPAN ', 'CLL 24 # 41-034', 1, '17', 'Comercial', '14031490', '1/2 PULGADA', 'SI', 'SI'),
(465, 'CARLOS ', 'VELASQUEZ', 'CLL 26 38-A', 1, '17', 'Comercial', '15014240', '1/2 PULGADA', 'SI', 'SI'),
(466, 'LUIS ANIBAL', 'ARMERO', 'ARANDA ', 1, '17', 'Comercial', '0', '1/2 PULGADA ', 'SI', 'SI'),
(467, 'MIRIAM', 'CABRERA URBANO', 'CRA 27 # 37-05', 1, '17', 'Comercial', '13CP77740', '1/2 PULGADA', 'SI', 'SI'),
(468, 'SILVIO', 'TONGUINO 1', 'ARANDA ', 1, '17', 'Comercial', '14013674', '1/2 PULGADA', 'SI', 'SI'),
(469, 'SILVIO', 'TONGUINO 2', 'CRA 28 # 34-24', 1, '17', 'Comercial', '031223497', '1/2 PULGADA', 'SI', 'SI'),
(470, 'ERWIN', 'NUPAN', 'CRA 28 # 35-26 ', 1, '17', 'Comercial', '14066795', '1/2 PULGADA', 'SI', 'SI'),
(471, 'LORENA', 'NUPAN', 'CRA 28 ', 1, '17', 'Comercial', '0137286', '1/2 PULGADA', 'SI', 'SI'),
(472, 'NORMA PATRICIA', 'NUPAN', 'CRA 28 # 34-34 ', 1, '17', 'Comercial', '14019020', '1/2 PULGADA', 'SI', 'SI'),
(473, 'ENRRIQUE ', 'NUPAN', 'CRA 28 # 34-34 ', 1, '17', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(474, 'ROMAN', 'NUPAN', 'CRA 28 ', 1, '17', 'Comercial', '14019035', '1/2 PULGADA', 'SI', 'SI'),
(475, 'JORGE', 'NUPAN', 'CRA 28 ARANDA ', 1, '17', 'Comercial', '0', '1/2 PULGADA', 'SI', 'SI'),
(476, 'PATRICIA ', 'BIRBICUR', 'ARANDA ', 1, '17', 'Comercial', '20256864', '1/2 PULGADA', 'SI', 'SI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deudores`
--

CREATE TABLE `deudores` (
  `cod_cliente` int(11) NOT NULL,
  `valor_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `deudores`
--

INSERT INTO `deudores` (`cod_cliente`, `valor_total`) VALUES
(1, 70000),
(200, 50500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `cod_factura` int(11) NOT NULL,
  `cod_cliente` int(11) NOT NULL,
  `fecha_inicio_cobro` date NOT NULL,
  `fecha_fin_cobro` date NOT NULL,
  `mes_cobrado` varchar(20) NOT NULL,
  `lectura_inicial` int(11) NOT NULL,
  `lectura_final` int(11) NOT NULL,
  `consumo_m3` int(11) NOT NULL,
  `valor_total` int(11) NOT NULL,
  `valor_consumo` int(11) NOT NULL,
  `valor_basico` int(11) NOT NULL,
  `valor_deuda` int(11) NOT NULL,
  `valor_ultima_factura` int(11) NOT NULL,
  `Anotaciones` varchar(200) NOT NULL,
  `estado_pago` varchar(20) NOT NULL,
  `fecha_limite_pago` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`cod_factura`, `cod_cliente`, `fecha_inicio_cobro`, `fecha_fin_cobro`, `mes_cobrado`, `lectura_inicial`, `lectura_final`, `consumo_m3`, `valor_total`, `valor_consumo`, `valor_basico`, `valor_deuda`, `valor_ultima_factura`, `Anotaciones`, `estado_pago`, `fecha_limite_pago`) VALUES
(1, 1, '2024-06-20', '2024-07-20', 'JULIO', 1000, 1010, 10, 15500, 11500, 4000, 0, 20000, '', 'NO', '2024-07-28'),
(10, 3, '2024-06-20', '2024-07-20', 'JUNIO', 2000, 2000, 0, 4000, 0, 4000, 0, 4000, '', 'NO', '2024-07-28'),
(12, 6, '2024-06-20', '2024-07-20', 'JULIO', 0, 0, 0, 0, 0, 4000, 0, 0, '', 'NO', '2024-07-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`nombre`, `apellido`, `usuario`, `contraseña`) VALUES
('gabriel', 'jimenez', 'gjim', 'aUl0UE5pTlhIN25ac2duWE0vYWhoQT09OjoZS8jYPoBV4r/nb+p5BD4b'),
('Ale', 'Ebas', 'star', 'UDBJMzJ4c2pFdW1rdWIxY0lUdjEzdz09OjqGZTiurqjorgcg9Z81fpuC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio`
--

CREATE TABLE `precio` (
  `id` int(11) NOT NULL,
  `medida_inicial` int(11) NOT NULL,
  `medida_final` int(11) NOT NULL,
  `valor_residencial` int(11) NOT NULL,
  `valor_comercial` int(11) NOT NULL,
  `valor_industrial` int(11) NOT NULL,
  `valor_fundador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `precio`
--

INSERT INTO `precio` (`id`, `medida_inicial`, `medida_final`, `valor_residencial`, `valor_comercial`, `valor_industrial`, `valor_fundador`) VALUES
(9, 0, 0, 4000, 4000, 4000, 4000),
(10, 1, 15, 600, 600, 600, 0),
(11, 16, 25, 800, 800, 800, 800),
(12, 26, 35, 1300, 1300, 1300, 1300),
(13, 36, 45, 1500, 1500, 1500, 1500),
(14, 46, 99999999, 2000, 2000, 2000, 2000);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abonos`
--
ALTER TABLE `abonos`
  ADD PRIMARY KEY (`cod_abono`),
  ADD KEY `cod_cliente` (`cod_cliente`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `deudores`
--
ALTER TABLE `deudores`
  ADD PRIMARY KEY (`cod_cliente`),
  ADD KEY `cod_cliente` (`cod_cliente`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`cod_factura`),
  ADD KEY `cod_cliente` (`cod_cliente`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`usuario`);

--
-- Indices de la tabla `precio`
--
ALTER TABLE `precio`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abonos`
--
ALTER TABLE `abonos`
  MODIFY `cod_abono` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `cod_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT de la tabla `precio`
--
ALTER TABLE `precio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `abonos`
--
ALTER TABLE `abonos`
  ADD CONSTRAINT `abonos_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `deudores`
--
ALTER TABLE `deudores`
  ADD CONSTRAINT `deudores_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`codigo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
