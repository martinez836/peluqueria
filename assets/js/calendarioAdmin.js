let fechasSeleccionadas = [];

// Cargar las fechas deshabilitadas desde el servidor
function cargarFechasDeshabilitadas() {
    return fetch("/peluqueria/controllers/fechasDeshabilitadas.php")  // Asegúrate de que la URL sea la correcta
        .then(response => response.json())
        .catch(error => {
            console.error('Error al cargar las fechas deshabilitadas:', error);
            return [];  // Si hay un error, retornamos un array vacío
        });
}

document.addEventListener("DOMContentLoaded", function () {
    // Llamamos a cargarFechasDeshabilitadas al cargar la página
    cargarFechasDeshabilitadas().then(fechasDeshabilitadas => {
        // Aquí ya tenemos las fechas deshabilitadas en el array `fechasDeshabilitadas`
        const diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        const calendar = document.getElementById('calendar');
        const mesTitulo = document.getElementById('mes-titulo');
        const hoy = new Date();

        const mesActual = hoy.getMonth();
        const anioActual = hoy.getFullYear();
        const primerDia = new Date(anioActual, mesActual, 1);
        const ultimoDia = new Date(anioActual, mesActual + 1, 0);
        const totalDias = ultimoDia.getDate();

        mesTitulo.textContent = hoy.toLocaleDateString('es-ES', { month: 'long', year: 'numeric' });

        // Encabezado de días
        diasSemana.forEach(dia => {
            const div = document.createElement('div');
            div.className = 'encabezado-dia';
            div.textContent = dia;
            calendar.appendChild(div);
        });

        // Crear celdas vacías al principio si el mes no comienza en domingo
        for (let i = 0; i < primerDia.getDay(); i++) {
            const vacio = document.createElement('div');
            calendar.appendChild(vacio);
        }

        // Crear celdas de días
        for (let dia = 1; dia <= totalDias; dia++) {
            const fecha = new Date(anioActual, mesActual, dia);
            const celda = document.createElement('div');
            celda.className = 'celda-dia';
            celda.textContent = dia;

            // Convertir la fecha a formato YYYY-MM-DD
            const fechaTexto = `${anioActual}-${String(mesActual + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;

            // Deshabilitar fechas pasadas
            const hoySinHora = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate());
            if (fecha < hoySinHora) {
                celda.classList.add('deshabilitado');
            }

            // Deshabilitar las fechas que están en el array de fechas deshabilitadas
            if (fechasDeshabilitadas.includes(fechaTexto)) {
                celda.classList.add('deshabilitado');
                celda.classList.add('bg-danger');  // Puedes agregar clases para cambiar el color de la celda
                celda.style.cursor = 'not-allowed';  // Para hacer que no sea seleccionable
            }

            // Agregar evento de clic para seleccionar las fechas
            celda.addEventListener('click', () => {
                if (fecha < hoySinHora || celda.classList.contains('deshabilitado')) return;  // No permitir seleccionar fechas pasadas o deshabilitadas

                const fechaTexto = `${anioActual}-${String(mesActual + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;

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

            // Agregar la celda al calendario
            calendar.appendChild(celda);
        }
    });
});

// Modificar la función de evento submit hacia el final del archivo
document.getElementById('form-fechas').addEventListener('submit', function (e) {
    // Solo prevenir el envío del formulario si no hay fechas seleccionadas
    if (fechasSeleccionadas.length === 0) {
        e.preventDefault();
        alert('Selecciona al menos una fecha para deshabilitar.');
        return;
    }
    
    // Asignar las fechas seleccionadas al input hidden
    document.getElementById('fechas-deshabilitadas').value = JSON.stringify(fechasSeleccionadas);
    
    // Permitir que el formulario se envíe normalmente
    // No es necesario hacer nada más, el formulario se enviará automáticamente
});
