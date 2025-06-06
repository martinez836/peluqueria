// Función para alternar el menú lateral
document.getElementById("sidebarToggle").addEventListener("click", function () {
  document.getElementById("sidebar").classList.toggle("collapsed");
  document.querySelector(".main-content").classList.toggle("expanded");
});

$(document).ready(function() {
    // Inicializar DataTable
    const tablaPedidos = $('#tabla-pedidos').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']]
    });

    // Manejar clic en botón de eliminar
    $(document).on('click', '.eliminarPedido', function() {
        const idPedido = $(this).data('id');
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas eliminar este pedido? Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar solicitud para eliminar el pedido
                $.ajax({
                    url: '../../controllers/eliminarPedido.php',
                    type: 'POST',
                    data: { idPedido: idPedido },
                    success: function(response) {
                        if(response.success) {
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: 'El pedido ha sido eliminado correctamente.',
                                icon: 'success',
                                confirmButtonColor: '#daa520'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message || 'Hubo un error al eliminar el pedido.',
                                icon: 'error',
                                confirmButtonColor: '#daa520'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un error en la conexión con el servidor.',
                            icon: 'error',
                            confirmButtonColor: '#daa520'
                        });
                    }
                });
            }
        });
    });
});