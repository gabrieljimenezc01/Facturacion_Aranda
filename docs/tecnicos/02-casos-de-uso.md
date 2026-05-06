# Casos de Uso - Sistema de Facturación

## CU-001: Registrar empleado

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Permite al administrador registrar empleados del sistema |
| **Precondiciones** | El administrador debe saber la contraseña especial |
| **Flujo principal** | 1. Acceder a la funcionalidad<br>2. Ingresar datos (nombre, apellido, usuario, contraseña)<br>3. El sistema valida y guarda<br>4. Muestra confirmación |
| **Postcondiciones** | Nuevo empleado registrado |
| **Excepciones** | Datos incompletos o inválidos |

## CU-002: Registrar usuario (cliente)

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Registrar nuevo cliente con todos sus datos |
| **Precondiciones** | Estar autenticado |
| **Flujo principal** | 1. Acceder a clientes<br>2. Ingresar datos<br>3. Confirmar registro |
| **Postcondiciones** | Cliente registrado |
| **Excepciones** | Datos incompletos o medidor duplicado |

## CU-003: Modificar datos de usuario

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Editar datos de un cliente existente |
| **Precondiciones** | Cliente debe estar registrado |
| **Flujo principal** | 1. Buscar cliente<br>2. Editar datos<br>3. Guardar cambios |
| **Postcondiciones** | Datos actualizados |
| **Excepciones** | Cliente no encontrado |

## CU-004: Eliminar usuario

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Eliminar cliente usando filtros |
| **Precondiciones** | Cliente existe en BD |
| **Flujo principal** | 1. Buscar cliente<br>2. Confirmar eliminación<br>3. Eliminar |
| **Postcondiciones** | Cliente eliminado |
| **Excepciones** | Cliente no encontrado |

## CU-005: Consultar listado de deudores

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Genera tabla con usuarios con deudas pendientes |
| **Precondiciones** | Usuarios con deudas registradas |
| **Flujo principal** | 1. Acceder a módulo deudores<br>2. Generar listado |
| **Postcondiciones** | Listado generado |
| **Excepciones** | No hay deudores |

## CU-006: Registrar acuerdo de pago

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Registrar abonos o pagos a deudas |
| **Precondiciones** | Cliente debe tener deuda registrada |
| **Flujo principal** | 1. Buscar cliente deudor<br>2. Registrar abono<br>3. Confirmar |
| **Postcondiciones** | Abono registrado, deuda actualizada |
| **Excepciones** | Monto inválido |

## CU-007: Consultar historial de acuerdos de pago

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Muestra y permite descargar historial de pagos |
| **Precondiciones** | Cliente debe haber realizado pagos |
| **Flujo principal** | 1. Buscar cliente<br>2. Visualizar historial<br>3. Descargar PDF |
| **Postcondiciones** | Historial mostrado |
| **Excepciones** | Cliente sin historial |

## CU-008: Buscar facturas de un cliente

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Consultar facturas de un cliente y ver en PDF |
| **Precondiciones** | Cliente debe tener facturas emitidas |
| **Flujo principal** | 1. Buscar cliente<br>2. Mostrar facturas<br>3. Visualizar PDF |
| **Excepciones** | Cliente sin facturas |

## CU-009: Generar facturas

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Generar facturas por sector con cálculos automáticos |
| **Precondiciones** | Clientes registrados con lecturas actualizadas |
| **Flujo principal** | 1. Seleccionar datos<br>2. Diligenciar lectura<br>3. Calcular factura<br>4. Confirmar |
| **Postcondiciones** | Factura almacenada |
| **Excepciones** | Lecturas inválidas |

## CU-010: Modificar factura

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Editar lecturas y anotaciones de una factura |
| **Precondiciones** | Factura existente |
| **Flujo principal** | 1. Buscar factura<br>2. Editar datos<br>3. Guardar cambios |
| **Postcondiciones** | Factura modificada |
| **Excepciones** | Error al guardar |

## CU-011: Eliminar facturas

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Eliminar facturas erróneas del sistema |
| **Precondiciones** | Facturas deben estar registradas |
| **Flujo principal** | 1. Buscar facturas (mes, sector, año)<br>2. Confirmar<br>3. Eliminar |
| **Postcondiciones** | Facturas eliminadas |
| **Excepciones** | Facturas no encontradas |

## CU-012: Descargar facturas en PDF

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Generar archivo PDF de factura para impresión |
| **Precondiciones** | Factura existente |
| **Flujo principal** | 1. Buscar facturas<br>2. Seleccionar descargar<br>3. Generar PDF |
| **Excepciones** | Error al generar PDF |

## CU-013: Generar listas para Tesorería

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Generar PDF con lista de recaudo |
| **Precondiciones** | Facturas para el mes generadas |
| **Flujo principal** | 1. Seleccionar Lista Tesorero<br>2. Buscar (sector, mes, año)<br>3. Generar lista<br>4. Descargar PDF |
| **Excepciones** | No hay facturas |

## CU-014: Generar listas para Secretario

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Generar lista para registrar quiénes pagaron |
| **Precondiciones** | Facturas para el mes generadas |
| **Flujo principal** | 1. Seleccionar Lista Secretario<br>2. Buscar (sector, mes, año)<br>3. Generar lista<br>4. Seleccionar pagos<br>5. Guardar cambios |
| **Postcondiciones** | Facturas actualizadas |

## CU-015: Registro de precios del agua

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Registrar valores para medida del agua según uso |
| **Precondiciones** | Conocer nuevos valores |
| **Flujo principal** | 1. Ingresar a precios<br>2. Llenar valores<br>3. Confirmar<br>4. Agregar registro |
| **Excepciones** | Datos inválidos |

## CU-016: Modificar Tabla de manejo de precios

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Modificar tabla de precios del agua |
| **Precondiciones** | Valores y medidas existentes |
| **Flujo principal** | 1. Seleccionar dato a cambiar<br>2. Verificar datos<br>3. Guardar cambios |
| **Excepciones** | Datos inválidos |

## CU-017: Cerrar sesión

| Campo | Valor |
|-------|-------|
| **Actor** | Administrador |
| **Descripción** | Finaliza la sesión actual del usuario |
| **Precondiciones** | Usuario debe estar autenticado |
| **Flujo principal** | 1. Acceder a opción cerrar sesión<br>2. Confirmar |
| **Postcondiciones** | Usuario desconectado |
| **Excepciones** | Error de red |

---

## 📊 Resumen de Casos de Uso

| Módulo | Cantidad de CU |
|--------|----------------|
| Gestión de Usuarios | 4 (CU-001 al 004) |
| Gestión de Deudas/Pagos | 3 (CU-005 al 007) |
| Gestión de Facturas | 5 (CU-008 al 012) |
| Reportes y Listados | 2 (CU-013, CU-014) |
| Configuración | 2 (CU-015, CU-016) |
| Sistema | 1 (CU-017) |
| **Total** | **17** |