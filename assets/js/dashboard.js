document.getElementById('sidebarToggle').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.querySelector('.main-content');
        
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    });
    
    // Responsive sidebar management
    function checkWidth() {
        if (window.innerWidth <= 768) {
            document.getElementById('sidebar').classList.add('collapsed');
            document.querySelector('.main-content').classList.add('expanded');
        } else {
            document.getElementById('sidebar').classList.remove('collapsed');
            document.querySelector('.main-content').classList.remove('expanded');
        }
    }
    
    // Check width on load
    window.addEventListener('load', checkWidth);
    
    // Check width on resize
    window.addEventListener('resize', checkWidth);