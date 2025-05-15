/* Script para mejorar la funcionalidad responsive */
document.addEventListener('DOMContentLoaded', function() {
    // Toggle para el sidebar en móviles
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            document.body.classList.toggle('sidebar-active');
        });
    }
    
    // Cerrar sidebar al hacer clic fuera de él en móviles
    document.addEventListener('click', function(event) {
        const isMobile = window.innerWidth <= 768;
        const clickedOutsideSidebar = !sidebar.contains(event.target);
        const clickedOnToggle = sidebarToggle.contains(event.target);
        
        if (isMobile && sidebar.classList.contains('active') && clickedOutsideSidebar && !clickedOnToggle) {
            sidebar.classList.remove('active');
            document.body.classList.remove('sidebar-active');
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