document.addEventListener("DOMContentLoaded", function () {
  const botones = document.querySelectorAll(".verDetalle");
  const contenedor = document.getElementById("detallesCita");

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

      const p4 = document.createElement("p");
      const badge = document.createElement("span");
        badge.classList.add("badge", "text-light");

        switch (estado.toLowerCase()) {
        case "confirmada":
            badge.classList.add("bg-primary");
            break;
        case "completada":
            badge.classList.add("bg-success");
            break;
        case "cancelada":
            badge.classList.add("bg-danger");
            break;
        default:
            badge.classList.add("bg-secondary");
            break;
        }

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
      btnCompletar.onclick = () => cambiarEstado(id, "completada");

      const btnConfirmar = document.createElement("button");
      btnConfirmar.className = "btn btn-primary";
      btnConfirmar.innerHTML = `<i class="fas fa-bell"></i> Confirmar`;
      btnConfirmar.onclick = () => confirmarCita(id);

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

  function confirmarCita(id) {
    if (!confirm("¿Confirmar esta cita?")) return;

    fetch("../../controllers/actualizarEstado.php?id=$idcitas", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `idcita=${encodeURIComponent(id)}`,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.message);

          // Actualizar el estado en el detalle visible
          const badge = document.querySelector(
            "#detallesCita .cliente-info span.badge");
          if (badge) {
            badge.textContent = "Confirmado";
            badge.className = "badge badge-confirmed";
          }

          // Opcional: actualizar el estado en la tabla también
          const fila = document
            .querySelector(`#tabla-pedidos button[data-id='${id}']`)
            .closest("tr");
          const celdaEstado = fila.querySelector("td:nth-child(6) .badge");
          if (celdaEstado) {
            celdaEstado.textContent = "Confirmado";
            celdaEstado.className = "badge badge-confirmed";
          }
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(() => alert("Error en la conexión con el servidor."));
  }
});
