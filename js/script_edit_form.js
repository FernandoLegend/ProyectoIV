document.getElementById('formulario').addEventListener('submit', validarFormulario);

function validarFormulario(event) {
    event.preventDefault(); // Previene el envío inmediato del formulario

    const names = document.getElementById('names').value.trim();
    const surnames = document.getElementById('surnames').value.trim();
    const birthdate = document.getElementById('birthdate').value.trim();
    const dateIn = document.getElementById('date_in').value.trim();

    if (!namecheck(names)) {
        mostrarAlerta('Error', 'Nombre inválido, solo letras.');
        return;
    }
    if (!namecheck(surnames)) {
        mostrarAlerta('Error', 'Apellido inválido, solo letras.');
        return;
    }
    if (!datecheck(birthdate) || !datecheck(dateIn)) {
        mostrarAlerta('Error', 'Fecha no válida.');
        return;
    }

    mostrarAlertaExito();
}

function mostrarAlerta(titulo, mensaje) {
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
}

function mostrarAlertaExito() {
    Swal.fire({
        title: 'Éxito',
        text: 'Datos guardados correctamente.',
        icon: 'success',
        confirmButtonText: 'Aceptar'
    }).then(() => {
        document.getElementById('formulario').submit(); // Envía el formulario manualmente
    });
}

// Reimplementación de namecheck en JavaScript
function namecheck(valor) {
    const regex = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
    return regex.test(valor);
}

// Reimplementación de datecheck en JavaScript
function datecheck(valor) {
    const regex = /^\d{4}-\d{2}-\d{2}$/; // formato YYYY-MM-DD
    return regex.test(valor);
}

// Modal de archivos
const modalArchivos = document.getElementById('modalArchivos');
const btnMostrarArchivos = document.getElementById('btnMostrarArchivos');
const btnCerrarModalArchivos = document.getElementById('close_modalarchivos');

btnMostrarArchivos.onclick = function () {
    modalArchivos.style.display = 'block';
};

btnCerrarModalArchivos.onclick = function () {
    modalArchivos.style.display = 'none';
};

window.onclick = function (event) {
    if (event.target === modalArchivos) {
        modalArchivos.style.display = 'none';
    }
};

// Modal de familiares
const modalFamiliares = document.getElementById('modalFamiliares');
const btnAgregarFamiliares = document.getElementById('btnAgregarFamiliares');
const btnCerrarModalFamiliares = document.getElementById('close_modalFamiliares');

btnAgregarFamiliares.onclick = function () {
    modalFamiliares.style.display = 'block';
};

btnCerrarModalFamiliares.onclick = function () {
    modalFamiliares.style.display = 'none';
};

window.onclick = function (event) {
    if (event.target === modalFamiliares) {
        modalFamiliares.style.display = 'none';
    }
};

// Manejo de formulario de familiares
document.getElementById('formFamiliares').addEventListener('submit', function(event) {
    const nombre = document.getElementById('familiar_nombre').value.trim();
    const apellido = document.getElementById('familiar_apellido').value.trim();
    const parentesco = document.getElementById('familiar_parentesco').value;
    const fechaNacimiento = document.getElementById('familiar_fecha_nacimiento').value.trim();

    if (!namecheck(nombre)) {
        mostrarAlerta('Error', 'Nombre inválido, solo se permiten letras.');
        return;
    }
    if (!namecheck(apellido)) {
        mostrarAlerta('Error', 'Apellido inválido, solo se permiten letras.');
        return;
    }
    if (parentesco === "") {
        mostrarAlerta('Error', 'Debe seleccionar un parentesco.');
        return;
    }
    if (!datecheck(fechaNacimiento)) {
        mostrarAlerta('Error', 'Fecha de nacimiento no válida.');
        return;
    }

    mostrarAlertaExito_2();
});

function mostrarAlertaExito_2() {
    Swal.fire({
        title: 'Éxito',
        text: 'Datos del familiar guardados correctamente.',
        icon: 'success',
        confirmButtonText: 'Aceptar'
    }).then(() => {
        document.getElementById('formFamiliares').submit(); 
    });
}

// Subida de archivos con progreso
const form = document.getElementById('uploadForm');
const progressContainer = document.getElementById('progress-container');
const progressBar = document.getElementById('progress-bar');
const progressText = document.getElementById('progress-text');
const status = document.getElementById('status');

form.addEventListener('submit', function (event) {
    const fileInput = document.getElementById('file');
    const file = fileInput.files[0];
    const directoryId = form.querySelector('input[name="directory_id"]').value;

    if (!file) {
        alert('Por favor selecciona un archivo.');
        return;
    }

    const formData = new FormData();
    formData.append('file', file);
    formData.append('directory_id', directoryId);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/proyectoIV/upload_files.php", true);

    xhr.upload.addEventListener('progress', function (e) {
        if (e.lengthComputable) {
            const percentComplete = Math.round((e.loaded / e.total) * 100);
            progressBar.value = percentComplete;
            progressText.textContent = percentComplete + '%';
        }
    });

    progressContainer.style.display = 'block';

    xhr.onload = function () {
        form.querySelector('button[type="submit"]').disabled = false;

        if (xhr.status === 200) {
            status.textContent = '¡Archivo subido exitosamente!';
            progressBar.value = 100;
            progressText.textContent = '100%';
            console.log('Respuesta del servidor:', xhr.responseText);
        } else {
            status.textContent = `Error al subir el archivo. Código: ${xhr.status}`;
            console.error('Error del servidor:', xhr.responseText);
        }
    };

    xhr.onerror = function () {
        form.querySelector('button[type="submit"]').disabled = false;
        status.textContent = 'Error de conexión al subir el archivo.';
    };

    form.querySelector('button[type="submit"]').disabled = true;
    xhr.send(formData);
});