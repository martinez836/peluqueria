document.addEventListener("DOMContentLoaded", () => {
    const diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    const mesesNombres = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                         'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    
    const calendar = document.getElementById('calendar');
    const mesTitulo = document.getElementById('mes-titulo');
    const controles = document.getElementById('calendar-controls');
    const fechaSeleccionadaSpan = document.getElementById('fecha-seleccionada');
    const inputFecha = document.getElementById('input-fecha');
    
    // Verificar que todos los elementos existan
    if (!calendar || !mesTitulo || !controles) {
        console.error('Elementos del calendario no encontrados');
        return;
    }

    const hoy = new Date();
    let mesActual = hoy.getMonth();
    let anioActual = hoy.getFullYear();
    const hoySinHora = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate());

    // Fechas deshabilitadas recibidas desde PHP
    const fechasDeshabilitadas = window.fechasDeshabilitadas || [];
    console.log('Fechas deshabilitadas:', fechasDeshabilitadas);

    // Función mejorada para verificar si un día está deshabilitado
    const esDiaDeshabilitado = (fechaTexto) => {
        return fechasDeshabilitadas.includes(fechaTexto);
    };

    // Función para formatear fecha en español
    const formatearFechaEspanol = (fecha) => {
        const diasSemanaCompletos = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        const dia = diasSemanaCompletos[fecha.getDay()];
        const diaNumero = fecha.getDate();
        const mes = mesesNombres[fecha.getMonth()].toLowerCase();
        const anio = fecha.getFullYear();
        
        return `${dia}, ${diaNumero} de ${mes} de ${anio}`;
    };

    // Crear botones de navegación
    const btnAnterior = document.createElement('button');
    btnAnterior.innerHTML = '&laquo; Anterior';
    btnAnterior.className = 'btn btn-outline-secondary btn-sm';
    btnAnterior.style.fontSize = '14px';
    btnAnterior.addEventListener('click', () => {
        if (mesActual === 0) {
            mesActual = 11;
            anioActual = anioActual - 1;
        } else {
            mesActual = mesActual - 1;
        }
        renderizarCalendario(mesActual, anioActual);
    });

    const btnSiguiente = document.createElement('button');
    btnSiguiente.innerHTML = 'Siguiente &raquo;';
    btnSiguiente.className = 'btn btn-outline-secondary btn-sm';
    btnSiguiente.style.fontSize = '14px';
    btnSiguiente.addEventListener('click', () => {
        if (mesActual === 11) {
            mesActual = 0;
            anioActual = anioActual + 1;
        } else {
            mesActual = mesActual + 1;
        }
        renderizarCalendario(mesActual, anioActual);
    });

    // Limpiar controles previos y agregar botones
    controles.innerHTML = '';
    controles.appendChild(btnAnterior);
    controles.appendChild(btnSiguiente);

    function renderizarCalendario(mes, anio) {
        // Limpiar calendario
        calendar.innerHTML = '';

        // Actualizar título del mes
        const tituloMes = `${mesesNombres[mes]} ${anio}`;
        mesTitulo.textContent = tituloMes;
        mesTitulo.style.textTransform = 'capitalize';

        // Crear encabezados de días de la semana
        diasSemana.forEach(dia => {
            const div = document.createElement('div');
            div.className = 'encabezado-dia';
            div.textContent = dia;
            div.style.fontWeight = 'bold';
            div.style.backgroundColor = '#f8f9fa';
            div.style.border = '1px solid #ddd';
            div.style.padding = '8px 0';
            div.style.fontSize = '14px';
            calendar.appendChild(div);
        });

        // Calcular días del mes
        const primerDia = new Date(anio, mes, 1);
        const ultimoDia = new Date(anio, mes + 1, 0);
        const totalDias = ultimoDia.getDate();
        const diaSemanaInicio = primerDia.getDay(); // 0 = domingo, 1 = lunes, etc.

        // Agregar celdas vacías al inicio si es necesario
        for (let i = 0; i < diaSemanaInicio; i++) {
            const vacio = document.createElement('div');
            vacio.style.border = '1px solid transparent';
            calendar.appendChild(vacio);
        }

        // Crear celdas para cada día del mes
        for (let dia = 1; dia <= totalDias; dia++) {
            const fechaCompleta = new Date(anio, mes, dia);
            const fechaTexto = `${anio}-${String(mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
            
            const celda = document.createElement('div');
            celda.className = 'celda-dia';
            celda.textContent = dia;
            celda.dataset.fecha = fechaTexto;
            celda.style.minHeight = '40px';
            celda.style.display = 'flex';
            celda.style.alignItems = 'center';
            celda.style.justifyContent = 'center';

            // Verificar si es una fecha pasada
            const esFechaPasada = fechaCompleta < hoySinHora;
            
            // Verificar si está en las fechas deshabilitadas
            const estaDeshabilitada = esDiaDeshabilitado(fechaTexto);

            // Aplicar estilos según el estado del día
            if (esFechaPasada || estaDeshabilitada) {
                celda.classList.add('deshabilitado');
                celda.style.color = '#999';
                celda.style.cursor = 'not-allowed';
                celda.style.backgroundColor = '#f5f5f5';
                celda.style.pointerEvents = 'none';
            } else {
                celda.style.cursor = 'pointer';
                celda.addEventListener('mouseenter', () => {
                    if (!celda.classList.contains('active')) {
                        celda.style.backgroundColor = '#ffe066';
                    }
                });
                celda.addEventListener('mouseleave', () => {
                    if (!celda.classList.contains('active')) {
                        celda.style.backgroundColor = '';
                    }
                });
            }

            // Resaltar el día actual
            if (fechaCompleta.getTime() === hoySinHora.getTime()) {
                celda.style.fontWeight = 'bold';
                celda.style.border = '2px solid goldenrod';
            }

            calendar.appendChild(celda);
        }
    }

    // Manejar clics en las celdas de días
    calendar.addEventListener("click", (event) => {
        const celda = event.target;
        
        // Verificar que sea una celda de día válida y no esté deshabilitada
        if (!celda.classList.contains("celda-dia") || 
            celda.classList.contains("deshabilitado") || 
            !celda.dataset.fecha) {
            return;
        }

        // Remover selección previa
        document.querySelectorAll('.celda-dia.active').forEach(c => {
            c.classList.remove('active');
            c.style.backgroundColor = '';
            c.style.color = '';
        });

        // Marcar como activo
        celda.classList.add('active');
        celda.style.backgroundColor = 'goldenrod';
        celda.style.color = 'white';

        // Actualizar fecha seleccionada en la interfaz
        const fechaSeleccionada = new Date(celda.dataset.fecha + 'T00:00:00');
        const fechaFormateada = formatearFechaEspanol(fechaSeleccionada);
        
        if (fechaSeleccionadaSpan) {
            fechaSeleccionadaSpan.textContent = fechaFormateada;
            fechaSeleccionadaSpan.style.color = 'goldenrod';
            fechaSeleccionadaSpan.style.fontWeight = 'bold';
        }

        // Actualizar input oculto para el formulario
        if (inputFecha) {
            inputFecha.value = celda.dataset.fecha;
        }

        console.log('Fecha seleccionada:', celda.dataset.fecha);
    });

    // Renderizar calendario inicial
    renderizarCalendario(mesActual, anioActual);
    
    // Mostrar mensaje inicial
    if (fechaSeleccionadaSpan) {
        fechaSeleccionadaSpan.textContent = 'Ninguna fecha seleccionada';
        fechaSeleccionadaSpan.style.color = '#666';
    }

    console.log('Calendario inicializado correctamente');
});