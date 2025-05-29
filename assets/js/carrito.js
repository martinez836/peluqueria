// Archivo: carrito.js

localStorage.removeItem('carrito');

let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

// Función para añadir productos al carrito
function agregarAlCarrito(id, nombre, precio, imagen, cantidad, stockDisponible) {
    // Verificar si el producto ya está en el carrito
    const productoExistente = carrito.find(item => item.id === id);
    
    // Calcular la cantidad total que tendría el producto
    const cantidadTotal = productoExistente 
        ? productoExistente.cantidad + cantidad 
        : cantidad;
    
    // Verificar si la cantidad total supera el stock disponible
    if (cantidadTotal > stockDisponible) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `Solo hay ${stockDisponible} unidades disponibles de este producto`,
            confirmButtonColor: '#daa520'
        });
        return;
    }

    if (productoExistente) {
        // Si existe, aumentar la cantidad
        productoExistente.cantidad = cantidadTotal;
        productoExistente.subTotal = cantidadTotal * precio;
    } else {
        // Si no existe, añadirlo como nuevo producto
        carrito.push({
            id: id,
            nombre: nombre,
            precio: precio,
            imagen: imagen,
            cantidad: cantidad,
            subTotal: cantidad * precio
        });
    }

    // Guardar en localStorage y actualizar la vista
    guardarCarrito();
    actualizarBadgeCarrito();
    mostrarNotificacion(`${nombre} añadido al carrito`);
}

function guardarCarrito() {
    localStorage.setItem('carrito', JSON.stringify(carrito));
}

function actualizarBadgeCarrito() {
    const badge = document.querySelector('.cart-count');
    if (badge) {
        const totalItems = carrito.reduce((sum, item) => sum + item.cantidad, 0);
        badge.textContent = totalItems;
        badge.style.display = totalItems > 0 ? 'block' : 'none';
    }
}

function mostrarCarrito() {
    const modalBody = document.querySelector('#carritoModal .modal-body');
    if (!modalBody) return;

    modalBody.innerHTML = '';
    
    if (carrito.length === 0) {
        modalBody.innerHTML = '<p class="text-center">El carrito está vacío</p>';
        document.getElementById('btn-finalizar-compra').disabled = true;
        return;
    }

    const tabla = document.createElement('table');
    tabla.className = 'table';
    
    const thead = document.createElement('thead');
    thead.innerHTML = `
        <tr>
            <th>Producto</th>
            <th class="text-center">Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
            <th></th>
        </tr>
    `;
    tabla.appendChild(thead);

    const tbody = document.createElement('tbody');
    let totalGeneral = 0;

    carrito.forEach(item => {
        const total = item.precio * item.cantidad;
        totalGeneral += total;

        const tr = document.createElement('tr');
        tr.dataset.productoId = item.id;

        const tdProducto = document.createElement('td');
        tdProducto.className = 'align-middle';
        const divProducto = document.createElement('div');
        divProducto.className = 'd-flex align-items-center';
        const img = document.createElement('img');
        img.src = item.imagen;
        img.alt = item.nombre;
        img.className = 'img-thumbnail me-2';
        img.style.width = '50px';
        img.style.height = '50px';
        img.style.objectFit = 'cover';
        const spanNombre = document.createElement('span');
        spanNombre.textContent = item.nombre;
        divProducto.appendChild(img);
        divProducto.appendChild(spanNombre);
        tdProducto.appendChild(divProducto);

        const tdCantidad = document.createElement('td');
        tdCantidad.className = 'align-middle text-center';
        tdCantidad.textContent = item.cantidad;

        const tdPrecio = document.createElement('td');
        tdPrecio.className = 'align-middle';
        tdPrecio.textContent = `$${item.precio.toLocaleString()}`;

        const tdTotal = document.createElement('td');
        tdTotal.className = 'align-middle';
        tdTotal.textContent = `$${total.toLocaleString()}`;

        const tdEliminar = document.createElement('td');
        tdEliminar.className = 'align-middle';
        const btnEliminar = document.createElement('button');
        btnEliminar.className = 'btn btn-danger btn-sm';
        btnEliminar.innerHTML = '<i class="bi bi-trash"></i>';
        btnEliminar.onclick = function() {
            eliminarDelCarrito(item.id);
        };
        tdEliminar.appendChild(btnEliminar);

        tr.appendChild(tdProducto);
        tr.appendChild(tdCantidad);
        tr.appendChild(tdPrecio);
        tr.appendChild(tdTotal);
        tr.appendChild(tdEliminar);
        tbody.appendChild(tr);
    });

    const trTotal = document.createElement('tr');
    const tdTotalLabel = document.createElement('td');
    tdTotalLabel.colSpan = 3;
    tdTotalLabel.className = 'text-end fw-bold';
    tdTotalLabel.textContent = 'Total:';
    const tdTotalValor = document.createElement('td');
    tdTotalValor.className = 'fw-bold';
    tdTotalValor.textContent = `$${totalGeneral.toLocaleString()}`;
    const tdVacio = document.createElement('td');
    trTotal.appendChild(tdTotalLabel);
    trTotal.appendChild(tdTotalValor);
    trTotal.appendChild(tdVacio);
    tbody.appendChild(trTotal);

    tabla.appendChild(tbody);
    modalBody.appendChild(tabla);

    document.getElementById('btn-finalizar-compra').disabled = false;
}

function eliminarDelCarrito(id) {
    carrito = carrito.filter(item => item.id !== id);
    guardarCarrito();
    actualizarBadgeCarrito();
    mostrarCarrito();
    if (carrito.length === 0) {
        document.getElementById('btn-finalizar-compra').disabled = true;
    }
}

function vaciarCarrito() {
    carrito = [];
    guardarCarrito();
    actualizarBadgeCarrito();
    mostrarCarrito();
    document.getElementById('btn-finalizar-compra').disabled = true;
}

function mostrarNotificacion(mensaje) {
    Swal.fire({
        title: 'Carrito',
        text: mensaje,
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Agregar eventos a los botones de agregar al carrito
    document.querySelectorAll('.btn-agregar').forEach(button => {
        button.addEventListener('click', function() {
            const producto = this.closest('.producto');
            const id = parseInt(producto.dataset.id);
            const nombre = producto.querySelector('h3').textContent;
            const precio = parseFloat(producto.querySelector('.precio').textContent.replace('$', '').replace(',', ''));
            const imagen = producto.querySelector('img').src;
            const cantidad = parseInt(producto.querySelector('input[type="number"]').value) || 1;
            const stockDisponible = parseInt(producto.dataset.stock);
            
            if (cantidad > 0) {
                agregarAlCarrito(id, nombre, precio, imagen, cantidad, stockDisponible);
            } else {
                mostrarNotificacion('Por favor selecciona una cantidad válida');
            }
        });
    });

    // Inicializar el badge del carrito
    actualizarBadgeCarrito();

    // Configurar el modal del carrito
    const carritoModal = document.getElementById('carritoModal');
    if (carritoModal) {
        carritoModal.addEventListener('show.bs.modal', function() {
            mostrarCarrito();
        });
    }

    // Configurar el botón de finalizar compra
    const btnFinalizarCompra = document.getElementById('btn-finalizar-compra');
    if (btnFinalizarCompra) {
        btnFinalizarCompra.addEventListener('click', function() {
            if (carrito.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Carrito Vacío',
                    text: 'El carrito está vacío',
                    confirmButtonColor: '#daa520'
                });
                return;
            }

            const total = carrito.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
            
            fetch('../../controllers/agregarPedido.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    productos: carrito,
                    total: total
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.mensaje,
                        confirmButtonColor: '#daa520'
                    }).then(() => {
                        carrito = [];
                        guardarCarrito();
                        actualizarBadgeCarrito();
                        bootstrap.Modal.getInstance(carritoModal).hide();
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.mensaje);
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Error al procesar el pedido',
                    confirmButtonColor: '#daa520'
                });
            });
        });
    }

    // Desactivar botones si el stock es 0
    document.querySelectorAll('.producto').forEach(producto => {
        const stock = parseInt(producto.dataset.stock);
        const botonAgregar = producto.querySelector('.btn-agregar');
        const inputCantidad = producto.querySelector('input[type="number"]');
        
        if (stock === 0) {
            botonAgregar.disabled = true;
            botonAgregar.textContent = 'Sin stock';
            botonAgregar.classList.add('btn-secondary');
            botonAgregar.classList.remove('btn-primary');
            if (inputCantidad) {
                inputCantidad.disabled = true;
            }
        }
    });
});
