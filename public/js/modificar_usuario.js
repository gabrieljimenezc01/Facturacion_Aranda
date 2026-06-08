// ============================================
// modificar-usuario.js - Funciones para el módulo de modificar usuario
// ============================================

// Función para cargar órdenes dinámicamente según el sector
function inicializarOrdenesDinamicas() {
    const sectorInput = document.getElementById('sector');
    if (!sectorInput) return;
    
    const ordenSelect = document.getElementById('orden');
    if (!ordenSelect) return;

    // Obtener variables globales definidas desde PHP
    const ordenActual = window.ordenActual || null;
    const sectorOriginal = window.sectorOriginal || '';

    function cargarOrdenes(sector, forzar) {
        fetch(window.PUBLIC_URL + '/index.php?page=obtener_ordenes&sector=' + encodeURIComponent(sector))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error HTTP: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                ordenSelect.innerHTML = '<option value="ninguna">Ninguna</option>';
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(orden => {
                        orden = parseInt(orden);
                        if (!isNaN(orden)) {
                            const option = document.createElement('option');
                            option.value = orden;
                            option.textContent = orden;
                            ordenSelect.appendChild(option);
                        }
                    });
                }

                // Seleccionar la orden actual si existe y no se está forzando
                if (ordenActual !== null && ordenActual !== " " && forzar !== true) {
                    ordenSelect.value = ordenActual;
                }
            })
            .catch(error => {
                console.error('Error obteniendo órdenes:', error);
            });
    }

    // Cargar órdenes al inicio si hay un sector
    if (sectorInput.value.trim()) {
        cargarOrdenes(sectorInput.value.trim(), false);
    }

    // Escuchar cambios en el campo sector
    sectorInput.addEventListener('input', () => {
        const sector = sectorInput.value.trim();
        if (sector !== '') {
            const forzar = (sector !== sectorOriginal);
            cargarOrdenes(sector, forzar);
        } else {
            ordenSelect.innerHTML = '<option value="ninguna">Ninguna</option>';
        }
    });
}

// Función para inicializar validaciones del formulario
function inicializarValidaciones() {
    const form = document.querySelector('form');
    if (!form) return;

    const campos = {
        nombre: { id: 'nombre', errorId: 'error-nombre', mensaje: 'El nombre es obligatorio.' },
        apellido: { id: 'apellido', errorId: 'error-apellido', mensaje: 'El apellido es obligatorio.' },
        direccion: { id: 'direccion', errorId: 'error-direccion', mensaje: 'La dirección es obligatoria.' },
        estrato: { id: 'estrato', errorId: 'error-estrato', mensaje: 'El estrato es obligatorio.' },
        sector: { id: 'sector', errorId: 'error-sector', mensaje: 'El sector es obligatorio.', tipo: 'numerico' },
        uso: { id: 'uso', errorId: 'error-uso', mensaje: 'El uso es obligatorio.' },
        codigo_medidor: { id: 'codigo_medidor', errorId: 'error-codigo-medidor', mensaje: 'El código del medidor es obligatorio.', tipo: 'codigo' },
        diametro_medidor: { id: 'diametro_medidor', errorId: 'error-diametro-medidor', mensaje: 'El diámetro del medidor es obligatorio.' }
    };

    // Agregar event listeners para validación en tiempo real
    for (const [key, config] of Object.entries(campos)) {
        const campo = document.getElementById(config.id);
        const errorElement = document.getElementById(config.errorId);
        
        if (campo && errorElement) {
            const evento = (key === 'estrato' || key === 'uso') ? 'change' : 'input';
            campo.addEventListener(evento, function() {
                if (config.tipo === 'numerico') {
                    validarCampoNumerico(campo, errorElement, config.mensaje, 'El sector debe ser un número.');
                } else if (config.tipo === 'codigo') {
                    validarCampoCodigoMedidor(campo, errorElement, config.mensaje, 'El código del medidor solo puede contener letras y números.', 'El código del medidor no puede tener más de 50 caracteres.');
                } else {
                    validarCampoVacio(campo, errorElement, config.mensaje);
                }
            });
        }
    }

    // Validar formulario al enviar
    form.addEventListener('submit', function(event) {
        if (!validarFormularioCompleto()) {
            event.preventDefault();
        }
    });
}

// Funciones de validación
function validarCampoVacio(campo, errorElement, mensajeError) {
    if (!campo.value.trim()) {
        errorElement.textContent = mensajeError;
        return false;
    } else {
        errorElement.textContent = '';
        return true;
    }
}

function validarCampoCodigoMedidor(campo, errorElement, mensajeVacio, mensajeInvalido, mensajeLongitud) {
    const regex = /^[a-zA-Z0-9]*$/;
    if (!campo.value.trim()) {
        errorElement.textContent = mensajeVacio;
        return false;
    } else if (!regex.test(campo.value)) {
        errorElement.textContent = mensajeInvalido;
        return false;
    } else if (campo.value.length > 50) {
        errorElement.textContent = mensajeLongitud;
        return false;
    } else {
        errorElement.textContent = '';
        return true;
    }
}

function validarCampoNumerico(campo, errorElement, mensajeVacio, mensajeTipo) {
    if (!campo.value.trim()) {
        errorElement.textContent = mensajeVacio;
        return false;
    } else if (isNaN(campo.value)) {
        errorElement.textContent = mensajeTipo;
        return false;
    } else {
        errorElement.textContent = '';
        return true;
    }
}

function validarFormularioCompleto() {
    let valido = true;

    // Validar nombre
    const nombre = document.getElementById('nombre');
    const errorNombre = document.getElementById('error-nombre');
    if (!validarCampoVacio(nombre, errorNombre, 'El nombre es obligatorio.')) valido = false;

    // Validar apellido
    const apellido = document.getElementById('apellido');
    const errorApellido = document.getElementById('error-apellido');
    if (!validarCampoVacio(apellido, errorApellido, 'El apellido es obligatorio.')) valido = false;

    // Validar dirección
    const direccion = document.getElementById('direccion');
    const errorDireccion = document.getElementById('error-direccion');
    if (!validarCampoVacio(direccion, errorDireccion, 'La dirección es obligatoria.')) valido = false;

    // Validar estrato
    const estrato = document.getElementById('estrato');
    const errorEstrato = document.getElementById('error-estrato');
    if (!validarCampoVacio(estrato, errorEstrato, 'El estrato es obligatorio.')) valido = false;

    // Validar sector
    const sector = document.getElementById('sector');
    const errorSector = document.getElementById('error-sector');
    if (!validarCampoNumerico(sector, errorSector, 'El sector es obligatorio.', 'El sector debe ser un número.')) valido = false;

    // Validar uso
    const uso = document.getElementById('uso');
    const errorUso = document.getElementById('error-uso');
    if (!validarCampoVacio(uso, errorUso, 'El uso es obligatorio.')) valido = false;

    // Validar código medidor
    const codigoMedidor = document.getElementById('codigo_medidor');
    const errorCodigoMedidor = document.getElementById('error-codigo-medidor');
    if (!validarCampoCodigoMedidor(codigoMedidor, errorCodigoMedidor, 'El código del medidor es obligatorio.', 'El código del medidor solo puede contener letras y números.', 'El código del medidor no puede tener más de 50 caracteres.')) valido = false;

    // Validar diámetro medidor
    const diametroMedidor = document.getElementById('diametro_medidor');
    const errorDiametroMedidor = document.getElementById('error-diametro-medidor');
    if (!validarCampoVacio(diametroMedidor, errorDiametroMedidor, 'El diámetro del medidor es obligatorio.')) valido = false;

    return valido;
}

// Inicializar todo cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    inicializarOrdenesDinamicas();
    inicializarValidaciones();
});

function cerrar() {    
    // CORREGIDO: Usar la URL base + logout
    window.location.href = PUBLIC_URL + '/index.php?page=logout';
}