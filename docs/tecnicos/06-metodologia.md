# Metodología de Desarrollo

## Scrum

Para el desarrollo del sistema de facturación del acueducto de Aranda se adoptó la metodología ágil **Scrum**, la cual permite gestionar el proyecto de forma flexible, iterativa e incremental.

### ¿Por qué Scrum?

- Capacidad para adaptarse a los cambios
- Fomenta la colaboración entre los miembros del equipo
- Ofrece entregas parciales funcionales en corto tiempo
- Permite mejora continua del producto

## Estructura de Sprints

Los sprints fueron establecidos con una duración de **una semana cada uno**.

| Sprint | Semana | Entregables |
|--------|--------|-------------|
| **Sprint 1** | Semana 1 | Módulo de registro e inicio de sesión, menú principal, configuración inicial |
| **Sprint 2** | Semana 2 | Gestión de usuarios (CRUD), búsqueda de morosos |
| **Sprint 3** | Semana 3 | Facturación por sectores, generación de PDF |
| **Sprint 4** | Semana 4 | Recaudo de pagos, informes de consumo, modificación de costos |

## Historias de Usuario

| ID | Historia de Usuario | Alias | Prioridad |
|----|---------------------|-------|-----------|
| HUA-001 | Como usuario, quiero poder iniciar sesión y registrarme | LOGIN | ALTA |
| HUA-002 | Como usuario, quiero acceder a un menú principal claro y organizado | MENÚ | MEDIA |
| HUA-003 | Como usuario, quiero gestionar la información de los clientes | MÓDULO USUARIOS | ALTA |
| HUA-004 | Como usuario, quiero buscar usuarios con cuentas en mora fácilmente | BÚSQUEDA MOROSOS | MEDIA |
| HUA-005 | Como usuario, quiero realizar el proceso de facturación por sectores | FACTURACIÓN | ALTA |
| HUA-006 | Como usuario, quiero generar lista de sectores con consumo mensual | LISTA SECTORES | MEDIA |
| HUA-007 | Como usuario, quiero calcular recaudo por sectores y registrar pagos | RECAUDO | ALTA |
| HUA-008 | Como usuario, quiero modificar costos y medidas del agua | MODIFICAR COSTOS | BAJA |

## Gestión del Proyecto

### Reuniones
- **Planificación del sprint:** Al inicio de cada sprint (definir tareas y responsables)
- **Revisión del sprint:** Al finalizar cada semana (evaluar avances y ajustes)

### Herramientas
- **Tablero Kanban digital:** Seguimiento diario del progreso
- **Repositorio GitHub:** Control de versiones

## Roles del equipo

| Rol | Integrante |
|-----|------------|
| Desarrollador full-stack | Luis Felipe Santacruz Chinchajoa |
| Desarrollador full-stack | Jhon Hector Roque Males |
| Desarrollador full-stack | Jesus Gabriel Jimenez Ceron |
| Docente guía | Francisco Solarte |