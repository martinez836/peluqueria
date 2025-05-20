let fechasSeleccionadas = [];

document.addEventListener('DOMContentLoaded', function () {
    
    const calendar = document.getElementById('calendar');

    calendar.addEventListener('click', function (e) {
        if (e.target.classList.contains('celda-dia') && !e.target.classList.contains('deshabilitado')) {
            const dia = e.target.textContent;
            const mes = new Date().getMonth();
            const anio = new Date().getFullYear();

            const fecha = `${anio}-${String(mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;

            if (fechasSeleccionadas.includes(fecha)) {
                fechasSeleccionadas = fechasSeleccionadas.filter(f => f !== fecha);
                e.target.classList.remove('active');
            } else {
                fechasSeleccionadas.push(fecha);
                e.target.classList.add('active');
            }
        }
    });

    document.getElementById('form-fechas').addEventListener('submit', function (e) {
        if (fechasSeleccionadas.length === 0) {
            e.preventDefault();
            alert('Selecciona al menos una fecha para deshabilitar.');
            return;
        }

        document.getElementById('fechas-deshabilitadas').value = JSON.stringify(fechasSeleccionadas);
    });
});
