let fechasSeleccionadas = [];
let mesActual = new Date().getMonth();
let anioActual = new Date().getFullYear();

// Cargar las fechas deshabilitadas desde el servidor
function cargarFechasDeshabilitadas() {
    return fetch("/peluqueria/controllers/fechasDeshabilitadas.php")
        .then(response => response.json())
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
        }

        // Deshabilitar fechas desde el servidor
        if (fechasDeshabilitadas.includes(fechaTexto)) {
            celda.classList.add('deshabilitado', 'bg-danger');
            celda.style.cursor = 'not-allowed';
        }

        // Selección de fechas
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
    cargarFechasDeshabilitadas().then(generarCalendario);
});

// Navegar al mes siguiente
document.getElementById('mes-siguiente').addEventListener('click', () => {
    mesActual++;
    if (mesActual > 11) {
        mesActual = 0;
        anioActual++;
    }
    cargarFechasDeshabilitadas().then(generarCalendario);
});

// Inicializar calendario
document.addEventListener('DOMContentLoaded', () => {
    cargarFechasDeshabilitadas().then(generarCalendario);
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
