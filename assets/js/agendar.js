document.addEventListener("DOMContentLoaded", () => {
    const diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    const calendar = document.getElementById('calendar');
    const mesTitulo = document.getElementById('mes-titulo');
    const controles = document.getElementById('calendar-controls');
    const hoy = new Date();
    let mesActual = hoy.getMonth();
    let anioActual = hoy.getFullYear();
    const hoySinHora = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate());

    // Crear botones de navegación
    const btnAnterior = document.createElement('button');
    btnAnterior.innerHTML = '❮';
    btnAnterior.className = 'btn btn-outline-dark';
    btnAnterior.addEventListener('click', () => {
        if (mesActual === 0) {
            mesActual = 11;
            anioActual--;
        } else {
            mesActual--;
        }
        renderizarCalendario(mesActual, anioActual);
    });

    const btnSiguiente = document.createElement('button');
    btnSiguiente.innerHTML = '❯';
    btnSiguiente.className = 'btn btn-outline-dark';
    btnSiguiente.addEventListener('click', () => {
        if (mesActual === 11) {
            mesActual = 0;
            anioActual++;
        } else {
            mesActual++;
        }
        renderizarCalendario(mesActual, anioActual);
    });

    // Insertar botones al DOM
    controles.appendChild(btnAnterior);
    controles.appendChild(btnSiguiente);

    function renderizarCalendario(mes, anio) {
        calendar.innerHTML = '';

        // Título del mes
        mesTitulo.textContent = new Date(anio, mes).toLocaleDateString('es-ES', {
            month: 'long',
            year: 'numeric'
        });

        // Encabezado de días
        diasSemana.forEach(dia => {
            const div = document.createElement('div');
            div.className = 'encabezado-dia';
            div.textContent = dia;
            calendar.appendChild(div);
        });

        const primerDia = new Date(anio, mes, 1);
        const ultimoDia = new Date(anio, mes + 1, 0);
        const totalDias = ultimoDia.getDate();

        for (let i = 0; i < primerDia.getDay(); i++) {
            const vacio = document.createElement('div');
            calendar.appendChild(vacio);
        }

        for (let dia = 1; dia <= totalDias; dia++) {
            const fecha = new Date(anio, mes, dia);
            const celda = document.createElement('div');
            celda.className = 'celda-dia';
            celda.textContent = dia;

            if (fecha < hoySinHora) {
                celda.classList.add('deshabilitado');
            }

            celda.addEventListener('click', () => {
                if (fecha < hoySinHora) return;

                document.querySelectorAll('.celda-dia').forEach(c => c.classList.remove('active'));
                celda.classList.add('active');

                document.getElementById('fecha-seleccionada').textContent = fecha.toLocaleDateString('es-ES', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                const fechaTexto = `${anio}-${String(mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
                document.getElementById('input-fecha').value = fechaTexto;
            });

            calendar.appendChild(celda);
        }
    }

    renderizarCalendario(mesActual, anioActual);
});
