-- =====================================================
-- DATOS DE DEMOSTRACIÓN - Acueducto Aranda
-- COMPLETAMENTE FICTICIOS - Basado en tu estructura
-- =====================================================

-- --------------------------------------------------------
-- Usuarios del sistema (tabla login)
-- Contraseña para todos: demo123
-- --------------------------------------------------------
INSERT INTO `login` (`nombre`, `apellido`, `usuario`, `contraseña`) VALUES
('Admin', 'Sistema', 'admin', '$2y$10$DEMO1234567890AbCdEfGhIjKlMnOpQrStUv'),
('gabriel', 'jimenez', 'gjim', 'aUl0UE5pTlhIN25ac2duWE0vYWhoQT09OjoZS8jYPoBV4r/nb+p5BD4b');

-- --------------------------------------------------------
-- Clientes de demostración (10 clientes ficticios)
-- --------------------------------------------------------
INSERT INTO `clientes` (`codigo`, `nombre`, `apellido`, `direccion`, `estrato`, `sector`, `uso`, `codigo_medidor`, `diametro_medidor`, `fundador`, `activo`) VALUES
(1, 'Carlos', 'Perez', 'Calle Demo 123', 3, 'Norte', 'Residencial', 'DEMO001', '1/2 PULGADA', 'NO', 'SI'),
(2, 'Ana', 'Rodriguez', 'Carrera Demo 45', 4, 'Norte', 'Residencial', 'DEMO002', '1/2 PULGADA', 'NO', 'SI'),
(3, 'Luis', 'Fernandez', 'Avenida Demo 78', 2, 'Sur', 'Residencial', 'DEMO003', '1/2 PULGADA', 'SI', 'SI'),
(4, 'Carmen', 'Martinez', 'Calle Ejemplo 90', 5, 'Sur', 'Comercial', 'DEMO004', '3/4 PULGADA', 'NO', 'SI'),
(5, 'Jose', 'Sanchez', 'Diagonal Demo 12', 3, 'Centro', 'Residencial', 'DEMO005', '1/2 PULGADA', 'NO', 'SI'),
(6, 'Laura', 'Diaz', 'Transversal Demo 34', 4, 'Centro', 'Comercial', 'DEMO006', '3/4 PULGADA', 'NO', 'SI'),
(7, 'Pedro', 'Ramirez', 'Circular Demo 56', 2, 'Norte', 'Residencial', 'DEMO007', '1/2 PULGADA', 'SI', 'SI'),
(8, 'Sofia', 'Torres', 'Calle Prueba 78', 3, 'Sur', 'Residencial', 'DEMO008', '1/2 PULGADA', 'NO', 'SI'),
(9, 'Miguel', 'Flores', 'Carrera Test 90', 4, 'Centro', 'Industrial', 'DEMO009', '1 PULGADA', 'NO', 'SI'),
(10, 'Elena', 'Castro', 'Avenida Sample 11', 3, 'Norte', 'Residencial', 'DEMO010', '1/2 PULGADA', 'NO', 'SI');

-- --------------------------------------------------------
-- Precios del agua (tarifas de demostración)
-- --------------------------------------------------------
INSERT INTO `precio` (`id`, `medida_inicial`, `medida_final`, `valor_residencial`, `valor_comercial`, `valor_industrial`, `valor_fundador`) VALUES
(1, 0, 0, 4000, 4000, 4000, 4000),
(2, 1, 15, 600, 600, 600, 500),
(3, 16, 25, 800, 800, 800, 700),
(4, 26, 35, 1300, 1300, 1300, 1100),
(5, 36, 45, 1500, 1500, 1500, 1300),
(6, 46, 999999, 2000, 2000, 2000, 1800);

-- --------------------------------------------------------
-- Facturas de demostración
-- --------------------------------------------------------
INSERT INTO `factura` (`cod_factura`, `cod_cliente`, `fecha_inicio_cobro`, `fecha_fin_cobro`, `mes_cobrado`, `lectura_inicial`, `lectura_final`, `consumo_m3`, `valor_total`, `valor_consumo`, `valor_basico`, `valor_factura`, `valor_deuda`, `Anotaciones`, `estado_pago`, `fecha_limite_pago`) VALUES
(1, 1, '2025-01-01', '2025-01-31', 'Enero', 100, 115, 15, 13000, 9000, 4000, 13000, 0, 'Pago puntual', 'Pagado', '2025-02-15'),
(2, 1, '2025-02-01', '2025-02-28', 'Febrero', 115, 128, 13, 11800, 7800, 4000, 11800, 0, '', 'Pendiente', '2025-03-15'),
(3, 2, '2025-01-01', '2025-01-31', 'Enero', 200, 218, 18, 14800, 10800, 4000, 14800, 0, '', 'Pagado', '2025-02-15'),
(4, 2, '2025-02-01', '2025-02-28', 'Febrero', 218, 235, 17, 14200, 10200, 4000, 14200, 0, '', 'Pagado', '2025-03-15'),
(5, 3, '2025-01-01', '2025-01-31', 'Enero', 50, 65, 15, 11500, 7500, 4000, 11500, 0, 'Tarifa fundador', 'Pagado', '2025-02-15'),
(6, 3, '2025-02-01', '2025-02-28', 'Febrero', 65, 78, 13, 10100, 6100, 4000, 10100, 0, '', 'Pendiente', '2025-03-15'),
(7, 4, '2025-01-01', '2025-01-31', 'Enero', 300, 330, 30, 40000, 36000, 4000, 40000, 0, 'Comercial', 'Pagado', '2025-02-15'),
(8, 4, '2025-02-01', '2025-02-28', 'Febrero', 330, 355, 25, 34000, 30000, 4000, 34000, 0, '', 'Pendiente', '2025-03-15'),
(9, 5, '2025-01-01', '2025-01-31', 'Enero', 150, 162, 12, 11200, 7200, 4000, 11200, 0, '', 'Pagado', '2025-02-15'),
(10, 5, '2025-02-01', '2025-02-28', 'Febrero', 162, 175, 13, 11800, 7800, 4000, 11800, 0, '', 'Pendiente', '2025-03-15');

-- --------------------------------------------------------
-- Deudores (clientes con deudas pendientes)
-- --------------------------------------------------------
INSERT INTO `deudores` (`cod_cliente`, `valor_total`, `motivo`) VALUES
(1, 11800, 'FACTURA'),
(3, 10100, 'FACTURA'),
(4, 34000, 'FACTURA'),
(5, 11800, 'FACTURA');

-- --------------------------------------------------------
-- Abonos (pagos parciales)
-- --------------------------------------------------------
INSERT INTO `abonos` (`cod_cliente`, `cod_abono`, `concepto`, `fecha`, `valor`) VALUES
(1, 1, 'Abono factura febrero', '2025-03-10', 6000),
(3, 2, 'Abono parcial', '2025-03-12', 5000),
(5, 3, 'Abono factura febrero', '2025-03-08', 6000);


