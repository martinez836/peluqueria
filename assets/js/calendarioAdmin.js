let fechasSeleccionadas = [];
let mesActual = new Date().getMonth();
let anioActual = new Date().getFullYear();
let fechasDeshabilitadasGlobal = [];

// Cargar las fechas deshabilitadas desde el servidor
function cargarFechasDeshabilitadas() {
    return fetch("../../controllers/fechasDeshabilitadas.php")
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);
            // Asegurar que el dato es un array de strings y limpio espacios si los hubiera
            if (Array.isArray(data)) {
                return data.map(f => f.trim());
            } else {
                console.error('El formato de las fechas deshabilitadas no es un array:', data);
                return [];
            }
        })
        .catch(error => {
            console.error('Error al cargar las fechas deshabilitadas:', error);
            return [];
        });
}

// Formatea fecha a 'YYYY-MM-DD'
function formatearFecha(fecha) {
    const year = fecha.getFullYear();
    const month = String(fecha.getMonth() + 1).padStart(2, '0');
    const day = String(fecha.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// Genera el calendario del mes actual
function generarCalendario(fechasDeshabilitadas) {
    const diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    const calendar = document.getElementById('calendar');
    const mesTitulo = document.getElementById('mes-titulo');

    calendar.innerHTML = ''; // Limpiar

    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0); // Eliminar la hora para comparar solo fechas

    const primerDia = new Date(anioActual, mesActual, 1);
    const ultimoDia = new Date(anioActual, mesActual + 1, 0);
    const totalDias = ultimoDia.getDate();

    mesTitulo.textContent = primerDia.toLocaleDateString('es-ES', { month: 'long', year: 'numeric' });

    // Encabezados
    diasSemana.forEach(dia => {
        const div = document.createElement('div');
        div.className = 'encabezado-dia';
        div.textContent = dia;
        calendar.appendChild(div);
    });

    // Espacios antes del primer día
    for (let i = 0; i < primerDia.getDay(); i++) {
        const vacio = document.createElement('div');
        calendar.appendChild(vacio);
    }

    // Días del mes
    for (let dia = 1; dia <= totalDias; dia++) {
        const fecha = new Date(anioActual, mesActual, dia);
        const celda = document.createElement('div');
        celda.className = 'celda-dia';
        celda.textContent = dia;

        const fechaTexto = formatearFecha(fecha);

        // Deshabilitar fechas pasadas
        if (fecha < hoy) {
            celda.classList.add('deshabilitado');
            celda.style.cursor = 'not-allowed';
        }

        // Deshabilitar fechas desde el servidor
        if (fechasDeshabilitadas.includes(fechaTexto)) {
            celda.classList.add('deshabilitado', 'bg-danger');
            celda.style.cursor = 'not-allowed';
        }

        // Marcar fechas seleccionadas previamente
        if (fechasSeleccionadas.includes(fechaTexto) && !celda.classList.contains('deshabilitado')) {
            celda.classList.add('active');
            celda.style.cursor = 'pointer';
        }

        // Selección de fechas (solo si no está deshabilitado ni es pasado)
        celda.addEventListener('click', () => {
            if (fecha < hoy || celda.classList.contains('deshabilitado')) return;

            if (celda.classList.contains('active')) {
                celda.classList.remove('active');
                fechasSeleccionadas = fechasSeleccionadas.filter(f => f !== fechaTexto);
            } else {
                celda.classList.add('active');
                if (!fechasSeleccionadas.includes(fechaTexto)) {
                    fechasSeleccionadas.push(fechaTexto);
                }
            }
        });

        calendar.appendChild(celda);
    }
}

// Navegar al mes anterior
document.getElementById('mes-anterior').addEventListener('click', () => {
    mesActual--;
    if (mesActual < 0) {
        mesActual = 11;
        anioActual--;
    }
    generarCalendario(fechasDeshabilitadasGlobal);
});

// Navegar al mes siguiente
document.getElementById('mes-siguiente').addEventListener('click', () => {
    mesActual++;
    if (mesActual > 11) {
        mesActual = 0;
        anioActual++;
    }
    generarCalendario(fechasDeshabilitadasGlobal);
});

// Inicializar calendario
document.addEventListener('DOMContentLoaded', () => {
    cargarFechasDeshabilitadas().then(fechas => {
        fechasDeshabilitadasGlobal = fechas;
        console.log('Fechas deshabilitadas recibidas:', fechasDeshabilitadasGlobal);
        generarCalendario(fechasDeshabilitadasGlobal);
    });
});

// Manejo del formulario
document.getElementById('form-fechas').addEventListener('submit', function (e) {
    if (fechasSeleccionadas.length === 0) {
        e.preventDefault();
        alert('Selecciona al menos una fecha para deshabilitar.');
        return;
    }

    document.getElementById('fechas-deshabilitadas').value = JSON.stringify(fechasSeleccionadas);
});
