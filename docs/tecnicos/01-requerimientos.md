# Requerimientos del Sistema - Acueducto Aranda

## Requerimientos Funcionales

### RF-001. Registro de empleados
El sistema debe permitir registrar nuevos empleados para el manejo del programa con datos como nombre, apellido, nombre usuario y contraseña.

### RF-002. Registro de usuarios
El sistema debe permitir registrar nuevos clientes con datos como nombre, apellido, dirección, estrato socioeconómico, sector de vivienda, uso que le dará al agua, código del medidor, si es fundador o no y diámetro del medidor.

### RF-003. Modificar usuarios
El administrador podrá modificar los datos de los clientes, los datos del RF-002.

### RF-004. Eliminar Usuario
El administrador podrá eliminar clientes de la base de datos, para ello debe filtrar entre todos los usuarios usando el código de usuario, nombre y/o sector.

### RF-005. Lista deudores
El sistema debe generar una tabla con todos los clientes que presenten deudas, con datos como código de usuario, nombre del cliente, dirección, sector, si es fundador o no y el valor de la deuda.

### RF-006. Acuerdos de Pago
El administrador podrá registrar abonos o pagos totales de las deudas de los clientes, para ellos debe seleccionar un usuario que tenga una deuda, registrar la fecha del abono, el concepto del abono y el valor que paga.

### RF-007. Historial de Acuerdos de Pago
El sistema debe generar un historial con los pagos o abonos realizados por los clientes con motivo de deudas, además de generar un documento de pago en pdf.

### RF-008. Búsqueda de Facturas
El sistema debe generar una tabla con las facturas de un cliente, la tabla debe contener datos como: número de la factura, mes cobrado, consumo del mes en M3, valor de la deuda hasta esa factura, valor total de la factura, estado de pago y podrá visualizar la factura en pdf.

### RF-009. Generar facturas
El sistema debe permitir crear facturas por clientes de cada sector y calcular el valor de la factura de forma automatizada, para ellos se le debe suministrar datos como: fecha inicial de facturación, fecha final de facturación, fecha límite de pago, anotaciones y lectura del medidor.

### RF-010. Modificar facturas
El sistema debe permitir modificar los datos de una factura, datos como: lectura anterior, lectura actual y anotaciones.

### RF-011. Impresión de facturas
El sistema debe permitir descargar un lote de facturas en formato pdf, además de la visualización de cada una de las facturas por individual.

### RF-012. Eliminar facturas
El sistema debe permitir las facturas por bloque, con la combinación de los datos sector, mes y año.

### RF-013. Listado tesorería
El administrador podrá generar una lista para que el tesorero realice el recaudo correspondiente, la lista debe tener datos como: código del cliente, nombre y apellidos, número de la factura, valor de ingreso (suma de la factura y la deuda), valor de la deuda, y si el cliente es fundador o no.

### RF-014. Listado secretario
El secretario podrá registrar si los clientes realizaron el pago correspondiente de la factura y hacer el cierre de mes.

### RF-015. Registro precios del agua
El sistema debe permitir la creación de un nuevo registro para el manejo de valor del agua, para ello el usuario debe suministrar datos como, medida inicial, medida final, valor residencial, valor comercial, valor industrial y el valor para fundadores.

### RF-016. Tabla de Precios
El sistema debe generar una tabla en donde se muestran los rangos de los metros cúbicos de agua y su valor según el uso dado.

---

## Requerimientos No Funcionales

### RNF-001. Rendimiento
El sistema debe generar las facturas de todos los usuarios de un sector en menos de 2 segundos después de haber ingresado el valor de la lectura de cada usuario.

### RNF-002. Seguridad
El acceso al sistema debe requerir autenticación con usuario y contraseña. Las contraseñas deben almacenarse cifradas.

### RNF-003. Disponibilidad
El sistema debe estar disponible el 99% del tiempo, excepto durante mantenimientos programados.

### RNF-004. Escalabilidad
El sistema debe poder manejar hasta 10.000 usuarios sin pérdida de rendimiento.

### RNF-005. Compatibilidad
El sistema debe funcionar en los navegadores más comunes: Chrome, Firefox, Edge.

### RNF-006. Usabilidad
El sistema debe tener una interfaz sencilla e intuitiva para usuarios administrativos sin conocimientos técnicos avanzados.

### RNF-007. Manejo de errores en la interfaz
Los formularios deben validar datos en tiempo real y mostrar mensajes de error amigables al usuario.

### RNF-008. Mantenibilidad
El código del sistema debe estar documentado para facilitar futuras actualizaciones.

### RNF-009. Manejo de errores en el server
El sistema debe permitir registrar logs de errores con fecha, hora y tipo de error para facilitar el diagnóstico.

---

## 📊 Tabla resumen

| Tipo | Cantidad |
|------|----------|
| Requerimientos Funcionales | 16 |
| Requerimientos No Funcionales | 9 |
| **Total** | **25** |