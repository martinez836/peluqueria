document.addEventListener("DOMContentLoaded", function () {
    const botones = document.querySelectorAll(".verDetallePedido");
    const contenedor = document.getElementById("detallesPedido");
    let pedidoActualId = null;

    function cambiarEstado(boton) {
        const estado = boton.getAttribute('data-estado');
        if (!pedidoActualId) {
            Swal.fire({
                title: '¡Error!',
                text: 'Por favor, seleccione un pedido primero',
                icon: 'error',
                confirmButtonColor: '#daa520'
            });
            return;
        }

        const formData = new FormData();
        formData.append('idpedido', pedidoActualId);
        formData.append('estado', estado);

        fetch("../../controllers/actualizarEstadoPedido.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: '¡Éxito!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#daa520'
                }).then(() => {
                    // Actualizar el estado en el detalle visible
                    const badge = document.querySelector(".info-pedido .badge");
                    if (badge) {
                        badge.textContent = estado.charAt(0).toUpperCase() + estado.slice(1);
                        badge.className = `badge badge-${estado}`;
                    }
                    // Actualizar la vista de la tabla
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: '¡Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonColor: '#daa520'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: '¡Error!',
                text: 'Error en la conexión con el servidor.',
                icon: 'error',
                confirmButtonColor: '#daa520'
            });
        });
    }

    botones.forEach((btn) => {
        btn.addEventListener("click", () => {
            const idpedido = btn.getAttribute("data-id");
            pedidoActualId = idpedido;
            const formData = new FormData();
            formData.append('idpedido', idpedido);

            fetch("../../controllers/obtenerDetallePedido.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarDetallesPedido(data.detalles);
                } else {
                    Swal.fire({
                        title: '¡Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#daa520'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: '¡Error!',
                    text: 'Error en la conexión con el servidor.',
                    icon: 'error',
                    confirmButtonColor: '#daa520'
                });
            });
        });
    });

    function mostrarDetallesPedido(detalles) {
        if (detalles.length === 0) {
            contenedor.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-box-open fa-3x text-muted"></i>
                    <p class="mt-3">No se encontraron detalles para este pedido.</p>
                </div>
            `;
            return;
        }

        const pedido = detalles[0];
        const html = `
            <h3>Detalles del Pedido #${pedido.idpedidos}</h3>
            
            <div class="info-group">
                <div class="info-item">
                    <i class="fas fa-user"></i>
                    <span class="label">Cliente:</span>
                    <span class="value">${pedido.nombres} ${pedido.apellidos}</span>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-calendar"></i>
                    <span class="label">Fecha:</span>
                    <span class="value">${new Date(pedido.fecha).toLocaleDateString()}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-info-circle"></i>
                    <span class="label">Estado:</span>
                    <span class="value">
                        <span class="badge bg-${getBadgeClass(pedido.estado)}">${pedido.estado.charAt(0).toUpperCase() + pedido.estado.slice(1)}</span>
                    </span>
                </div>

                ${pedido.direccion ? `
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="label">Dirección:</span>
                    <span class="value">${pedido.direccion}</span>
                </div>
                ` : ''}

                ${pedido.barrio ? `
                <div class="info-item">
                    <i class="fas fa-map"></i>
                    <span class="label">Barrio:</span>
                    <span class="value">${pedido.barrio}</span>
                </div>
                ` : ''}
            </div>

            <div class="productos-list">
                <h4><i class="fas fa-shopping-cart"></i> Productos del Pedido</h4>
                ${detalles.map(item => `
                    <div class="producto-item">
                        <div class="producto-info">
                            <img src="../../${item.imagen_producto}" alt="${item.nombre_producto}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                            <span>${item.nombre_producto}</span>
                            <small class="d-block text-muted">${item.descripcion_producto}</small>
                        </div>
                        <span class="producto-cantidad">x${item.cantidad}</span>
                        <span class="producto-precio">$${item.precio_unitario}</span>
                    </div>
                `).join('')}
            </div>

            <div class="total-section">
                <span class="total-label">Total del Pedido:</span>
                <span class="total-amount">$${pedido.total}</span>
            </div>
        `;

        contenedor.innerHTML = html;

        // Actualizar el dataset para los botones de acción
        const accionesEstado = document.querySelector('.acciones-estado');
        if (accionesEstado) {
            accionesEstado.dataset.pedidoId = pedido.idpedidos;
        }
    }

    function getBadgeClass(estado) {
        const clases = {
            'pendiente': 'warning',
            'confirmado': 'primary',
            'entregado': 'success',
            'cancelado': 'danger'
        };
        return clases[estado.toLowerCase()] || 'secondary';
    }

    // Exponer la función cambiarEstado globalmente
    window.cambiarEstado = cambiarEstado;
}); 