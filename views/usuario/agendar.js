document.addEventListener("DOMContentLoaded", function () {
    const diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    const calendar = document.getElementById('calendar');
    const mesTitulo = document.getElementById('mes-titulo');
    const hoy = new Date();

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
        const celda = document.createElement('div');
        celda.className = 'celda-dia';
        celda.textContent = dia;

        celda.addEventListener('click', () => {
            // Formato yyyy-mm-dd
            const fechaTexto = `${anioActual}-${String(mesActual + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
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