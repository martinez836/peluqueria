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
function agregarAlCarrito(id, nombre, precio, imagen, cantidad) {
    const productoExistente = carrito.find(item => item.id === id);

    if (productoExistente) {
        productoExistente.cantidad += cantidad;
    } else {
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

    guardarCarrito();
    actualizarBadgeCarrito();
    mostrarNotificacion(`${nombre} añadido al carrito`);
}

function guardarCarrito() {
    localStorage.setItem('carrito', JSON.stringify(carrito));
}

function actualizarBadgeCarrito() {
    const badge = document.getElementById('carrito-badge');
    const totalItems = carrito.reduce((total, item) => total + item.cantidad, 0);
    badge.textContent = totalItems;
    badge.style.display = totalItems > 0 ? 'inline-block' : 'none';
}

function mostrarCarrito() {
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
    const tabla = document.createElement('table');
    tabla.className = 'table';

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

    const tbody = document.createElement('tbody');
    tbody.id = 'items-carrito';

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
        btnEliminar.onclick = function () {
            const productoId = parseInt(this.closest('tr').dataset.productoId);
            eliminarDelCarrito(productoId);
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

function cambiarCantidad(id, nuevaCantidad) {
    if (nuevaCantidad <= 0) {
        eliminarDelCarrito(id);
        return;
    }

    const item = carrito.find(producto => producto.id === id);
    if (item) {
        item.cantidad = nuevaCantidad;
        guardarCarrito();
        actualizarBadgeCarrito();
        mostrarCarrito();
    }
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

    fetch('../../controllers/crear_pedido.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ total: total, documento: documento })
    })
    .then(response => {
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const idPedido = data.idPedido;
            const promesasDetalles = carrito.map(item => {
                return fetch('../../controllers/crear_detalle_pedido.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        idPedido: idPedido,
                        idProducto: item.id,
                        cantidad: item.cantidad,
                        subTotal: item.precio * item.cantidad
                    })
                }).then(r => r.json());
            });

            const actualizarStock = fetch('../../controllers/actualizar_stock.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    productos: carrito.map(item => ({
                        id: item.id,
                        cantidad: item.cantidad
                    }))
                })
            }).then(r => r.json());

            Promise.all([...promesasDetalles, actualizarStock])
            .then(() => {
                carrito = [];
                actualizarBadgeCarrito();
                guardarCarrito();
                bootstrap.Modal.getInstance(document.getElementById('carritoModal')).hide();
                Swal.fire({
                    icon: 'success',
                    title: '¡Pedido Registrado!',
                    text: 'Tu pedido ha sido registrado exitosamente',
                    confirmButtonColor: '#daa520'
                }).then(() => window.location.reload());
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({ icon: 'error', title: 'Error', text: 'Hubo un error al procesar tu pedido', confirmButtonColor: '#daa520' });
            });
        } else {
            throw new Error(data.error || 'Error al crear el pedido');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({ icon: 'error', title: 'Error', text: 'Hubo un error al procesar tu pedido', confirmButtonColor: '#daa520' });
    });
}

function verificarSesionYComprar() {
    const btnFinalizarCompra = document.getElementById('btn-finalizar-compra');
    const haySesion = btnFinalizarCompra.getAttribute('data-sesion') === '1';
    const documento = btnFinalizarCompra.getAttribute('data-documento');
    
    if (haySesion && documento) {
        finalizarCompra();
    } else {
        bootstrap.Modal.getInstance(document.getElementById('carritoModal')).hide();
        setTimeout(() => {
            const modalLogin = new bootstrap.Modal(document.getElementById('modalLogin'));
            modalLogin.show();
        }, 500);
    }
}

function mostrarNotificacion(mensaje) {
    const toastContainer = document.createElement('div');
    toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
    toastContainer.style.zIndex = '11';

    const toast = document.createElement('div');
    toast.className = 'toast show';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    const toastHeader = document.createElement('div');
    toastHeader.className = 'toast-header';

    const toastTitle = document.createElement('strong');
    toastTitle.className = 'me-auto';
    toastTitle.textContent = 'Estilos Dairo';

    const closeButton = document.createElement('button');
    closeButton.type = 'button';
    closeButton.className = 'btn-close';
    closeButton.setAttribute('data-bs-dismiss', 'toast');
    closeButton.setAttribute('aria-label', 'Close');

    const toastBody = document.createElement('div');
    toastBody.className = 'toast-body';
    toastBody.textContent = mensaje;

    toastHeader.appendChild(toastTitle);
    toastHeader.appendChild(closeButton);
    toast.appendChild(toastHeader);
    toast.appendChild(toastBody);
    toastContainer.appendChild(toast);
    document.body.appendChild(toastContainer);

    setTimeout(() => {
        document.body.removeChild(toastContainer);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-agregar').forEach(button => {
        button.addEventListener('click', function () {
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

    actualizarBadgeCarrito();

    const carritoModal = document.getElementById('carritoModal');
    if (carritoModal) {
        carritoModal.addEventListener('show.bs.modal', function () {
            mostrarCarrito();
        });
    }

    const btnFinalizarCompra = document.getElementById('btn-finalizar-compra');
    if (btnFinalizarCompra) {
        btnFinalizarCompra.addEventListener('click', verificarSesionYComprar);
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const botonesAgregar = document.querySelectorAll('.btn-agregar');
    const contenedorCarrito = document.getElementById('carrito');
    const listaCarrito = document.getElementById('lista-carrito');
    const btnVaciarCarrito = document.getElementById('vaciar-carrito');
    const btnFinalizarCompra = document.getElementById('finalizar-compra');

    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    botonesAgregar.forEach(boton => {
        boton.addEventListener('click', agregarAlCarrito);
    });

    btnVaciarCarrito.addEventListener('click', () => {
        carrito = [];
        actualizarCarrito();
        mostrarToast('Carrito vaciado');
    });

    btnFinalizarCompra.addEventListener('click', () => {
        if (carrito.length === 0) {
            mostrarToast('El carrito está vacío');
            return;
        }

        fetch('finalizar_compra.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(carrito),
        })
            .then(response => response.json())
            .then(data => {
                mostrarToast(data.message);
                if (data.success) {
                    carrito = [];
                    actualizarCarrito();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarToast('Error al finalizar la compra');
            });
    });

    function agregarAlCarrito(e) {
        const producto = e.target.closest('.producto');
        const id = producto.dataset.id;
        const nombre = producto.querySelector('h3').textContent;
        const precio = parseFloat(producto.querySelector('.precio').textContent.replace('$', ''));
        const imagen = producto.querySelector('img').src;
        const cantidadInput = producto.querySelector('input[type="number"]');
        const cantidad = parseInt(cantidadInput.value);
        const stock = parseInt(producto.dataset.stock);

        if (cantidad > stock) {
            mostrarToast(`No puedes agregar más de ${stock} unidades`);
            return;
        }

        const productoExistente = carrito.find(item => item.id === id);

        if (productoExistente) {
            if (productoExistente.cantidad + cantidad > stock) {
                mostrarToast(`No puedes agregar más de ${stock} unidades en total`);
                return;
            }
            productoExistente.cantidad += cantidad;
        } else {
            carrito.push({ id, nombre, precio, imagen, cantidad, stock });
        }

        actualizarCarrito();
        mostrarToast('Producto agregado al carrito');
    }

    function actualizarCarrito() {
        listaCarrito.innerHTML = '';
        carrito.forEach(producto => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td><img src="${producto.imagen}" width="50"></td>
                <td>${producto.nombre}</td>
                <td>$${producto.precio}</td>
                <td>
                    <input type="number" value="${producto.cantidad}" min="1" max="${producto.stock}" data-id="${producto.id}" class="input-cantidad">
                </td>
                <td>$${(producto.precio * producto.cantidad).toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm eliminar-producto" data-id="${producto.id}">Eliminar</button></td>
            `;
            listaCarrito.appendChild(fila);
        });

        localStorage.setItem('carrito', JSON.stringify(carrito));
        agregarEventosCantidad();
        agregarEventosEliminar();
    }

    function agregarEventosCantidad() {
        document.querySelectorAll('.input-cantidad').forEach(input => {
            input.addEventListener('change', function () {
                const id = this.dataset.id;
                const nuevaCantidad = parseInt(this.value);
                const producto = carrito.find(item => item.id === id);

                if (nuevaCantidad > producto.stock) {
                    mostrarToast(`Solo hay ${producto.stock} unidades disponibles`);
                    this.value = producto.stock;
                    return;
                }

                if (nuevaCantidad < 1) {
                    this.value = producto.cantidad;
                    return;
                }

                producto.cantidad = nuevaCantidad;
                actualizarCarrito();
            });
        });
    }

    function agregarEventosEliminar() {
        document.querySelectorAll('.eliminar-producto').forEach(boton => {
            boton.addEventListener('click', function () {
                const id = this.dataset.id;
                carrito = carrito.filter(item => item.id !== id);
                actualizarCarrito();
                mostrarToast('Producto eliminado');
            });
        });
    }

    function mostrarToast(mensaje) {
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.textContent = mensaje;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('visible');
        }, 100);
        setTimeout(() => {
            toast.classList.remove('visible');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    // Inicializar carrito al cargar
    actualizarCarrito();

    // Desactivar botones si el stock es 0
    document.querySelectorAll('.producto').forEach(producto => {
        const stock = parseInt(producto.dataset.stock);
        const botonAgregar = producto.querySelector('.btn-agregar');
        if (stock === 0) {
            botonAgregar.disabled = true;
            botonAgregar.textContent = 'Sin stock';
            botonAgregar.classList.add('btn-secondary');
            botonAgregar.classList.remove('btn-primary');
        }
    });
})}
