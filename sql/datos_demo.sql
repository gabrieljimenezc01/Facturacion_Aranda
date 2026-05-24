-- =====================================================
-- BASE DE DATOS: acueducto_aranda
-- SISTEMA DE FACTURACIÓN DE AGUA
-- Versión: 1.0
-- Fecha: Mayo 2026
-- =====================================================
-- NOTA: Este archivo contiene la estructura COMPLETA
-- de la base de datos y datos DEMO anonimizados.
-- Los datos son 100% FICTICIOS.
-- =====================================================

-- =====================================================
-- 1. ELIMINAR TABLAS SI EXISTEN (Orden correcto)
-- =====================================================
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `abonos`;
DROP TABLE IF EXISTS `factura`;
DROP TABLE IF EXISTS `deudores`;
DROP TABLE IF EXISTS `clientes`;
DROP TABLE IF EXISTS `login`;
DROP TABLE IF EXISTS `precio`;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- 2. CREAR TABLAS (ESQUEMA)
-- =====================================================

-- -----------------------------------------------------
-- Tabla `clientes`
-- -----------------------------------------------------
CREATE TABLE `clientes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `estrato` int(11) NOT NULL,
  `sector` varchar(20) NOT NULL,
  `uso` varchar(50) NOT NULL,
  `codigo_medidor` varchar(50) NOT NULL,
  `diametro_medidor` varchar(50) NOT NULL,
  `fundador` varchar(3) NOT NULL,
  `activo` varchar(3) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------
-- Tabla `deudores`
-- -----------------------------------------------------
CREATE TABLE `deudores` (
  `cod_cliente` int(11) NOT NULL,
  `valor_total` int(11) NOT NULL,
  `motivo` varchar(100) NOT NULL,
  PRIMARY KEY (`cod_cliente`),
  KEY `cod_cliente` (`cod_cliente`),
  CONSTRAINT `deudores_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`codigo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------
-- Tabla `factura`
-- -----------------------------------------------------
CREATE TABLE `factura` (
  `cod_factura` int(11) NOT NULL AUTO_INCREMENT,
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
  `valor_factura` int(11) NOT NULL,
  `valor_deuda` int(11) NOT NULL,
  `Anotaciones` varchar(200) NOT NULL,
  `estado_pago` varchar(20) NOT NULL,
  `fecha_limite_pago` date NOT NULL,
  `fecha_limite_pago_2` date DEFAULT NULL,
  PRIMARY KEY (`cod_factura`),
  KEY `cod_cliente` (`cod_cliente`),
  CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------
-- Tabla `abonos`
-- -----------------------------------------------------
CREATE TABLE `abonos` (
  `cod_cliente` int(11) NOT NULL,
  `cod_abono` int(11) NOT NULL AUTO_INCREMENT,
  `concepto` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY (`cod_abono`),
  KEY `cod_cliente` (`cod_cliente`),
  CONSTRAINT `abonos_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------
-- Tabla `login`
-- -----------------------------------------------------
CREATE TABLE `login` (
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(300) NOT NULL,
  PRIMARY KEY (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------
-- Tabla `precio`
-- -----------------------------------------------------
CREATE TABLE `precio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medida_inicial` int(11) NOT NULL,
  `medida_final` int(11) NOT NULL,
  `valor_residencial` int(11) NOT NULL,
  `valor_comercial` int(11) NOT NULL,
  `valor_industrial` int(11) NOT NULL,
  `valor_fundador` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- 3. DATOS DEMO (ANONIMIZADOS - 100% FICTICIOS)
-- =====================================================

-- -----------------------------------------------------
-- Insertar Precios Base
-- -----------------------------------------------------
INSERT INTO `precio` (`id`, `medida_inicial`, `medida_final`, `valor_residencial`, `valor_comercial`, `valor_industrial`, `valor_fundador`) VALUES
(1, 0, 0, 5000, 5000, 5000, 5000),
(2, 1, 10, 800, 1000, 1500, 600),
(3, 11, 20, 1000, 1200, 1800, 800),
(4, 21, 30, 1200, 1500, 2000, 1000),
(5, 31, 50, 1500, 1800, 2200, 1200),
(6, 51, 100, 1800, 2200, 2500, 1500),
(7, 101, 999999, 2000, 2500, 3000, 1800);

-- -----------------------------------------------------
-- Insertar Clientes Demo (15 clientes ficticios)
-- -----------------------------------------------------
INSERT INTO `clientes` (`codigo`, `nombre`, `apellido`, `direccion`, `estrato`, `sector`, `uso`, `codigo_medidor`, `diametro_medidor`, `fundador`, `activo`, `orden`) VALUES
(1, 'JUAN CARLOS', 'PEREZ GOMEZ', 'Calle 10 # 20-30', 2, '1', 'Residencial', 'DEMO001', '1/2 PULGADA', 'NO', 'SI', 1),
(2, 'MARIA EUGENIA', 'RODRIGUEZ LOPEZ', 'Carrera 15 # 25-40', 3, '2', 'Residencial', 'DEMO002', '1/2 PULGADA', 'NO', 'SI', 2),
(3, 'PEDRO ALBERTO', 'MARTINEZ CASTRO', 'Calle 5 # 8-12', 1, '1', 'Comercial', 'DEMO003', '3/4 PULGADA', 'NO', 'SI', 3),
(4, 'ANA SOFIA', 'LOPEZ HERRERA', 'Carrera 8 # 15-20', 2, '3', 'Residencial', 'DEMO004', '1/2 PULGADA', 'SI', 'SI', 4),
(5, 'CARLOS ANDRES', 'GONZALEZ DIAZ', 'Avenida 4 # 6-10', 3, '2', 'Residencial', 'DEMO005', '1/2 PULGADA', 'NO', 'SI', 5),
(6, 'LUZ MARINA', 'DIAZ RAMIREZ', 'Calle 20 # 15-25', 1, '1', 'Residencial', 'DEMO006', '1/2 PULGADA', 'NO', 'SI', 6),
(7, 'JORGE ENRIQUE', 'RAMIREZ SANCHEZ', 'Carrera 12 # 18-22', 4, '3', 'Industrial', 'DEMO007', '1 PULGADA', 'NO', 'SI', 7),
(8, 'GLORIA PATRICIA', 'SANCHEZ TORRES', 'Calle 8 # 12-18', 2, '2', 'Residencial', 'DEMO008', '1/2 PULGADA', 'SI', 'SI', 8),
(9, 'RICARDO JOSE', 'TORRES CASTRO', 'Carrera 5 # 10-15', 3, '1', 'Comercial', 'DEMO009', '1/2 PULGADA', 'NO', 'SI', 9),
(10, 'ELIZABETH', 'CASTRO MORALES', 'Avenida 2 # 5-8', 1, '3', 'Residencial', 'DEMO010', '1/2 PULGADA', 'NO', 'SI', 10),
(11, 'FERNANDO', 'MORALES ORTIZ', 'Calle 15 # 30-40', 2, '2', 'Residencial', 'DEMO011', '1/2 PULGADA', 'NO', 'SI', 11),
(12, 'CARMEN ROSA', 'ORTIZ MENDOZA', 'Carrera 20 # 25-35', 3, '1', 'Residencial', 'DEMO012', '1/2 PULGADA', 'NO', 'SI', 12),
(13, 'RAFAEL', 'MENDOZA HERRERA', 'Calle 25 # 18-22', 4, '4', 'Residencial', 'DEMO013', '1/2 PULGADA', 'NO', 'SI', 13),
(14, 'PATRICIA', 'HERRERA VEGA', 'Carrera 10 # 20-30', 1, '2', 'Residencial', 'DEMO014', '1/2 PULGADA', 'SI', 'SI', 14),
(15, 'GUILLERMO', 'VEGA DIAZ', 'Avenida 6 # 12-18', 2, '3', 'Residencial', 'DEMO015', '1/2 PULGADA', 'NO', 'SI', 15);

-- -----------------------------------------------------
-- Insertar Deudores (5 clientes con deudas)
-- -----------------------------------------------------
INSERT INTO `deudores` (`cod_cliente`, `valor_total`, `motivo`) VALUES
(3, 25000, 'Factura pendiente - Julio 2025'),
(5, 18000, 'Factura pendiente - Agosto 2025'),
(8, 32000, 'Dos facturas pendientes'),
(11, 15000, 'Recargo por pago tardío'),
(13, 42000, 'Matricula pendiente');

-- -----------------------------------------------------
-- Insertar Facturas (30 facturas demo)
-- -----------------------------------------------------
INSERT INTO `factura` (`cod_factura`, `cod_cliente`, `fecha_inicio_cobro`, `fecha_fin_cobro`, `mes_cobrado`, `lectura_inicial`, `lectura_final`, `consumo_m3`, `valor_total`, `valor_consumo`, `valor_basico`, `valor_factura`, `valor_deuda`, `Anotaciones`, `estado_pago`, `fecha_limite_pago`) VALUES
-- Cliente 1
(1, 1, '2025-06-20', '2025-07-20', 'Julio', 1000, 1015, 15, 18000, 13000, 5000, 18000, 0, 'Ninguna', 'SI', '2025-07-28'),
(2, 1, '2025-07-20', '2025-08-20', 'Agosto', 1015, 1032, 17, 20000, 15000, 5000, 20000, 0, 'Ninguna', 'SI', '2025-08-28'),
(3, 1, '2025-08-20', '2025-09-20', 'Septiembre', 1032, 1045, 13, 18000, 13000, 5000, 18000, 0, 'Ninguna', 'NO', '2025-09-28'),

-- Cliente 2
(4, 2, '2025-06-20', '2025-07-20', 'Julio', 500, 510, 10, 13000, 8000, 5000, 13000, 0, 'Ninguna', 'SI', '2025-07-28'),
(5, 2, '2025-07-20', '2025-08-20', 'Agosto', 510, 525, 15, 18000, 13000, 5000, 18000, 0, 'Ninguna', 'SI', '2025-08-28'),
(6, 2, '2025-08-20', '2025-09-20', 'Septiembre', 525, 538, 13, 18000, 13000, 5000, 18000, 0, 'Ninguna', 'SI', '2025-09-28'),

-- Cliente 3 (Comercial con deuda)
(7, 3, '2025-06-20', '2025-07-20', 'Julio', 800, 825, 25, 40000, 35000, 5000, 40000, 0, 'Ninguna', 'SI', '2025-07-28'),
(8, 3, '2025-07-20', '2025-08-20', 'Agosto', 825, 840, 15, 25000, 20000, 5000, 25000, 0, 'Ninguna', 'NO', '2025-08-28'),
(9, 3, '2025-08-20', '2025-09-20', 'Septiembre', 840, 860, 20, 35000, 30000, 5000, 35000, 25000, 'Recargo y deuda', 'NO', '2025-09-28'),

-- Cliente 4 (Fundador)
(10, 4, '2025-06-20', '2025-07-20', 'Julio', 1200, 1212, 12, 17000, 12000, 5000, 17000, 0, 'Ninguna', 'SI', '2025-07-28'),
(11, 4, '2025-07-20', '2025-08-20', 'Agosto', 1212, 1225, 13, 18000, 13000, 5000, 18000, 0, 'Ninguna', 'SI', '2025-08-28'),
(12, 4, '2025-08-20', '2025-09-20', 'Septiembre', 1225, 1240, 15, 20000, 15000, 5000, 20000, 0, 'Ninguna', 'SI', '2025-09-28'),

-- Cliente 5 (Con deuda)
(13, 5, '2025-06-20', '2025-07-20', 'Julio', 300, 308, 8, 11000, 6000, 5000, 11000, 0, 'Ninguna', 'SI', '2025-07-28'),
(14, 5, '2025-07-20', '2025-08-20', 'Agosto', 308, 320, 12, 17000, 12000, 5000, 17000, 0, 'Ninguna', 'NO', '2025-08-28'),
(15, 5, '2025-08-20', '2025-09-20', 'Septiembre', 320, 335, 15, 20000, 15000, 5000, 20000, 18000, 'Recargo y deuda', 'NO', '2025-09-28'),

-- Cliente 6
(16, 6, '2025-06-20', '2025-07-20', 'Julio', 1500, 1520, 20, 26000, 21000, 5000, 26000, 0, 'Ninguna', 'SI', '2025-07-28'),
(17, 6, '2025-07-20', '2025-08-20', 'Agosto', 1520, 1540, 20, 26000, 21000, 5000, 26000, 0, 'Ninguna', 'SI', '2025-08-28'),

-- Cliente 7 (Industrial)
(18, 7, '2025-06-20', '2025-07-20', 'Julio', 1000, 1040, 40, 85000, 80000, 5000, 85000, 0, 'Ninguna', 'SI', '2025-07-28'),
(19, 7, '2025-07-20', '2025-08-20', 'Agosto', 1040, 1080, 40, 85000, 80000, 5000, 85000, 0, 'Ninguna', 'NO', '2025-08-28'),

-- Cliente 8
(20, 8, '2025-06-20', '2025-07-20', 'Julio', 600, 608, 8, 11000, 6000, 5000, 11000, 0, 'Ninguna', 'SI', '2025-07-28'),
(21, 8, '2025-07-20', '2025-08-20', 'Agosto', 608, 615, 7, 10000, 5000, 5000, 10000, 0, 'Ninguna', 'NO', '2025-08-28'),

-- Cliente 9 (Comercial)
(22, 9, '2025-06-20', '2025-07-20', 'Julio', 200, 215, 15, 28000, 23000, 5000, 28000, 0, 'Ninguna', 'SI', '2025-07-28'),
(23, 9, '2025-07-20', '2025-08-20', 'Agosto', 215, 228, 13, 25000, 20000, 5000, 25000, 0, 'Ninguna', 'SI', '2025-08-28'),

-- Cliente 10
(24, 10, '2025-06-20', '2025-07-20', 'Julio', 800, 815, 15, 18000, 13000, 5000, 18000, 0, 'Ninguna', 'SI', '2025-07-28'),
(25, 10, '2025-07-20', '2025-08-20', 'Agosto', 815, 828, 13, 18000, 13000, 5000, 18000, 0, 'Ninguna', 'SI', '2025-08-28'),

-- Cliente 11
(26, 11, '2025-06-20', '2025-07-20', 'Julio', 350, 360, 10, 13000, 8000, 5000, 13000, 0, 'Ninguna', 'SI', '2025-07-28'),
(27, 11, '2025-07-20', '2025-08-20', 'Agosto', 360, 370, 10, 13000, 8000, 5000, 13000, 0, 'Ninguna', 'NO', '2025-08-28'),

-- Cliente 12
(28, 12, '2025-06-20', '2025-07-20', 'Julio', 900, 915, 15, 18000, 13000, 5000, 18000, 0, 'Ninguna', 'SI', '2025-07-28'),
(29, 12, '2025-07-20', '2025-08-20', 'Agosto', 915, 928, 13, 18000, 13000, 5000, 18000, 0, 'Ninguna', 'SI', '2025-08-28'),

-- Cliente 13
(30, 13, '2025-06-20', '2025-07-20', 'Julio', 750, 765, 15, 18000, 13000, 5000, 18000, 0, 'Ninguna', 'SI', '2025-07-28');

-- -----------------------------------------------------
-- Insertar Abonos (Pagos registrados)
-- -----------------------------------------------------
INSERT INTO `abonos` (`cod_cliente`, `cod_abono`, `concepto`, `fecha`, `valor`) VALUES
(1, 1, 'PAGO TOTAL JULIO', '2025-07-25', 18000),
(1, 2, 'PAGO TOTAL AGOSTO', '2025-08-25', 20000),
(2, 3, 'PAGO TOTAL JULIO', '2025-07-26', 13000),
(2, 4, 'PAGO TOTAL AGOSTO', '2025-08-24', 18000),
(4, 5, 'PAGO TOTAL JULIO', '2025-07-22', 17000),
(4, 6, 'PAGO TOTAL AGOSTO', '2025-08-26', 18000),
(5, 7, 'ABONO JULIO', '2025-07-28', 11000),
(6, 8, 'PAGO TOTAL JULIO', '2025-07-27', 26000),
(7, 9, 'PAGO TOTAL JULIO', '2025-07-24', 85000),
(8, 10, 'PAGO TOTAL JULIO', '2025-07-26', 11000),
(9, 11, 'PAGO TOTAL JULIO', '2025-07-23', 28000),
(9, 12, 'PAGO TOTAL AGOSTO', '2025-08-27', 25000),
(10, 13, 'PAGO TOTAL JULIO', '2025-07-25', 18000),
(11, 14, 'PAGO TOTAL JULIO', '2025-07-26', 13000),
(12, 15, 'PAGO TOTAL JULIO', '2025-07-24', 18000),
(13, 16, 'PAGO TOTAL JULIO', '2025-07-28', 18000);

-- -----------------------------------------------------
-- Insertar Usuarios del Sistema
-- -----------------------------------------------------
-- Contraseñas (en base64):
-- admin123 -> YWRtaW4xMjM=
-- usuario123 -> dXN1YXJpbzEyMw==
-- contador123 -> Y29udGFkb3IxMjM=
-- demo -> ZGVtbw==
INSERT INTO `login` (`nombre`, `apellido`, `usuario`, `contraseña`) VALUES
('Administrador', 'General', 'admin', 'YWRtaW4xMjM='),
('Usuario', 'Prueba', 'usuario', 'dXN1YXJpbzEyMw=='),
('Contador', 'Sistema', 'contador', 'Y29udGFkb3IxMjM='),
('Demo', 'Test', 'demo', 'ZGVtbw==');

-- =====================================================
-- 4. VERIFICACIÓN DE DATOS
-- =====================================================
SELECT '=== VERIFICACIÓN DE CARGA ===' AS '';
SELECT CONCAT('Clientes: ', COUNT(*)) AS resultado FROM clientes;
SELECT CONCAT('Deudores: ', COUNT(*)) AS resultado FROM deudores;
SELECT CONCAT('Facturas: ', COUNT(*)) AS resultado FROM factura;
SELECT CONCAT('Abonos: ', COUNT(*)) AS resultado FROM abonos;
SELECT CONCAT('Usuarios: ', COUNT(*)) AS resultado FROM login;
SELECT CONCAT('Tarifas: ', COUNT(*)) AS resultado FROM precio;

SELECT '=== USUARIOS DISPONIBLES ===' AS '';
SELECT usuario, nombre, apellido FROM login;

SELECT '=== CARGADO CORRECTAMENTE ===' AS '';

-- =====================================================
-- FIN DEL ARCHIVO
-- =====================================================