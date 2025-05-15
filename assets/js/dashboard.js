document.addEventListener('DOMContentLoaded', function() {
    // Toggle para el sidebar en dispositivos móviles
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    
    // Crear un overlay para cerrar el sidebar en móviles al hacer clic fuera
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);
    
    // Función para comprobar si estamos en vista móvil
    function isMobile() {
        return window.innerWidth <= 768;
    }
    
    // Función para manejar el estado del sidebar
    function toggleSidebar() {
        if (sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        } else {
            sidebar.classList.add('active');
            overlay.classList.add('active');
        }
    }
    
    // Event listener para el botón de toggle
    sidebarToggle.addEventListener('click', function() {
        toggleSidebar();
    });
    
    // Cerrar sidebar al hacer clic en el overlay
    overlay.addEventListener('click', function() {
        toggleSidebar();
    });
    
    // Cerrar sidebar al hacer clic en un enlace (en móviles)
    const navLinks = document.querySelectorAll('#sidebar .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (isMobile() && sidebar.classList.contains('active')) {
                toggleSidebar();
            }
        });
    });
    
    // Ajustar según el tamaño de la ventana
    function handleResize() {
        if (window.innerWidth > 768) {
            // En pantallas grandes, asegurar que el sidebar esté visible
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            mainContent.style.marginLeft = ''; // Usar el valor del CSS
        } else {
            // En móviles, asegurar que el sidebar esté oculto por defecto
            // pero mantenerlo visible si está activo
            if (!sidebar.classList.contains('active')) {
                mainContent.style.marginLeft = '0';
            }
        }
    }
    
    // Manejar el evento resize
    window.addEventListener('resize', handleResize);
    
    // Inicializar al cargar
    handleResize();

    // Hacer las tablas responsivas si no lo son ya
    const tables = document.querySelectorAll('table:not(.table-responsive)');
    tables.forEach(table => {
        if (!table.closest('.table-responsive')) {
            const wrapper = document.createElement('div');
            wrapper.className = 'table-responsive';
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        }
    });
});