document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });
        
        // Función para mostrar detalles de la cita
        function verDetalle(id) {
            // Aquí se podría hacer una petición AJAX para obtener los detalles de la cita
            
            // Quitar la clase active de todas las filas
            document.querySelectorAll('.table tbody tr').forEach(tr => {
                tr.classList.remove('active');
            });
            
            // Añadir la clase active a la fila seleccionada
            document.querySelector(`.table tbody tr[onclick="verDetalle(${id})"]`).classList.add('active');
            
            // Simulación de carga de detalles
            // En un entorno real, aquí cargarías los detalles desde el servidor
            
            // Actualizar el título del panel de detalles con el ID de la cita
            document.querySelector('#detallesCita h2').textContent = `Detalles de la Cita #${id}`;
            
            // Actualizar los detalles según el ID de la cita
            if (id === 1001) {
                actualizarDetallesCita({
                    cliente: "Carmen Díaz",
                    email: "carmen@gmail.com",
                    telefono: "310-456-7890",
                    fecha: "15/05/2025",
                    hora: "10:00 AM",
                    estado: "confirmed",
                    servicios: [
                        { nombre: "Corte de Cabello", precio: "35.000" },
                        { nombre: "Peinado", precio: "25.000" }
                    ],
                    total: "60.000",
                    notas: "Cliente habitual. Prefiere corte en capas y peinado con ondas suaves."
                });
            } else if (id === 1002) {
                actualizarDetallesCita({
                    cliente: "Roberto Fernández",
                    email: "roberto@gmail.com",
                    telefono: "315-789-1234",
                    fecha: "15/05/2025",
                    hora: "11:30 AM",
                    estado: "pending",
                    servicios: [
                        { nombre: "Corte de Cabello", precio: "30.000" }
                    ],
                    total: "30.000",
                    notas: "Primera visita. Prefiere corte clásico."
                });
            } else if (id === 1003) {
                actualizarDetallesCita({
                    cliente: "Patricia García",
                    email: "patricia@gmail.com",
                    telefono: "320-123-4567",
                    fecha: "15/05/2025",
                    hora: "2:00 PM",
                    estado: "confirmed",
                    servicios: [
                        { nombre: "Tinte", precio: "70.000" },
                        { nombre: "Peinado", precio: "25.000" }
                    ],
                    total: "95.000",
                    notas: "Desea tinte castaño oscuro. Cliente frecuente."
                });
            } else if (id === 1004) {
                actualizarDetallesCita({
                    cliente: "Javier Ramírez",
                    email: "javier@gmail.com",
                    telefono: "300-987-6543",
                    fecha: "16/05/2025",
                    hora: "9:15 AM",
                    estado: "completed",
                    servicios: [
                        { nombre: "Corte de Barba", precio: "25.000" }
                    ],
                    total: "25.000",
                    notas: "Cliente satisfecho con el servicio anterior."
                });
            } else if (id === 1005) {
                actualizarDetallesCita({
                    cliente: "Luisa Martínez",
                    email: "luisa@gmail.com",
                    telefono: "311-222-3333",
                    fecha: "16/05/2025",
                    hora: "3:30 PM",
                    estado: "cancelled",
                    servicios: [
                        { nombre: "Tratamiento Capilar", precio: "85.000" }
                    ],
                    total: "85.000",
                    notas: "Cancelada por la cliente. Reprogramar para la próxima semana."
                });
            }
        }
        
        // Función para actualizar los detalles de la cita en el panel derecho
        function actualizarDetallesCita(cita) {
            const detallesCita = document.getElementById('detallesCita');
            const clienteInfo = detallesCita.querySelector('.cliente-info');
            
            // Actualizar la información del cliente
            clienteInfo.innerHTML = `
                <p><strong>Cliente:</strong> ${cita.cliente}</p>
                <p><strong>Email:</strong> ${cita.email}</p>
                <p><strong>Teléfono:</strong> ${cita.telefono}</p>
                <p><strong>Fecha:</strong> ${cita.fecha}</p>
                <p><strong>Hora:</strong> ${cita.hora}</p>
                <p><strong>Estado:</strong> <span class="badge badge-${cita.estado === 'pending' ? 'pending' : 
                                                      cita.estado === 'confirmed' ? 'confirmed' : 
                                                      cita.estado === 'completed' ? 'completed' : 
                                                      'cancelled'}">${cita.estado === 'pending' ? 'Pendiente' : 
                                                                        cita.estado === 'confirmed' ? 'Confirmada' : 
                                                                        cita.estado === 'completed' ? 'Completada' : 
                                                                        'Cancelada'}</span></p>
            `;
            
            // Actualizar los servicios
            const servicioInfo = detallesCita.querySelector('.servicio-info');
            let serviciosHTML = '<h3>Servicios Solicitados</h3>';
            
            cita.servicios.forEach(servicio => {
                serviciosHTML += `
                    <div class="servicio-item">
                        <div>${servicio.nombre}</div>
                        <div>$${servicio.precio}</div>
                    </div>
                `;
            });
            
            serviciosHTML += `
                <div style="display: flex; justify-content: space-between; margin-top: 15px; font-weight: bold;">
                    <div>Total</div>
                    <div>$${cita.total}</div>
                </div>
            `;
            
            servicioInfo.innerHTML = serviciosHTML;
            
            // Actualizar las notas
            const notasCita = detallesCita.querySelector('.notas-cita');
            notasCita.innerHTML = `
                <h3>Notas</h3>
                <p>${cita.notas}</p>
            `;
            
            // Actualizar los botones según el estado
            const accionesCita = detallesCita.querySelector('.acciones-cita');
            
            if (cita.estado === 'cancelled') {
                accionesCita.innerHTML = `
                    <button class="btn btn-primary" onclick="reprogramarCita(${id})">
                        <i class="fas fa-calendar-plus"></i> Reprogramar
                    </button>
                `;
            } else if (cita.estado === 'completed') {
                accionesCita.innerHTML = `
                    <button class="btn btn-primary" onclick="nuevaCitaCliente()">
                        <i class="fas fa-calendar-plus"></i> Nueva Cita
                    </button>
                `;
            } else {
                accionesCita.innerHTML = `
                    <button class="btn btn-success" onclick="cambiarEstado(${id}, 'completada')">
                        <i class="fas fa-check"></i> Completar
                    </button>
                    <button class="btn btn-primary" onclick="confirmarCita(${id})">
                        <i class="fas fa-bell"></i> Confirmar
                    </button>
                    <button class="btn btn-danger" onclick="cancelarCita(${id})">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                `;
            }
        }
        
        // Función para editar una cita
        function editarCita(id, event) {
            // Detener la propagación del evento para que no se active verDetalle
            if (event) {
                event.stopPropagation();
            }
            
            // Aquí se podría abrir un modal para editar la cita
            alert(`Editando cita #${id}`);
            // En un entorno real, aquí abrirías un modal o redirigirías a una página de edición
        }
        
        // Función para eliminar una cita
        function eliminarCita(id, event) {
            // Detener la propagación del evento para que no se active verDetalle
            if (event) {
                event.stopPropagation();
            }
            
            if (confirm(`¿Estás seguro de que deseas eliminar la cita #${id}?`)) {
                // Aquí se haría la petición AJAX para eliminar la cita
                console.log(`Eliminando cita ${id}`);
                // Simulación de eliminación
                // En un entorno real, aquí eliminarías la cita en el servidor
            }
        }
        
        // Función para cambiar el estado de una cita
        function cambiarEstado(id, estado) {
            // Aquí se haría la petición AJAX para cambiar el estado
            console.log(`Cambiando estado de la cita ${id} a ${estado}`);
            // Simulación de cambio de estado
            // En un entorno real, aquí cambiarías el estado en el servidor
            
            // Actualizar la interfaz para reflejar el cambio
            const badgeElement = document.querySelector(`.table tbody tr[onclick="verDetalle(${id})"] .badge`);
            if (badgeElement) {
                badgeElement.className = `badge badge-${estado}`;
                badgeElement.textContent = estado.charAt(0).toUpperCase() + estado.slice(1);
                
                // Actualizar también en el panel de detalles si esta cita está seleccionada
                const activeFila = document.querySelector('.table tbody tr.active');
                if (activeFila && activeFila.getAttribute('onclick').includes(id)) {
                    const badgeDetalles = document.querySelector('#detallesCita .cliente-info .badge');
                    if (badgeDetalles) {
                        badgeDetalles.className = `badge badge-${estado}`;
                        badgeDetalles.textContent = estado.charAt(0).toUpperCase() + estado.slice(1);
                    }
                }
            }
        }
        
        // Función para confirmar una cita
        function confirmarCita(id) {
            cambiarEstado(id, 'confirmed');
            alert(`Se ha enviado una confirmación al cliente para la cita #${id}`);
        }
        
        // Función para cancelar una cita
        function cancelarCita(id) {
            if (confirm(`¿Estás seguro de que deseas cancelar la cita #${id}?`)) {
                cambiarEstado(id, 'cancelled');
            }
        }
        
        // Función para reprogramar una cita
        function reprogramarCita(id) {
            // Aquí se podría abrir un modal para reprogramar la cita
            alert(`Reprogramando cita #${id}`);
            // En un entorno real, aquí abrirías un modal para seleccionar nueva fecha/hora
        }
        
        // Función para crear una nueva cita
        function nuevaCita() {
            // Aquí se podría abrir un modal para crear una nueva cita
            alert('Creando nueva cita');
            // En un entorno real, aquí abrirías un modal o redirigirías a una página de creación
        }
        
        // Función para crear una nueva cita para un cliente existente
        function nuevaCitaCliente() {
            // Aquí se podría abrir un modal para crear una nueva cita para el cliente actual
            alert('Creando nueva cita para el cliente');
            // En un entorno real, aquí abrirías un modal con datos del cliente prellenados
        }
        
        // Función para exportar citas
        function exportarCitas() {
            // Aquí se haría la exportación de las citas
            alert('Exportando citas...');
            // En un entorno real, aquí exportarías las citas a un archivo CSV o Excel
        }
        
        // Función para buscar citas
        function buscarCitas() {
            const filtro = document.getElementById('buscarCita').value.toLowerCase();
            const filas = document.querySelectorAll('.table tbody tr');
            
            filas.forEach(fila => {
                const nombreCliente = fila.children[1].textContent.toLowerCase();
                if (nombreCliente.includes(filtro)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }
        
        // Inicializar - Mostrar la primera cita
        window.onload = function() {
            verDetalle(1001);
        };