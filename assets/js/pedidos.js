// Función para alternar el menú lateral
document.getElementById("sidebarToggle").addEventListener("click", function () {
  document.getElementById("sidebar").classList.toggle("collapsed");
  document.querySelector(".main-content").classList.toggle("expanded");
});

$(document).ready(function() {
    // Inicializar DataTable
    const tablaPedidos = $('#tabla-pedidos').DataTable({
        responsive: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    // Manejar clic en botón de eliminar
    $(document).on('click', '.btn-danger', function() {
        const fila = $(this).closest('tr');
        const id = fila.find('td:eq(0)').text();
        const cliente = fila.find('td:eq(1)').text();

        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar el pedido de "${cliente}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realizar la petición AJAX para cambiar el estado
                fetch('../../controllers/cambiar_estado_pedido.php', {
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
                            'El pedido ha sido eliminado.',
                            'success'
                        ).then(() => {
                            // Eliminar la fila de la tabla
                            tablaPedidos.row(fila).remove().draw();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar el pedido.',
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
});