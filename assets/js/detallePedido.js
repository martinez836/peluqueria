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
        // Limpiar el contenedor
        contenedor.innerHTML = "";

        if (detalles.length === 0) {
            const mensaje = document.createElement("p");
            mensaje.textContent = "No se encontraron detalles para este pedido.";
            contenedor.appendChild(mensaje);
            return;
        }

        // Título
        const titulo = document.createElement("h2");
        titulo.textContent = `Detalles del Pedido #${detalles[0].idpedidos}`;
        contenedor.appendChild(titulo);

        // Información general del pedido
        const infoGeneral = document.createElement("div");
        infoGeneral.className = "info-pedido mb-4";

        // Cliente
        const clienteParrafo = document.createElement("p");
        const clienteLabel = document.createElement("strong");
        clienteLabel.textContent = "Cliente: ";
        clienteParrafo.appendChild(clienteLabel);
        clienteParrafo.appendChild(document.createTextNode(`${detalles[0].nombres} ${detalles[0].apellidos}`));
        infoGeneral.appendChild(clienteParrafo);

        // Fecha
        const fechaParrafo = document.createElement("p");
        const fechaLabel = document.createElement("strong");
        fechaLabel.textContent = "Fecha: ";
        fechaParrafo.appendChild(fechaLabel);
        fechaParrafo.appendChild(document.createTextNode(new Date(detalles[0].fecha).toLocaleDateString()));
        infoGeneral.appendChild(fechaParrafo);

        // Estado
        const estadoParrafo = document.createElement("p");
        const estadoLabel = document.createElement("strong");
        estadoLabel.textContent = "Estado: ";
        const estadoBadge = document.createElement("span");
        estadoBadge.className = `badge badge-${detalles[0].estado}`;
        estadoBadge.textContent = detalles[0].estado;
        estadoParrafo.appendChild(estadoLabel);
        estadoParrafo.appendChild(estadoBadge);
        infoGeneral.appendChild(estadoParrafo);

        // Dirección
        if (detalles[0].direccion) {
            const direccionParrafo = document.createElement("p");
            const direccionLabel = document.createElement("strong");
            direccionLabel.textContent = "Dirección: ";
            direccionParrafo.appendChild(direccionLabel);
            direccionParrafo.appendChild(document.createTextNode(detalles[0].direccion));
            infoGeneral.appendChild(direccionParrafo);
        }

        // Barrio
        if (detalles[0].barrio) {
            const barrioParrafo = document.createElement("p");
            const barrioLabel = document.createElement("strong");
            barrioLabel.textContent = "Barrio: ";
            barrioParrafo.appendChild(barrioLabel);
            barrioParrafo.appendChild(document.createTextNode(detalles[0].barrio));
            infoGeneral.appendChild(barrioParrafo);
        }

        // Total
        const totalParrafo = document.createElement("p");
        const totalLabel = document.createElement("strong");
        totalLabel.textContent = "Total del Pedido: ";
        totalParrafo.appendChild(totalLabel);
        totalParrafo.appendChild(document.createTextNode(`$${detalles[0].total}`));
        infoGeneral.appendChild(totalParrafo);

        contenedor.appendChild(infoGeneral);

        // Tabla de productos
        const tabla = document.createElement("table");
        tabla.className = "table table-striped";

        // Crear encabezado
        const thead = document.createElement("thead");
        const headerRow = document.createElement("tr");
        const headers = ["Producto", "Descripción", "Precio Unitario", "Cantidad", "Subtotal"];
        
        headers.forEach(headerText => {
            const th = document.createElement("th");
            th.textContent = headerText;
            headerRow.appendChild(th);
        });
        
        thead.appendChild(headerRow);
        tabla.appendChild(thead);

        // Crear cuerpo de la tabla
        const tbody = document.createElement("tbody");
        
        detalles.forEach(item => {
            const tr = document.createElement("tr");

            // Celda del producto con imagen
            const tdProducto = document.createElement("td");
            const divProducto = document.createElement("div");
            divProducto.className = "d-flex align-items-center";
            
            const img = document.createElement("img");
            img.src = item.imagen_producto;
            img.alt = item.nombre_producto;
            img.className = "img-thumbnail me-2";
            img.style.width = "50px";
            img.style.height = "50px";
            img.style.objectFit = "cover";
            
            divProducto.appendChild(img);
            divProducto.appendChild(document.createTextNode(item.nombre_producto));
            tdProducto.appendChild(divProducto);
            tr.appendChild(tdProducto);

            // Descripción
            const tdDescripcion = document.createElement("td");
            tdDescripcion.textContent = item.descripcion_producto;
            tr.appendChild(tdDescripcion);

            // Precio unitario
            const tdPrecio = document.createElement("td");
            tdPrecio.textContent = `$${item.precio_unitario}`;
            tr.appendChild(tdPrecio);

            // Cantidad
            const tdCantidad = document.createElement("td");
            tdCantidad.textContent = item.cantidad;
            tr.appendChild(tdCantidad);

            // Subtotal
            const tdSubtotal = document.createElement("td");
            tdSubtotal.textContent = `$${item.subtotal}`;
            tr.appendChild(tdSubtotal);

            tbody.appendChild(tr);
        });

        tabla.appendChild(tbody);
        contenedor.appendChild(tabla);

        // Agregar los botones de acción con el ID del pedido
        const accionesEstado = document.querySelector('.acciones-estado');
        if (accionesEstado) {
            accionesEstado.dataset.pedidoId = detalles[0].idpedidos;
        }
    }

    // Exponer la función cambiarEstado globalmente
    window.cambiarEstado = cambiarEstado;
}); 