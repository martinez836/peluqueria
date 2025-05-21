document.addEventListener("DOMContentLoaded", async function () {
    // Paso 1: Obtener las fechas deshabilitadas desde PHP
    let fechasDeshabilitadas = [];
    try {
        const res = await fetch('../../controllers/fechasDeshabilitadas.php'); // ajusta la ruta si es necesario
        fechasDeshabilitadas = await res.json();
    } catch (error) {
        console.error("Error al cargar las fechas deshabilitadas:", error);
    }

    const fechasSet = new Set(fechasDeshabilitadas); // formato: 'YYYY-MM-DD'

    const diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    const calendar = document.getElementById('calendar');
    const mesTitulo = document.getElementById('mes-titulo');
    const hoy = new Date();
    const hoySinHora = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate());

    const mesActual = hoy.getMonth();
    const anioActual = hoy.getFullYear();
    const primerDia = new Date(anioActual, mesActual, 1);
    const ultimoDia = new Date(anioActual, mesActual + 1, 0);
    const totalDias = ultimoDia.getDate();

    // Mostrar título del mes
    mesTitulo.textContent = hoy.toLocaleDateString('es-ES', { month: 'long', year: 'numeric' });

    // Encabezados de los días de la semana
    diasSemana.forEach(dia => {
        const div = document.createElement('div');
        div.className = 'encabezado-dia';
        div.textContent = dia;
        calendar.appendChild(div);
    });

    // Espacios vacíos antes del primer día del mes
    for (let i = 0; i < primerDia.getDay(); i++) {
        const vacio = document.createElement('div');
        calendar.appendChild(vacio);
    }

    // Días del mes
    for (let dia = 1; dia <= totalDias; dia++) {
        const fecha = new Date(anioActual, mesActual, dia);
        const fechaTexto = `${anioActual}-${String(mesActual + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
        const celda = document.createElement('div');
        celda.className = 'celda-dia';
        celda.textContent = dia;

        // Deshabilitar si la fecha es anterior a hoy o está en las fechas del servidor
        if (fecha < hoySinHora || fechasSet.has(fechaTexto)) {
            celda.classList.add('deshabilitado');
        }

        celda.addEventListener('click', () => {
            if (fecha < hoySinHora || fechasSet.has(fechaTexto)) {
                // No hacer nada si está deshabilitada
                return;
            }

            document.getElementById('fecha-seleccionada').textContent = fecha.toLocaleDateString('es-ES', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
            });
            document.getElementById('input-fecha').value = fechaTexto;

            document.querySelectorAll('.celda-dia').forEach(c => c.classList.remove('active'));
            celda.classList.add('active');
        });

        calendar.appendChild(celda);
    }
});
