// Logica para asignar opciones de orden dinamicamente
document.getElementById('sector').addEventListener('input', function () {
    const sector = this.value.trim();
    const ordenSelect = document.getElementById('orden');

    // Limpia el combobox
    ordenSelect.innerHTML = '<option value="ninguna" selected>Ninguna</option>';

    if (sector !== '') {
        fetch(`obtener_ordenes.php?sector=${encodeURIComponent(sector)}`)
            .then(response => response.json())
            .then(ordenes => {
                if (ordenes.length > 0) {
                    ordenes.forEach(ord => {
                        const opt = document.createElement('option');
                        opt.value = ord;
                        opt.textContent = ord;
                        ordenSelect.appendChild(opt);
                    });
                }
            })
            .catch(error => {
                console.error('Error obteniendo órdenes por sector:', error);
            });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const nombre = document.getElementById('nombre');
    const apellido = document.getElementById('apellido');
    const direccion = document.getElementById('direccion');
    const estrato = document.getElementById('estrato');
    const sector = document.getElementById('sector');
    const uso = document.getElementById('uso');
    const codigo_medidor = document.getElementById('codigo_medidor');
    const diametro_medidor = document.getElementById('diametro_medidor');
    
    const errorNombre = document.getElementById('error-nombre');
    const errorApellido = document.getElementById('error-apellido');
    const errorDireccion = document.getElementById('error-direccion');
    const errorEstrato = document.getElementById('error-estrato');
    const errorSector = document.getElementById('error-sector');
    const errorUso = document.getElementById('error-uso');
    const errorCodigoMedidor = document.getElementById('error-codigo-medidor');
    const errorDiametroMedidor = document.getElementById('error-diametro-medidor');

    nombre.addEventListener('input', function () {
        validarCampoVacio(nombre, errorNombre, 'El nombre es obligatorio.');
    });

    apellido.addEventListener('input', function () {
        validarCampoVacio(apellido, errorApellido, 'El apellido es obligatorio.');
    });

    direccion.addEventListener('input', function () {
        validarCampoVacio(direccion, errorDireccion, 'La dirección es obligatoria.');
    });

    estrato.addEventListener('change', function () {
        validarCampoVacio(estrato, errorEstrato, 'El estrato es obligatorio.');
    });

    sector.addEventListener('input', function () {
        validarCampoNumerico(sector, errorSector, 'El sector es obligatorio.', 'El sector debe ser un número.');
    });

    uso.addEventListener('change', function () {
        validarCampoVacio(uso, errorUso, 'El uso es obligatorio.');
    });

    codigo_medidor.addEventListener('input', function () {
        validarCampoCodigoMedidor(codigo_medidor, errorCodigoMedidor, 'El código del medidor es obligatorio.', 'El código del medidor solo puede contener letras y números.', 'El código del medidor no puede tener más de 50 caracteres.');
    });

    diametro_medidor.addEventListener('input', function () {
        validarCampoVacio(diametro_medidor, errorDiametroMedidor, 'El diámetro del medidor es obligatorio.');
    });

    form.addEventListener('submit', function (event) {
        if (!validarFormulario()) {
            event.preventDefault();
        }
    });
});

function validarCampoVacio(campo, errorElement, mensajeError) {
    if (!campo.value.trim()) {
        errorElement.textContent = mensajeError;
    } else {
        errorElement.textContent = '';
    }
}

function validarCampoCodigoMedidor(campo, errorElement, mensajeVacio, mensajeInvalido, mensajeLongitud) {
    const regex = /^[a-zA-Z0-9]*$/;
    if (!campo.value.trim()) {
        errorElement.textContent = mensajeVacio;
    } else if (!regex.test(campo.value)) {
        errorElement.textContent = mensajeInvalido;
    } else if (campo.value.length > 50) {
        errorElement.textContent = mensajeLongitud;
    } else {
        errorElement.textContent = '';
    }
}

function validarCampoNumerico(campo, errorElement, mensajeVacio, mensajeTipo) {
    if (!campo.value.trim()) {
        errorElement.textContent = mensajeVacio;
    } else if (isNaN(campo.value)) {
        errorElement.textContent = mensajeTipo;
    } else {
        errorElement.textContent = '';
    }
}

function validarFormulario() {
    let valido = true;

    if (!document.getElementById('nombre').value.trim()) {
        document.getElementById('error-nombre').textContent = 'El nombre es obligatorio.';
        valido = false;
    }
    if (!document.getElementById('apellido').value.trim()) {
        document.getElementById('error-apellido').textContent = 'El apellido es obligatorio.';
        valido = false;
    }
    if (!document.getElementById('direccion').value.trim()) {
        document.getElementById('error-direccion').textContent = 'La dirección es obligatoria.';
        valido = false;
    }
    if (!document.getElementById('estrato').value.trim()) {
        document.getElementById('error-estrato').textContent = 'El estrato es obligatorio.';
        valido = false;
    }
    if (!document.getElementById('sector').value.trim()) {
        document.getElementById('error-sector').textContent = 'El sector es obligatorio.';
        valido = false;
    } else if (isNaN(document.getElementById('sector').value)) {
        document.getElementById('error-sector').textContent = 'El sector debe ser un número.';
        valido = false;
    }
    if (!document.getElementById('uso').value.trim()) {
        document.getElementById('error-uso').textContent = 'El uso es obligatorio.';
        valido = false;
    }
    if (!document.getElementById('codigo_medidor').value.trim()) {
        document.getElementById('error-codigo-medidor').textContent = 'El código del medidor es obligatorio.';
        valido = false;
    } else if (!/^[a-zA-Z0-9]*$/.test(document.getElementById('codigo_medidor').value)) {
        document.getElementById('error-codigo-medidor').textContent = 'El código del medidor solo puede contener letras y números.';
        valido = false;
    }
    if (!document.getElementById('diametro_medidor').value.trim()) {
        document.getElementById('error-diametro-medidor').textContent = 'El diámetro del medidor es obligatorio.';
        valido = false;
    }

    return valido;
}

function cerrar(){    
    setTimeout(function(){ window.location = "../auth/logout.php"; }, 0);
}