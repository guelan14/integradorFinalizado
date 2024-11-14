async function loadTables() {
  try {
    const response = await fetch("../controllers/TableController.php");
    const data = await response.json();
    renderTables(data);
  } catch (error) {
    console.error("Error loading tables:", error);
  }
}

function renderTables(tables) {
  const tablesContainer = document.querySelector(".tables-container");
  tablesContainer.innerHTML = ""; // Limpiar el contenedor

  tables.forEach((table) => {
    const tableLink = document.createElement("a");
    tableLink.href = `menu.php?mode=local&table=${table.id}`;
    tableLink.className = `table ${table.status}`;

    const img = document.createElement("img");
    img.src = `../images/${
      table.status === "free" ? "freeTable.svg" : "occupiedTable.svg"
    }`;
    img.alt = table.status === "free" ? "Mesa Libre" : "Mesa Ocupada";

    const tableNumber = document.createElement("span");
    tableNumber.className = "table-number";
    tableNumber.textContent = `Mesa ${table.id}`;

    tableLink.appendChild(img);
    tableLink.appendChild(tableNumber);

    // Evento de clic para cambiar el estado de la mesa
    tableLink.addEventListener("click", async (event) => {
      // Evitar la redirección si la mesa está ocupada
      if (table.status === "occupied") {
        alert("Esta mesa está ocupada. No puedes entrar.");
        event.preventDefault(); // Evitar el enlace
        return; // Salir de la función
      }

      // Si la mesa está libre, cambiar el estado a ocupado
      const newStatus = "occupied";
      localStorage.setItem("selectedTableId", table.id);
      localStorage.setItem("deliveryMode", "local");

      try {
        const response = await fetch("../controllers/TableController.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            action: "updateStatus",
            id: table.id,
            status: newStatus,
          }),
        });

        const result = await response.json();

        // Redirigir al menú después de cambiar el estado
        window.location.href = `menu.php?mode=local&table=${table.id}`;
      } catch (error) {
        console.error("Error updating table status:", error);
      }
    });

    tablesContainer.appendChild(tableLink);
  });
}

// Cargar las mesas cuando se carga el documento
document.addEventListener("DOMContentLoaded", loadTables);
