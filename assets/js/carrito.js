// Archivo: carrito.js

localStorage.removeItem('carrito'); // borrar los datos del carrito

// Inicializar el carrito como un array vacío o recuperarlo del localStorage
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

    // Mostrar mensaje de confirmación
    mostrarNotificacion(`${nombre} añadido al carrito`);
}

// Función para guardar el carrito en localStorage
function guardarCarrito() {
localStorage.setItem('carrito', JSON.stringify(carrito));
}

// Función para actualizar el número de productos en el badge del carrito
function actualizarBadgeCarrito() {
const badge = document.getElementById('carrito-badge');
const totalItems = carrito.reduce((total, item) => total + item.cantidad, 0);

badge.textContent = totalItems;
badge.style.display = totalItems > 0 ? 'inline-block' : 'none';
}

// Función para mostrar la modal del carrito
function mostrarCarrito() {
/*     console.log('Mostrando carrito...');
    console.log('Carrito actual:', carrito); */

    const modalBody = document.querySelector('#carritoModal .modal-body');
    modalBody.innerHTML = '';

    if (carrito.length === 0) {
        const mensajeVacio = document.createElement('p');
        mensajeVacio.className = 'text-center';
        mensajeVacio.textContent = 'Tu carrito está vacío';
        modalBody.appendChild(mensajeVacio);
        document.getElementById('btn-finalizar-compra').disabled = true;
        return;
    }

    let totalGeneral = 0;

    // Crear la tabla
    const tabla = document.createElement('table');
    tabla.className = 'table';

    // Crear el encabezado
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    
    const headers = ['Producto', 'Cantidad', 'Precio', 'Total', ''];
    headers.forEach(headerText => {
        const th = document.createElement('th');
        th.textContent = headerText;
        headerRow.appendChild(th);
    });
    
    thead.appendChild(headerRow);
    tabla.appendChild(thead);

    // Crear el cuerpo de la tabla
    const tbody = document.createElement('tbody');
    tbody.id = 'items-carrito';

    carrito.forEach((item, index) => {
        /* console.log(`Procesando producto ${index}:`, item); */
        const total = item.precio * item.cantidad;
        totalGeneral += total;
        
        const tr = document.createElement('tr');
        tr.dataset.productoId = item.id;
        
        // Celda del producto
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
        
        // Celda de cantidad
        const tdCantidad = document.createElement('td');
        tdCantidad.className = 'align-middle';
        
        const divCantidad = document.createElement('div');
        divCantidad.className = 'input-group input-group-sm';
        divCantidad.style.width = '100px';
        
        const btnMenos = document.createElement('button');
        btnMenos.className = 'btn btn-outline-secondary btn-sm';
        btnMenos.textContent = '-';
        btnMenos.onclick = function() {
            /* console.log('Botón menos clickeado'); */
            const productoId = parseInt(this.closest('tr').dataset.productoId);
            /* console.log('ID del producto:', productoId); */
            const producto = carrito.find(p => p.id === productoId);
            /* console.log('Producto encontrado:', producto); */
            if (producto) {
                cambiarCantidad(productoId, producto.cantidad - 1);
            }
        };
        
        const inputCantidad = document.createElement('input');
        inputCantidad.type = 'text';
        inputCantidad.className = 'form-control text-center';
        inputCantidad.value = item.cantidad;
        inputCantidad.readOnly = true;
        
        const btnMas = document.createElement('button');
        btnMas.className = 'btn btn-outline-secondary btn-sm';
        btnMas.textContent = '+';
        btnMas.onclick = function() {
/*             console.log('Botón más clickeado'); */
            const productoId = parseInt(this.closest('tr').dataset.productoId);
/*             console.log('ID del producto:', productoId); */
            const producto = carrito.find(p => p.id === productoId);
/*             console.log('Producto encontrado:', producto); */
            if (producto) {
                cambiarCantidad(productoId, producto.cantidad + 1);
            }
        };
        
        divCantidad.appendChild(btnMenos);
        divCantidad.appendChild(inputCantidad);
        divCantidad.appendChild(btnMas);
        tdCantidad.appendChild(divCantidad);
        
        // Celda de precio
        const tdPrecio = document.createElement('td');
        tdPrecio.className = 'align-middle';
        tdPrecio.textContent = `$${item.precio.toLocaleString()}`;
        
        // Celda de total
        const tdTotal = document.createElement('td');
        tdTotal.className = 'align-middle';
        tdTotal.textContent = `$${total.toLocaleString()}`;
        
        // Celda de eliminar
        const tdEliminar = document.createElement('td');
        tdEliminar.className = 'align-middle';
        
        const btnEliminar = document.createElement('button');
        btnEliminar.className = 'btn btn-danger btn-sm';
        btnEliminar.innerHTML = '<i class="bi bi-trash"></i>';
        btnEliminar.onclick = function() {
            console.log('Botón eliminar clickeado');
            const productoId = parseInt(this.closest('tr').dataset.productoId);
            console.log('ID del producto a eliminar:', productoId);
            eliminarDelCarrito(productoId);
        };
        
        tdEliminar.appendChild(btnEliminar);
        
        // Añadir todas las celdas a la fila
        tr.appendChild(tdProducto);
        tr.appendChild(tdCantidad);
        tr.appendChild(tdPrecio);
        tr.appendChild(tdTotal);
        tr.appendChild(tdEliminar);
        
        tbody.appendChild(tr);
    });

    // Añadir fila del total
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

// Función para cambiar la cantidad de un producto
function cambiarCantidad(id, nuevaCantidad) {
/*     console.log('Cambiando cantidad. ID:', id, 'Nueva cantidad:', nuevaCantidad); */
    if (nuevaCantidad <= 0) {
        eliminarDelCarrito(id);
        return;
    }

    const item = carrito.find(producto => producto.id === id);
/*     console.log('Producto encontrado para cambiar cantidad:', item); */
    if (item) {
        item.cantidad = nuevaCantidad;
        guardarCarrito();
        actualizarBadgeCarrito();
        mostrarCarrito();
    }
}

// Función para eliminar un producto del carrito
function eliminarDelCarrito(id) {
/*     console.log('Eliminando producto. ID:', id); */
    carrito = carrito.filter(item => item.id !== id);
    guardarCarrito();
    actualizarBadgeCarrito();
    mostrarCarrito();

    if (carrito.length === 0) {
        document.getElementById('btn-finalizar-compra').disabled = true;
    }
}

// Función para vaciar todo el carrito
function vaciarCarrito() {
carrito = [];
guardarCarrito();
actualizarBadgeCarrito();
mostrarCarrito();
document.getElementById('btn-finalizar-compra').disabled = true;
}

// Función para finalizar la compra
function finalizarCompra() {
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
    
    // Obtener el documento del usuario
    const btnFinalizarCompra = document.getElementById('btn-finalizar-compra');
    const documento = btnFinalizarCompra.getAttribute('data-documento');

    if (!documento) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se encontró el documento del usuario',
            confirmButtonColor: '#daa520'
        });
        return;
    }

    // Primero crear el pedido
    fetch('../../controllers/crear_pedido.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            total: total,
            documento: documento
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const idPedido = data.idPedido;
            
            // Crear los detalles del pedido
            const promesasDetalles = carrito.map(item => {
                return fetch('../../controllers/crear_detalle_pedido.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        idPedido: idPedido,
                        idProducto: item.id,
                        cantidad: item.cantidad,
                        subTotal: item.precio * item.cantidad
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                });
            });

            // Actualizar el stock de los productos
            const actualizarStock = fetch('../../controllers/actualizar_stock.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    productos: carrito.map(item => ({
                        id: item.id,
                        cantidad: item.cantidad
                    }))
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            });

            // Esperar a que todas las operaciones terminen
            Promise.all([...promesasDetalles, actualizarStock])
                .then(() => {
                    // Limpiar el carrito
                    carrito = [];
                    actualizarBadgeCarrito();
                    guardarCarrito();
                    
                    // Cerrar el modal del carrito
                    const carritoModal = bootstrap.Modal.getInstance(document.getElementById('carritoModal'));
                    carritoModal.hide();

                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Pedido Registrado!',
                        text: 'Tu pedido ha sido registrado exitosamente',
                        confirmButtonColor: '#daa520'
                    }).then(() => {
                        // Recargar la página para actualizar el stock mostrado
                        window.location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al procesar tu pedido',
                        confirmButtonColor: '#daa520'
                    });
                });
        } else {
            throw new Error(data.error || 'Error al crear el pedido');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al procesar tu pedido',
            confirmButtonColor: '#daa520'
        });
    });
}

// Función para verificar si el usuario ha iniciado sesión y realizar la compra
function verificarSesionYComprar() {
    const btnFinalizarCompra = document.getElementById('btn-finalizar-compra');
    const haySesion = btnFinalizarCompra.getAttribute('data-sesion') === '1';
    const documento = btnFinalizarCompra.getAttribute('data-documento');
    
    if (haySesion && documento) {
        // Si hay sesión y tenemos el documento, continuar con la compra
        finalizarCompra();
    } else {
        // Si no hay sesión o no hay documento, cerrar el modal del carrito y abrir el modal de login
        const carritoModal = bootstrap.Modal.getInstance(document.getElementById('carritoModal'));
        carritoModal.hide();
        
        // Esperar a que se cierre el modal del carrito antes de abrir el de login
        setTimeout(() => {
            const modalLogin = new bootstrap.Modal(document.getElementById('modalLogin'));
            modalLogin.show();
        }, 500);
    }
}

// Función para mostrar notificaciones
function mostrarNotificacion(mensaje) {
    // Crear el contenedor del toast
    const toastContainer = document.createElement('div');
    toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
    toastContainer.style.zIndex = '11';

    // Crear el toast
    const toast = document.createElement('div');
    toast.className = 'toast show';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    // Crear el header del toast
    const toastHeader = document.createElement('div');
    toastHeader.className = 'toast-header';

    // Crear el título
    const toastTitle = document.createElement('strong');
    toastTitle.className = 'me-auto';
    toastTitle.textContent = 'Estilos Dairo';

    // Crear el botón de cerrar
    const closeButton = document.createElement('button');
    closeButton.type = 'button';
    closeButton.className = 'btn-close';
    closeButton.setAttribute('data-bs-dismiss', 'toast');
    closeButton.setAttribute('aria-label', 'Close');

    // Crear el cuerpo del toast
    const toastBody = document.createElement('div');
    toastBody.className = 'toast-body';
    toastBody.textContent = mensaje;

    // Ensamblar el toast
    toastHeader.appendChild(toastTitle);
    toastHeader.appendChild(closeButton);
    toast.appendChild(toastHeader);
    toast.appendChild(toastBody);
    toastContainer.appendChild(toast);

    // Añadir el toast al body
    document.body.appendChild(toastContainer);

    // Remover la notificación después de 3 segundos
    setTimeout(() => {
        document.body.removeChild(toastContainer);
    }, 3000);
}

// Inicializar carrito al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Añadir eventos a los botones de agregar
    document.querySelectorAll('.btn-agregar').forEach(button => {
        button.addEventListener('click', function() {
            const producto = this.closest('.producto');
            const id = parseInt(producto.dataset.id);
            const nombre = producto.querySelector('h3').textContent;
            const precio = parseFloat(producto.querySelector('.precio').textContent.replace('$', '').replace(',', ''));
            const imagen = producto.querySelector('img').src;
            const cantidad = parseInt(producto.querySelector('input[type="number"]').value) || 1;
            const stockDisponible = parseInt(producto.querySelector('input[type="number"]').getAttribute('max'));
            
            if (cantidad > 0) {
                agregarAlCarrito(id, nombre, precio, imagen, cantidad, stockDisponible);
            } else {
                mostrarNotificacion('Por favor selecciona una cantidad válida');
            }
        });
    });

    // Actualizar badge al cargar
    actualizarBadgeCarrito();

    // Añadir evento para mostrar el carrito cuando se abre el modal
    const carritoModal = document.getElementById('carritoModal');
    if (carritoModal) {
        carritoModal.addEventListener('show.bs.modal', function () {
            mostrarCarrito();
        });
    }
    
    // Añadir evento al botón de finalizar compra
    const btnFinalizarCompra = document.getElementById('btn-finalizar-compra');
    if (btnFinalizarCompra) {
        btnFinalizarCompra.addEventListener('click', verificarSesionYComprar);
    }
});