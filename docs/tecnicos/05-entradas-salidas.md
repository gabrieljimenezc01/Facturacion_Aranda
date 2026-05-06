# Entradas y Salidas del Sistema

El sistema de facturación del acueducto de Aranda se basa en un conjunto de entradas y salidas de información que permiten automatizar, controlar y supervisar los procesos relacionados con el servicio.

## Entradas del sistema

| Dato | Descripción |
|------|-------------|
| **Usuarios/Clientes** | ID_usuario, nombre, dirección, número de contrato, estado del servicio |
| **Facturación** | ID_factura, ID_usuario, consumo_m3, tarifa, total, saldo, estado |
| **Medidores** | ID_medidor, ID_usuario, última lectura, fecha de última lectura |
| **Pagos** | ID_pago, ID_usuario, monto, fecha, método de pago |
| **Consumo histórico** | ID_usuario, fecha, consumo_m3 |
| **Personal del servicio** | Nombre, cargo, turnos, permisos en el sistema |

## Salidas del sistema

| Dato | Descripción |
|------|-------------|
| **Facturación mensual** | ID_factura, ID_usuario, consumo_m3, tarifa, total, estado |
| **Estado del servicio** | Usuarios activos, suspendidos, desconectados |
| **Historial de pagos** | ID_usuario, montos pagados, deudas pendientes |
| **Reportes de consumo** | Usuarios con mayor y menor consumo |
| **Informe financiero** | Ingresos por facturación, gastos operativos, balance |

## Flujo de información

```
┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐
│ ENTRADAS │────▶│ SISTEMA │────▶│ SALIDAS │
├─────────────────┤ ├─────────────────┤ ├─────────────────┤
│ • Usuarios │ │ • Procesamiento │ │ • Facturas │
│ • Lecturas │ │ • Cálculos │ │ • Reportes │
│ • Pagos │ │ • Validaciones │ │ • Listados │
│ • Precios │ │ • Almacenamiento│ │ • PDFs │
└─────────────────┘ └─────────────────┘ └─────────────────┘
```