// Definir las funciones globalmente
function cambiarEstado(id, accion) {
  Swal.fire({
    title: `¿Desea ${accion} esta cita?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, continuar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (!result.isConfirmed) return;

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
        Swal.fire({
          title: '¡Éxito!',
          text: data.message,
          icon: 'success',
          confirmButtonColor: '#daa520'
        }).then(() => {
          location.reload();
        });
      } else {
        Swal.fire({
          title: 'Error',
          text: data.message,
          icon: 'error',
          confirmButtonColor: '#daa520'
        });
      }
    })
    .catch(error => {
      console.error('Error:', error);
      Swal.fire({
        title: 'Error',
        text: 'Error en la conexión con el servidor.',
        icon: 'error',
        confirmButtonColor: '#daa520'
      });
    });
  });
}

function cancelarCita(id) {
  Swal.fire({
    title: '¿Está seguro que desea cancelar esta cita?',
    text: "Esta acción no se puede deshacer",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, cancelar',
    cancelButtonText: 'No, mantener'
  }).then((result) => {
    if (!result.isConfirmed) return;
    
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
        Swal.fire({
          title: '¡Cancelada!',
          text: data.message,
          icon: 'success',
          confirmButtonColor: '#daa520'
        }).then(() => {
          location.reload();
        });
      } else {
        Swal.fire({
          title: 'Error',
          text: data.message,
          icon: 'error',
          confirmButtonColor: '#daa520'
        });
      }
    })
    .catch(error => {
      console.error('Error:', error);
      Swal.fire({
        title: 'Error',
        text: 'Error en la conexión con el servidor.',
        icon: 'error',
        confirmButtonColor: '#daa520'
      });
    });
  });
}

document.addEventListener("DOMContentLoaded", function () {
  const botones = document.querySelectorAll(".verDetalle");
  const botonesEliminar = document.querySelectorAll(".eliminarCita");
  const contenedor = document.getElementById("detallesCita");

  // Manejador para eliminar citas
  botonesEliminar.forEach(btn => {
    btn.addEventListener('click', function() {
      const idCita = this.getAttribute('data-id');
      
      Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('../../controllers/cambiar_estado_cita.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `idcita=${idCita}&estado=inactivo`
          })
          .then(response => response.json())
          .then(data => {
            if(data.success) {
              Swal.fire({
                title: '¡Eliminada!',
                text: 'La cita ha sido eliminada',
                icon: 'success',
                confirmButtonColor: '#daa520'
              }).then(() => {
                window.location.reload();
              });
            } else {
              Swal.fire({
                title: 'Error',
                text: 'No se pudo eliminar la cita',
                icon: 'error',
                confirmButtonColor: '#daa520'
              });
            }
          })
          .catch(error => {
            console.error('Error:', error);
            Swal.fire({
              title: 'Error',
              text: 'Error en la conexión con el servidor',
              icon: 'error',
              confirmButtonColor: '#daa520'
            });
          });
        }
      });
    });
  });

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

      // Generar el HTML con la nueva estructura
      const html = `
        <h3>Detalles de la Cita #${id}</h3>
        <div class="info-group">
          <div class="info-item">
            <i class="fas fa-user"></i>
            <span class="label">Cliente:</span>
            <span class="value">${nombre} ${apellido}</span>
          </div>
          <div class="info-item">
            <i class="fas fa-envelope"></i>
            <span class="label">Email:</span>
            <span class="value">${email}</span>
          </div>
          <div class="info-item">
            <i class="fas fa-phone"></i>
            <span class="label">Teléfono:</span>
            <span class="value">${telefono}</span>
          </div>
          <div class="info-item">
            <i class="fas fa-birthday-cake"></i>
            <span class="label">Nacimiento:</span>
            <span class="value">${fechaNacimiento}</span>
          </div>
          <div class="info-item">
            <i class="fas fa-calendar"></i>
            <span class="label">Fecha:</span>
            <span class="value">${fecha}</span>
          </div>
          <div class="info-item">
            <i class="fas fa-info-circle"></i>
            <span class="label">Estado:</span>
            <span class="value">
              <span class="badge ${getBadgeClass(estado)}">${estado.charAt(0).toUpperCase() + estado.slice(1)}</span>
            </span>
          </div>
        </div>

        <div class="servicios-solicitados">
          <h4><i class="fas fa-cut"></i> Servicios Solicitados</h4>
          <div class="servicio-item">
            ${servicio}
          </div>
        </div>

        <div class="actions-group">
          <button onclick="cambiarEstado(${id}, 'completar')" class="btn btn-completar">
            <i class="fas fa-check"></i> Completar
          </button>
          <button onclick="cambiarEstado(${id}, 'confirmar')" class="btn btn-confirmar">
            <i class="fas fa-bell"></i> Confirmar
          </button>
          <button onclick="cancelarCita(${id})" class="btn btn-cancelar">
            <i class="fas fa-times"></i> Cancelar
          </button>
        </div>
      `;

      contenedor.innerHTML = html;
    });
  });

  // Función auxiliar para obtener la clase del badge según el estado
  function getBadgeClass(estado) {
    const clases = {
      'pendiente': 'bg-warning',
      'confirmado': 'bg-primary',
      'completado': 'bg-success',
      'cancelado': 'bg-danger'
    };
    return clases[estado.toLowerCase()] || 'bg-secondary';
  }
});
