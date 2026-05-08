-- =====================================================
-- BASE DE DATOS - Acueducto Aranda
-- ESTRUCTURA COMPLETA (sin datos)
-- Basado en tu estructura real
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Tabla `abonos`
-- --------------------------------------------------------
CREATE TABLE `abonos` (
  `cod_cliente` int(11) NOT NULL,
  `cod_abono` int(11) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla `clientes`
-- --------------------------------------------------------
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

-- --------------------------------------------------------
-- Tabla `deudores`
-- --------------------------------------------------------
CREATE TABLE `deudores` (
  `cod_cliente` int(11) NOT NULL,
  `valor_total` int(11) NOT NULL,
  `motivo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla `factura`
-- --------------------------------------------------------
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
  `valor_factura` int(11) NOT NULL,
  `valor_deuda` int(11) NOT NULL,
  `Anotaciones` varchar(200) NOT NULL,
  `estado_pago` varchar(20) NOT NULL,
  `fecha_limite_pago` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla `login`
-- --------------------------------------------------------
CREATE TABLE `login` (
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla `precio`
-- --------------------------------------------------------
CREATE TABLE `precio` (
  `id` int(11) NOT NULL,
  `medida_inicial` int(11) NOT NULL,
  `medida_final` int(11) NOT NULL,
  `valor_residencial` int(11) NOT NULL,
  `valor_comercial` int(11) NOT NULL,
  `valor_industrial` int(11) NOT NULL,
  `valor_fundador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- ÍNDICES
-- --------------------------------------------------------
ALTER TABLE `abonos`
  ADD PRIMARY KEY (`cod_abono`),
  ADD KEY `cod_cliente` (`cod_cliente`);

ALTER TABLE `clientes`
  ADD PRIMARY KEY (`codigo`);

ALTER TABLE `deudores`
  ADD PRIMARY KEY (`cod_cliente`),
  ADD KEY `cod_cliente` (`cod_cliente`);

ALTER TABLE `factura`
  ADD PRIMARY KEY (`cod_factura`),
  ADD KEY `cod_cliente` (`cod_cliente`);

ALTER TABLE `login`
  ADD PRIMARY KEY (`usuario`);

ALTER TABLE `precio`
  ADD PRIMARY KEY (`id`);

-- --------------------------------------------------------
-- AUTO_INCREMENT
-- --------------------------------------------------------
ALTER TABLE `abonos`
  MODIFY `cod_abono` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `clientes`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `factura`
  MODIFY `cod_factura` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `precio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------
-- LLAVES FORÁNEAS
-- --------------------------------------------------------
ALTER TABLE `abonos`
  ADD CONSTRAINT `abonos_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `deudores`
  ADD CONSTRAINT `deudores_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`codigo`) ON UPDATE CASCADE;

ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`codigo`);