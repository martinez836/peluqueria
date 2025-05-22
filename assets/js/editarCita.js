document.addEventListener('DOMContentLoaded', function() {
    // Obtener referencias a los elementos del modal
    const modal = document.getElementById('editarCitaModal');
    const form = document.getElementById('editarCitaForm');
    const guardarBtn = document.getElementById('guardarCambiosCita');

    // Función para cargar los datos de la cita en el modal
    function cargarDatosCita(boton) {
        const fila = boton.closest('tr');
        const id = fila.querySelector('td:first-child').textContent;
        const nombres = fila.querySelector('td:nth-child(2)').textContent;
        const apellidos = fila.querySelector('td:nth-child(3)').textContent;
        const fecha = fila.querySelector('td:nth-child(4)').textContent;
        const servicio = fila.querySelector('td:nth-child(5)').textContent;
        const estado = fila.querySelector('td:nth-child(6)').textContent;

        // Convertir la fecha al formato datetime-local
        const fechaObj = new Date(fecha);
        const fechaLocal = fechaObj.toISOString().slice(0, 16);

        // Establecer los valores en el formulario
        document.getElementById('editCitaId').value = id;
        document.getElementById('editNombres').value = nombres;
        document.getElementById('editApellidos').value = apellidos;
        document.getElementById('editFecha').value = fechaLocal;

        // Buscar y seleccionar el servicio correcto
        const servicioSelect = document.getElementById('editServicio');
        Array.from(servicioSelect.options).forEach(option => {
            if (option.textContent === servicio) {
                option.selected = true;
            }
        });

        // Seleccionar el estado actual
        document.getElementById('editEstado').value = estado.toLowerCase();
    }

    // Agregar event listener a todos los botones de editar
    document.querySelectorAll('.btn-success.btn-sm').forEach(boton => {
        boton.addEventListener('click', function() {
            cargarDatosCita(this);
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
        });
    });

    // Manejar el guardado de cambios
    guardarBtn.addEventListener('click', function() {
        // Deshabilitar el botón mientras se procesa
        guardarBtn.disabled = true;
        guardarBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

        const formData = new FormData(form);

        fetch('../../controllers/editarCita.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la conexión con el servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Cita actualizada correctamente');
                location.reload();
            } else {
                throw new Error(data.message || 'Error al actualizar la cita');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        })
        .finally(() => {
            // Restaurar el botón
            guardarBtn.disabled = false;
            guardarBtn.innerHTML = 'Guardar cambios';
        });
    });
}); 