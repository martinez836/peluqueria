$(document).ready(function() {
    // Inicializar DataTable
    const tablaServicios = $('#tabla-servicios').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        responsive: true,
        dom: 'Bfrtip',
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        order: [[0, 'desc']]
    });

    // Función para ver detalles del servicio
    $(document).on('click', '.btn-primary', function() {
        const fila = $(this).closest('tr');
        const id = fila.find('td:eq(0)').text();
        const nombre = fila.find('td:eq(1)').text();
        const descripcion = fila.find('td:eq(2)').text();

        // Aquí puedes implementar la lógica para mostrar los detalles
        // Por ejemplo, en un modal
        alert(`Detalles del Servicio:\nID: ${id}\nNombre: ${nombre}\nDescripción: ${descripcion}`);
    });

    // Función para editar servicio
    $(document).on('click', '.btn-success', function() {
        const fila = $(this).closest('tr');
        const id = fila.find('td:eq(0)').text();
        const nombreServicio = fila.find('td:eq(1)').text();
        const descripcion = fila.find('td:eq(2)').text();

        // Limpiar el formulario
        $('#editarServicioForm')[0].reset();

        // Llenar el formulario con los datos actuales
        $('#editId').val(id);
        $('#editNombreServicio').val(nombreServicio);
        $('#editDescripcion').val(descripcion);

        // Mostrar la modal
        $('#editarServicioModal').modal('show');
    });

    // Manejar clic en botón de eliminar
    $(document).on('click', '.btn-danger', function() {
        const fila = $(this).closest('tr');
        const id = fila.find('td:eq(0)').text();
        const nombre = fila.find('td:eq(1)').text();

        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar el servicio "${nombre}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realizar la petición AJAX para cambiar el estado
                fetch('../../controllers/cambiar_estado_servicio.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id,
                        estado: 'inactivo'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            '¡Eliminado!',
                            'El servicio ha sido eliminado.',
                            'success'
                        ).then(() => {
                            // Eliminar la fila de la tabla
                            tablaServicios.row(fila).remove().draw();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar el servicio.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error',
                        'Hubo un error al procesar la solicitud.',
                        'error'
                    );
                });
            }
        });
    });

    // Mostrar mensajes de éxito o error si existen en la URL
    const urlParams = new URLSearchParams(window.location.search);
    const mensaje = urlParams.get('mensaje');
    const error = urlParams.get('error');

    if (mensaje) {
        alert(mensaje);
    }
    if (error) {
        alert(error);
    }

    // Manejar el guardado de cambios
    $('#guardarCambios').click(function() {
        const formData = {
            id: $('#editId').val(),
            nombreServicio: $('#editNombreServicio').val(),
            descripcion: $('#editDescripcion').val()
        };

        $.ajax({
            url: '../../controllers/actualizar_servicio.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#editarServicioModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message || 'Error al actualizar el servicio');
                }
            },
            error: function() {
                alert('Error al actualizar el servicio');
            }
        });
    });
}); 