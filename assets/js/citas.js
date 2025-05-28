/* Script para mejorar la funcionalidad responsive */
document.addEventListener('DOMContentLoaded', function() {
    // Función para alternar el menú lateral

    // Toggle para el sidebar en móviles y desktop
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            // Cambia 'active' por 'collapsed' para que coincida con tu CSS
            sidebar.classList.toggle('collapsed');
            document.body.classList.toggle('sidebar-collapsed');
        });
    }
    
    // Cerrar sidebar al hacer clic fuera de él en móviles
    document.addEventListener('click', function(event) {
        const isMobile = window.innerWidth <= 768;
        const clickedOutsideSidebar = !sidebar.contains(event.target);
        const clickedOnToggle = sidebarToggle.contains(event.target);
        
        // Actualizado para usar 'collapsed' en lugar de 'active'
        if (isMobile && sidebar.classList.contains('collapsed') && clickedOutsideSidebar && !clickedOnToggle) {
            sidebar.classList.remove('collapsed');
            document.body.classList.remove('sidebar-collapsed');
        }
    });
    
    // Ajustar altura de la tabla según la altura de la ventana en móviles
    function adjustTableHeight() {
        const tableSection = document.querySelector('.table-section');
        const detallesSection = document.querySelector('.detalles-section');
        
        if (window.innerWidth <= 576 && tableSection && detallesSection) {
            const windowHeight = window.innerHeight;
            const headerHeight = document.querySelector('.main-header').offsetHeight;
            const contentHeaderHeight = document.querySelector('.content-header').offsetHeight;
            const statsRowHeight = document.querySelector('.stats-row').offsetHeight;
            const searchBarHeight = document.querySelector('.search-bar').offsetHeight;
            
            // Calcular altura disponible (restar padding)
            const availableHeight = windowHeight - headerHeight - contentHeaderHeight - statsRowHeight - searchBarHeight - 100;
            
            // Aplicar altura máxima a la tabla
            const citasTable = document.querySelector('.citas-table');
            if (citasTable) {
                citasTable.style.maxHeight = (availableHeight * 0.4) + 'px';
                citasTable.style.overflowY = 'auto';
            }
        }
    }
    
    // Llamar al ajuste de altura inicialmente y en cambios de tamaño
    adjustTableHeight();
    window.addEventListener('resize', adjustTableHeight);
    
    // Fix para evitar que los clicks en los botones de acción afecten a la fila
    const actionButtons = document.querySelectorAll('.actions button');
    if (actionButtons) {
        actionButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    }
});
$(document).ready(function() {
    // Inicializar DataTable
    const tablaCitas = $('#tabla-pedidos').DataTable({
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
            text: `¿Deseas eliminar la cita de "${cliente}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realizar la petición AJAX para cambiar el estado
                fetch('../../controllers/cambiar_estado_cita.php', {
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
                            'La cita ha sido eliminada.',
                            'success'
                        ).then(() => {
                            // Eliminar la fila de la tabla
                            tablaCitas.row(fila).remove().draw();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar la cita.',
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

  