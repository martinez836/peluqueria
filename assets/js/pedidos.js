// Función para alternar el menú lateral
document.getElementById("sidebarToggle").addEventListener("click", function () {
  document.getElementById("sidebar").classList.toggle("collapsed");
  document.querySelector(".main-content").classList.toggle("expanded");
});

// Función para mostrar detalles del pedido
function verDetalle(id) {
  // Aquí se podría hacer una petición AJAX para obtener los detalles del pedido
  // Por ahora solo marcaremos la fila como activa

  // Quitar la clase active de todas las filas
  document.querySelectorAll(".table tbody tr").forEach((tr) => {
    tr.classList.remove("active");
  });

  // Añadir la clase active a la fila seleccionada
  document
    .querySelector(`.table tbody tr[onclick="verDetalle(${id})"]`)
    .classList.add("active");

  // Simulación de carga de detalles
  // En un entorno real, aquí cargarías los detalles desde el servidor
}

// Función para eliminar un pedido
function eliminarPedido(id, event) {
  // Detener la propagación del evento para que no se active verDetalle
  if (event) {
    event.stopPropagation();
  }

  if (confirm(`¿Estás seguro de que deseas eliminar el pedido #${id}?`)) {
    // Aquí se haría la petición AJAX para eliminar el pedido
    console.log(`Eliminando pedido ${id}`);
    // Simulación de eliminación
    // En un entorno real, aquí eliminarías el pedido en el servidor
  }
}

// Función para cambiar el estado de un pedido
function cambiarEstado(id, estado) {
  // Aquí se haría la petición AJAX para cambiar el estado
  console.log(`Cambiando estado del pedido ${id} a ${estado}`);
  // Simulación de cambio de estado
  // En un entorno real, aquí cambiarías el estado en el servidor
}

// Función para cancelar un pedido
function cancelarPedido(id) {
  if (confirm(`¿Estás seguro de que deseas cancelar el pedido #${id}?`)) {
    cambiarEstado(id, "cancelado");
  }
}

// Función para exportar pedidos
function exportarPedidos() {
  // Aquí se haría la exportación de los pedidos
  console.log("Exportando pedidos...");
  // En un entorno real, aquí exportarías los pedidos a un archivo
}

// Función para buscar pedidos
function buscarPedidos() {
  const filtro = document.getElementById("buscarPedido").value.toLowerCase();
  const filas = document.querySelectorAll(".table tbody tr");

  filas.forEach((fila) => {
    const nombreCliente = fila.children[1].textContent.toLowerCase();
    if (nombreCliente.includes(filtro)) {
      fila.style.display = "";
    } else {
      fila.style.display = "none";
    }
  });
}

// Inicializar - Mostrar el primer pedido
window.onload = function () {
  verDetalle(12345);
};
