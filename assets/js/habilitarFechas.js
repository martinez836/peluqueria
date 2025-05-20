document.addEventListener("DOMContentLoaded", async function () {
    const listaFechas = document.getElementById("listaFechasDeshabilitadas");
    const botonHabilitar = document.getElementById("habilitarFechas");
    let fechasDeshabilitadas = [];

    // 🔄 Cargar las fechas deshabilitadas desde el servidor
    async function cargarFechas() {
        try {
            const response = await fetch("/peluqueria/controllers/fechasDeshabilitadas.php");
            fechasDeshabilitadas = await response.json();
            listaFechas.innerHTML = ""; // Limpia la lista antes de cargar nuevas fechas

            fechasDeshabilitadas.forEach(fecha => {
                const item = document.createElement("li");
                item.className = "list-group-item";
                item.textContent = fecha;
                item.addEventListener("click", () => item.classList.toggle("active")); // Seleccionar para habilitar
                listaFechas.appendChild(item);
            });
        } catch (error) {
            console.error("❌ Error al cargar las fechas:", error);
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
            await fetch("/peluqueria/controllers/eliminarFechas.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },                
                body: JSON.stringify({ fechas: fechasSeleccionadas })
            });

            cargarFechas(); // Recargar la lista en la modal
        } catch (error) {
            console.error("❌ Error al habilitar las fechas:", error);
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const modalFechas = document.getElementById("modalFechas");

    modalFechas.addEventListener("hidden.bs.modal", function () {
        location.reload(); // Recarga la página al cerrar la modal
    });
});

