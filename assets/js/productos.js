$(document).ready(function() {
    // Inicializar DataTable
    const tablaProductos = $('#tabla-pedidos').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']]
    });

    // Manejar clic en botón de editar
    $(document).on('click', '.btn-success', function() {
        const fila = $(this).closest('tr');
        const id = fila.find('td:eq(0)').text();
        const nombre = fila.find('td:eq(1)').text();
        const precio = fila.find('td:eq(2)').text().replace('$', '').trim();
        const stock = fila.find('td:eq(3)').text();

        // Limpiar el formulario
        $('#editarProductoForm')[0].reset();

        // Llenar el formulario con los datos actuales
        $('#editId').val(id);
        $('#editNombre').val(nombre);
        $('#editPrecio').val(precio);
        $('#editStock').val(stock);

        // Obtener la descripción mediante AJAX
        $.ajax({
            url: '../../controllers/obtener_producto.php',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#editDescripcion').val(response.producto.descripcion);
                    $('#editarProductoModal').modal('show');
                }
            }
        });
    });

    // Manejar clic en botón de eliminar
    $(document).on('click', '.btn-danger', function() {
        const fila = $(this).closest('tr');
        const id = fila.find('td:eq(0)').text();
        const nombre = fila.find('td:eq(1)').text();

        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar el producto "${nombre}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realizar la petición AJAX para cambiar el estado
                fetch('../../controllers/cambiar_estado_producto.php', {
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
                            'El producto ha sido eliminado.',
                            'success'
                        ).then(() => {
                            // Eliminar la fila de la tabla
                            tablaProductos.row(fila).remove().draw();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar el producto.',
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

    // Manejar el guardado de cambios
    $('#guardarCambios').click(function() {
        const formData = new FormData();
        formData.append('id', $('#editId').val());
        formData.append('nombre', $('#editNombre').val());
        formData.append('descripcion', $('#editDescripcion').val());
        formData.append('precio', $('#editPrecio').val());
        formData.append('stock', $('#editStock').val());

        // Agregar imagen solo si se seleccionó una nueva
        const imagen = $('#editImagen')[0].files[0];
        if(imagen) {
            formData.append('imagen', imagen);
        }

        $.ajax({
            url: '../../controllers/actualizar_producto.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#editarProductoModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message || 'Error al actualizar el producto');
                }
            },
            error: function() {
                alert('Error al actualizar el producto');
            }
        });
    });
}); 
