document.getElementById("sidebarToggle").addEventListener("click", function () {
  document.getElementById("sidebar").classList.toggle("collapsed");
  document.querySelector(".main-content").classList.toggle("expanded");
});

// Funciones para el calendario
function mesAnterior() {
  // Lógica para cambiar al mes anterior
  console.log("Mes anterior");
}

function mesSiguiente() {
  // Lógica para cambiar al mes siguiente
  console.log("Mes siguiente");
}

// Función para ver detalle de cita
function verDetalleCita(id, event) {
  // Detener la propagación del evento si viene de un botón
  if (event) {
    event.stopPropagation();
  }

  // Aquí se podría hacer una petición AJAX para obtener los detalles de la cita
  console.log(`Ver detalle de cita ${id}`);

  // Marcar la cita seleccionada
  document.querySelectorAll(".cita-card").forEach((card) => {
    card.classList.remove("active");
  });

  // Añadir la clase active a la cita seleccionada
  const citaCard = document.querySelector(
    `.cita-card[onclick="verDetalleCita(${id})"]`
  );
  if (citaCard) {
    citaCard.classList.add("active");
  }
}

// Función para cancelar una cita
function cancelarCita(id, event) {
  // Detener la propagación del evento
  if (event) {
    event.stopPropagation();
  }

  if (confirm(`¿Estás seguro de que deseas cancelar la cita #${id}?`)) {
    // Aquí se haría la petición AJAX para cancelar la cita
    console.log(`Cancelando cita ${id}`);
  }
}

// Función para reactivar una cita cancelada
function reactivarCita(id, event) {
  // Detener la propagación del evento
  if (event) {
    event.stopPropagation();
  }

  if (confirm(`¿Deseas reactivar la cita #${id}?`)) {
    // Aquí se haría la petición AJAX para reactivar la cita
    console.log(`Reactivando cita ${id}`);
  }
}

// Función para confirmar una cita
function confirmarCita(id) {
  // Aquí se haría la petición AJAX para confirmar la cita
  console.log(`Confirmando cita ${id}`);
}

// Función para editar una cita
function editarCita(id) {
  // Aquí se abriría el modal con los datos de la cita para editar
  console.log(`Editando cita ${id}`);
  document.getElementById("nuevaCitaModal").style.display = "block";
  // En un entorno real, aquí cargarías los datos de la cita en el formulario
}

// Función para exportar citas
function exportarCitas() {
  // Lógica para exportar citas a un archivo
  console.log("Exportando citas...");
}

// Función para buscar citas
function buscarCitas() {
  const filtro = document.getElementById("buscarCita").value.toLowerCase();
  const estado = document.getElementById("filtroEstado").value;

  // Aquí filtrarías las citas según el texto y el estado seleccionado
  console.log(`Buscando citas con texto "${filtro}" y estado "${estado}"`);
}

// Función para filtrar citas por estado
function filtrarCitas() {
  const estado = document.getElementById("filtroEstado").value;
  console.log(`Filtrando citas por estado: ${estado}`);
}

// Función para abrir el modal de nueva cita
function nuevaCita() {
  document.getElementById("nuevaCitaModal").style.display = "block";
}

// Función para cerrar el modal
function cerrarModal() {
  document.getElementById("nuevaCitaModal").style.display = "none";
}

// Evento para cerrar el modal haciendo clic fuera de él
window.onclick = function (event) {
  const modal = document.getElementById("nuevaCitaModal");
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

// Manejar el envío del formulario de nueva cita
document
  .getElementById("formNuevaCita")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    // Aquí procesarías el formulario para guardar la nueva cita
    console.log("Guardando nueva cita...");
    cerrarModal();
  });

// Inicializar - Mostrar la primera cita
window.onload = function () {
  verDetalleCita(1001);
};

// Inicializar el calendario - hacer que los días con citas sean clickeables
document.querySelectorAll(".calendario td").forEach((td) => {
  if (td.textContent.trim() !== "") {
    td.addEventListener("click", function () {
      // Quitar la selección anterior
      document.querySelectorAll(".calendario td").forEach((el) => {
        el.classList.remove("selected");
      });
      // Seleccionar el día actual
      this.classList.add("selected");

      // Aquí cargarías las citas para el día seleccionado
      console.log(`Cargando citas para el día ${this.textContent}`);
    });
  }
});
