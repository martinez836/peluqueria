document.addEventListener('DOMContentLoaded', function() {
    // Función para cargar datos en el modal de editar producto
    function cargarDatosProducto(id, nombre, descripcion, precio, stock) {
        document.getElementById('edit_id_producto').value = id;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_descripcion').value = descripcion;
        document.getElementById('edit_precio').value = precio;
        document.getElementById('edit_stock').value = stock;
    }

    // Función para cargar datos en el modal de editar servicio
    function cargarDatosServicio(id, nombre, descripcion, precio) {
        document.getElementById('edit_id_servicio').value = id;
        document.getElementById('edit_nombre_servicio').value = nombre;
        document.getElementById('edit_descripcion_servicio').value = descripcion;
        document.getElementById('edit_precio_servicio').value = precio;
    }

    // Función para cargar datos en el modal de editar cita
    function cargarDatosCita(id, nombre, telefono, servicio, fecha) {
        document.getElementById('edit_id_cita').value = id;
        document.getElementById('edit_nombre_cliente').value = nombre;
        document.getElementById('edit_telefono').value = telefono;
        document.getElementById('edit_servicio').value = servicio;
        document.getElementById('edit_fecha').value = fecha;
    }

    // Agregar event listeners a los botones de editar producto
    document.querySelectorAll('[data-bs-target="#editarProductoModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('.row');
            const id = row.dataset.id;
            const nombre = row.querySelector('strong').textContent;
            const descripcion = row.querySelector('small:nth-of-type(2)').textContent;
            const precio = row.querySelector('small:nth-of-type(1)').textContent.replace('$', '');
            const stock = row.dataset.stock;
            
            cargarDatosProducto(id, nombre, descripcion, precio, stock);
        });
    });

    // Agregar event listeners a los botones de editar servicio
    document.querySelectorAll('[data-bs-target="#editarServicioModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('.row');
            const id = row.dataset.id;
            const nombre = row.querySelector('strong').textContent;
            const descripcion = row.querySelector('small:nth-of-type(2)').textContent;
            const precio = row.querySelector('small:nth-of-type(1)').textContent.replace('$', '');
            
            cargarDatosServicio(id, nombre, descripcion, precio);
        });
    });

    // Agregar event listeners a los botones de editar cita
    document.querySelectorAll('[data-bs-target="#editarCitaModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const div = this.closest('.border-bottom');
            const id = div.dataset.id;
            const nombre = div.querySelector('strong').textContent;
            const telefono = div.querySelector('small:nth-of-type(1)').textContent.split(' - ')[0].replace('Tel: ', '');
            const servicio = div.querySelector('small:nth-of-type(1)').textContent.split(' - ')[1];
            const fecha = div.querySelector('small:nth-of-type(2)').textContent.replace('Fecha: ', '');
            
            cargarDatosCita(id, nombre, telefono, servicio, fecha);
        });
    });

    // Limpiar formularios al cerrar los modales
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function() {
            this.querySelector('form').reset();
        });
    });
}); 