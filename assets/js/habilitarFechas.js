document.addEventListener("DOMContentLoaded", async function () {
    const listaFechas = document.getElementById("listaFechasDeshabilitadas");
    const botonHabilitar = document.getElementById("habilitarFechas");
    let fechasDeshabilitadas = [];

    // 🔄 Cargar las fechas deshabilitadas desde el servidor
    async function cargarFechas() {
        try {
            const response = await fetch("../../controllers/fechasDeshabilitadas.php");
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            fechasDeshabilitadas = await response.json();
            console.log('Fechas deshabilitadas cargadas:', fechasDeshabilitadas);
            
            listaFechas.innerHTML = ""; // Limpia la lista antes de cargar nuevas fechas

            if (!Array.isArray(fechasDeshabilitadas)) {
                console.error('Las fechas recibidas no son un array:', fechasDeshabilitadas);
                return;
            }

            fechasDeshabilitadas.forEach(fecha => {
                const item = document.createElement("li");
                item.className = "list-group-item";
                item.textContent = fecha;
                item.addEventListener("click", () => item.classList.toggle("active")); // Seleccionar para habilitar
                listaFechas.appendChild(item);
            });
        } catch (error) {
            console.error("❌ Error al cargar las fechas:", error);
            alert("Error al cargar las fechas. Por favor, intenta de nuevo.");
        }
    }

    // 🟢 Abrir la modal y cargar las fechas
    document.querySelector("[data-bs-target='#modalFechas']").addEventListener("click", cargarFechas);

    // ✅ Habilitar fechas seleccionadas
    botonHabilitar.addEventListener("click", async function () {
        const fechasSeleccionadas = Array.from(listaFechas.querySelectorAll(".active")).map(item => item.textContent);

        if (fechasSeleccionadas.length === 0) {
            alert("Selecciona al menos una fecha para habilitar.");
            return;
        }

        try {
            const response = await fetch("../../controllers/eliminarFechas.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },                
                body: JSON.stringify({ fechas: fechasSeleccionadas })
            });

            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }

            const result = await response.json();
            
            if (result.success) {
                alert("Fechas habilitadas correctamente");
                await cargarFechas(); // Recargar la lista en la modal
                location.reload(); // Recargar la página para actualizar el calendario
            } else {
                throw new Error(result.error || 'Error al habilitar las fechas');
            }
        } catch (error) {
            console.error("❌ Error al habilitar las fechas:", error);
            alert("Error al habilitar las fechas. Por favor, intenta de nuevo.");
        }
    });
});

// Recargar la página cuando se cierra el modal
document.addEventListener("DOMContentLoaded", function () {
    const modalFechas = document.getElementById("modalFechas");
    
    modalFechas.addEventListener("hidden.bs.modal", function () {
        location.reload(); // Recarga la página al cerrar la modal
    });
});

