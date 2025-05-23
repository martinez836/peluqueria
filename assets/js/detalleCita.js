document.addEventListener("DOMContentLoaded", function () {
  const botones = document.querySelectorAll(".verDetalle");
  const contenedor = document.getElementById("detallesCita");

  // Definir las funciones primero
  function cambiarEstado(id, accion) {
    if (!confirm(`¿Desea ${accion} esta cita?`)) return;

    const formData = new FormData();
    formData.append('idcita', id);
    formData.append('accion', accion);

    fetch("../../controllers/actualizarEstado.php", {
      method: "POST",
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
        // Actualizar el estado en el detalle visible
        const badge = document.querySelector("#detallesCita .cliente-info span.badge");
        if (badge) {
          badge.textContent = accion === 'confirmar' ? 'Confirmado' : 'Completado';
          badge.className = `badge text-light ${accion === 'confirmar' ? 'bg-primary' : 'bg-success'}`;
        }
        // Actualizar la vista de la tabla
        location.reload();
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert("Error en la conexión con el servidor.");
    });
  }

  function cancelarCita(id) {
    if (!confirm("¿Está seguro que desea cancelar esta cita?")) return;
    
    const formData = new FormData();
    formData.append('idcita', id);
    formData.append('accion', 'cancelar');

    fetch("../../controllers/actualizarEstado.php", {
      method: "POST",
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
        // Actualizar el estado en el detalle visible
        const badge = document.querySelector("#detallesCita .cliente-info span.badge");
        if (badge) {
          badge.textContent = 'Cancelado';
          badge.className = 'badge text-light bg-danger';
        }
        // Actualizar la vista de la tabla
        location.reload();
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert("Error en la conexión con el servidor.");
    });
  }

  // Luego el código que usa estas funciones
  botones.forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.getAttribute("data-id");
      const nombre = btn.getAttribute("data-nombre");
      const apellido = btn.getAttribute("data-apellido");
      const fecha = btn.getAttribute("data-fecha");
      const servicio = btn.getAttribute("data-servicio");
      const estado = btn.getAttribute("data-estado");
      const email = btn.getAttribute("data-email");
      const telefono = btn.getAttribute("data-telefono");
      const fechaNacimiento = btn.getAttribute("data-fechaNacimiento");

      // Limpiar el contenedor
      contenedor.innerHTML = "";

      // Título
      const titulo = document.createElement("h2");
      titulo.textContent = `Detalles de la Cita #${id}`;
      contenedor.appendChild(titulo);

      // Info del cliente
      const clienteInfo = document.createElement("div");
      clienteInfo.className = "cliente-info";

      const p1 = document.createElement("p");
      p1.innerHTML = `<strong>Cliente:</strong> ${nombre} ${apellido}`;
      clienteInfo.appendChild(p1);

      const p2 = document.createElement("p");
      p2.innerHTML = `<strong>Email:</strong> ${email}`;
      clienteInfo.appendChild(p2);

      const p3 = document.createElement("p");
      p3.innerHTML = `<strong>Teléfono:</strong> ${telefono}`;
      clienteInfo.appendChild(p3);

      const fechaNace = document.createElement("p");
      fechaNace.innerHTML = `<strong>Fecha de Nacimiento:</strong> ${fechaNacimiento}`;
      clienteInfo.appendChild(fechaNace);

      const p4 = document.createElement("p");
      const badge = document.createElement("span");
      badge.classList.add("badge", "text-light");

      badge.textContent = estado.charAt(0).toUpperCase() + estado.slice(1);

      p4.innerHTML = `<strong>Fecha:</strong> ${fecha} <br><strong>Estado:</strong> `;
      p4.appendChild(badge);

      clienteInfo.appendChild(p4);
      contenedor.appendChild(clienteInfo);

      // Info de servicio
      const servicioInfo = document.createElement("div");
      servicioInfo.className = "servicio-info";

      const h3 = document.createElement("h3");
      h3.textContent = "Servicios Solicitados";
      servicioInfo.appendChild(h3);

      const servicioItem = document.createElement("div");
      servicioItem.className = "servicio-item";
      servicioItem.textContent = servicio;
      servicioInfo.appendChild(servicioItem);

      contenedor.appendChild(servicioInfo);

      // Notas (estáticas por ahora)
      const notas = document.createElement("div");
      notas.className = "notas-cita";

      const hNotas = document.createElement("h3");
      hNotas.textContent = "Notas";
      notas.appendChild(hNotas);

      const pNotas = document.createElement("p");
      pNotas.textContent =
        "Cliente habitual. Prefiere corte en capas y peinado con ondas suaves.";
      notas.appendChild(pNotas);

      contenedor.appendChild(notas);

      // Botones de acción
      const acciones = document.createElement("div");
      acciones.className = "acciones-cita";

      const btnCompletar = document.createElement("button");
      btnCompletar.className = "btn btn-success";
      btnCompletar.innerHTML = `<i class="fas fa-check"></i> Completar`;
      btnCompletar.onclick = () => cambiarEstado(id, "completar");

      const btnConfirmar = document.createElement("button");
      btnConfirmar.className = "btn btn-primary";
      btnConfirmar.innerHTML = `<i class="fas fa-bell"></i> Confirmar`;
      btnConfirmar.onclick = () => cambiarEstado(id, "confirmar");

      const btnCancelar = document.createElement("button");
      btnCancelar.className = "btn btn-danger";
      btnCancelar.innerHTML = `<i class="fas fa-times"></i> Cancelar`;
      btnCancelar.onclick = () => cancelarCita(id);

      acciones.appendChild(btnCompletar);
      acciones.appendChild(btnConfirmar);
      acciones.appendChild(btnCancelar);

      contenedor.appendChild(acciones);
    });
  });
});
