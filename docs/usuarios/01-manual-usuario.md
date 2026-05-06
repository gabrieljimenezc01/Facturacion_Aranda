# Manual de Usuario - Sistema de Facturación

## Introducción

Este manual está diseñado para los operadores del Acueducto Comunitario del Barrio Aranda. Aquí encontrarás instrucciones paso a paso para realizar las tareas diarias en el sistema.

## Requisitos previos

- Tener instalado XAMPP en el computador del acueducto
- Conocer tu usuario y contraseña (entregados por el administrador)
- El sistema solo funciona dentro de la red local del acueducto

---

## 1. Inicio de Sesión

### Paso 1: Abrir el navegador
- Usa Google Chrome, Firefox o Edge

### Paso 2: Ingresar la URL

```
http://localhost/Facturacion_Aranda/public/
```



### Paso 3: Ingresar credenciales
- **Usuario:** El que te asignaron
- **Contraseña:** La que te asignaron

### Paso 4: Hacer clic en "Ingresar"

> ⚠️ Si olvidaste tu contraseña, contacta al administrador del sistema.

---

## 2. Panel Principal

Al ingresar verás el menú principal con las siguientes opciones:

| Opción | Función |
|--------|---------|
| Usuarios | Gestionar clientes |
| Facturación | Generar y manejar facturas |
| Pagos | Registrar abonos y pagos |
| Reportes | Ver listados de deudores |
| Precios | Configurar tarifas |

---

## 3. Registrar un nuevo cliente

1. Ir al menú **Usuarios** → **Registrar cliente**
2. Llenar el formulario con:
   - Nombre y apellido completo
   - Dirección
   - Estrato socioeconómico (1,2,3,4,5,6)
   - Sector (Norte, Sur, Centro, etc.)
   - Tipo de uso (Residencial/Comercial/Industrial)
   - Código del medidor
   - Marcar si es **Fundador** (tarifa preferencial)
   - Diámetro del medidor (½, ¾, 1 pulgada)
3. Hacer clic en **Guardar**

> ✅ El cliente quedará registrado automáticamente.

---

## 4. Generar facturas mensuales

### Paso 1: Ir a **Facturación** → **Generar facturas**

### Paso 2: Seleccionar el sector
- Elige el sector (ej: Norte, Sur, Centro)

### Paso 3: Ingresar lecturas del medidor
- Para cada cliente, ingresar la **lectura actual** del medidor
- El sistema calcula automáticamente el consumo (lectura actual - lectura anterior)

### Paso 4: Configurar fechas
- Fecha inicial de facturación
- Fecha final de facturación  
- Fecha límite de pago

### Paso 5: Agregar anotaciones (opcional)
- Ej: "Medidor dañado, se estima consumo promedio"

### Paso 6: Hacer clic en **Generar facturas**

> ⏱️ El proceso toma menos de 2 segundos para un sector completo.

---

## 5. Imprimir facturas

### Para una factura individual:
1. Ir a **Facturación** → **Buscar facturas**
2. Buscar por nombre del cliente o número de factura
3. Hacer clic en **Ver PDF**
4. Imprimir usando Ctrl+P

### Para facturas de un sector completo:
1. Ir a **Facturación** → **Descargar lote**
2. Seleccionar sector, mes y año
3. Hacer clic en **Descargar todas**
4. Se generará un PDF con todas las facturas del sector

---

## 6. Registrar un pago

### Para pago total de factura:
1. Ir a **Pagos** → **Registrar pago**
2. Buscar al cliente por nombre o código
3. Seleccionar la factura que está pagando
4. Confirmar el monto (debe coincidir con el total de la factura)
5. Hacer clic en **Registrar pago**

### Para abono parcial (acuerdo de pago):
1. Ir a **Pagos** → **Acuerdo de pago**
2. Buscar al cliente moroso
3. Registrar:
   - Fecha del abono
   - Concepto (ej: "Abono a deuda marzo")
   - Valor que paga
4. Hacer clic en **Registrar abono**

> 📝 El sistema actualiza automáticamente el saldo pendiente.

---

## 7. Ver listado de deudores

1. Ir a **Reportes** → **Lista de deudores**
2. Se mostrarán todos los clientes con deudas pendientes
3. Información mostrada:
   - Código de usuario
   - Nombre
   - Dirección
   - Sector
   - Fundador (Sí/No)
   - Valor de la deuda

> 💾 Puedes exportar a PDF usando el botón **Descargar PDF**

---

## 8. Generar listado para Tesorería

1. Ir a **Reportes** → **Listado tesorería**
2. Seleccionar:
   - Sector
   - Mes
   - Año
3. Hacer clic en **Generar**
4. El listado incluye:
   - Código y nombre del cliente
   - Número de factura
   - Valor total a cobrar
   - Valor de deuda (si aplica)

---

## 9. Cerrar sesión

1. Hacer clic en tu nombre (esquina superior derecha)
2. Seleccionar **Cerrar sesión**
3. Confirmar

> 🔐 Siempre cierra sesión al terminar, especialmente en computadores compartidos.

---

## Solución de problemas comunes

| Problema | Solución |
|----------|----------|
| No puedo iniciar sesión | Verifica que el usuario y contraseña sean correctos |
| El sistema no carga | Asegura que XAMPP esté corriendo (Apache y MySQL) |
| No encuentro un cliente | Usa el buscador por nombre o código de medidor |
| Error al generar PDF | Verifica que haya facturas para ese mes y sector |
| La página se ve mal | Limpia la caché del navegador (Ctrl+Shift+Supr) |

---

## Contacto para soporte

Si encuentras un problema que no puedes resolver:

- **Desarrollador:** Jhon Hector Roque Males
- **Correo:** jhonhec2002@gmail.com