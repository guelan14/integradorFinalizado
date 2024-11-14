// adminTables.js

// Función para cargar las mesas al inicio
async function loadTablesAdmin() {
  try {
    const response = await fetch("../../controllers/TableController.php");
    const tables = await response.json();
    renderTablesAdmin(tables);
  } catch (error) {
    console.error("Error loading tables:", error);
  }
}

// Función para renderizar las mesas en la tabla de administración
function renderTablesAdmin(tables) {
  const tableBody = document.getElementById("order-list");
  tableBody.innerHTML = ""; // Limpiar la tabla

  tables.forEach((table) => {
    const row = document.createElement("tr");

    // Celda para el número de mesa
    const tableNumberCell = document.createElement("td");
    tableNumberCell.textContent = `Mesa ${table.id}`;

    row.appendChild(tableNumberCell);

    // Celda para el selector de estado
    const statusCell = document.createElement("td");
    const select = document.createElement("select");
    // Configurar las opciones del selector según el estado actual
    select.innerHTML = `
        <option value="free" ${
          table.status === "free" ? "selected" : ""
        }>Libre</option>
        <option value="occupied" ${
          table.status === "occupied" ? "selected" : ""
        }>Ocupada</option>
    `;

    // Evento para cambiar el estado de la mesa
    select.addEventListener("change", () => {
      toggleTableStatus(table.id, select.value);
    });

    statusCell.appendChild(select);
    row.appendChild(statusCell);

    // Celda para el botón de eliminar
    const deleteCell = document.createElement("td");
    const deleteButton = document.createElement("button");
    deleteButton.classList.add("delete-button");
    deleteButton.dataset.itemId = table.id; // Asociar el ID de la mesa
    deleteButton.innerHTML = '<i class="fas fa-trash"></i> Eliminar';

    // Evento para eliminar la mesa
    deleteButton.addEventListener("click", () => {
      deleteTable(table.id); // Llamar a la función para eliminar la mesa
    });

    deleteCell.appendChild(deleteButton);
    row.appendChild(deleteCell);

    tableBody.appendChild(row);
  });
}

// Función para eliminar la mesa
function deleteTable(tableId) {
  // Aquí puedes agregar la lógica para eliminar la mesa desde el servidor
  // Por ejemplo, podrías enviar una solicitud AJAX o hacer un fetch con el ID de la mesa

  console.log(`Eliminando mesa ID: ${tableId}`);
  // Ejemplo: Enviar la solicitud de eliminación al servidor
  fetch("../../controllers/TableController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ action: "delete", id: tableId }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.message === "Mesa eliminada correctamente.") {
        alert("Mesa eliminada correctamente.");
        // Aquí puedes eliminar la fila de la mesa de la tabla en el DOM
        document
          .querySelector(`button[data-item-id="${tableId}"]`)
          .closest("tr")
          .remove();
      } else {
        alert("Error al eliminar la mesa.");
      }
    })
    .catch((error) => console.error("Error al eliminar la mesa:", error));
}

// Función para cambiar el estado de una mesa
async function toggleTableStatus(id, newStatus) {
  try {
    const response = await fetch("../../controllers/TableController.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ action: "updateStatus", id, status: newStatus }),
    });
    const result = await response.json();
    console.log(result.message);
  } catch (error) {
    console.error("Error updating table status:", error);
  }
}

// Función para abrir el modal para crear nueva mesa
document.getElementById("openModalBtn").addEventListener("click", function () {
  document.getElementById("createTableModal").style.display = "block";
});

// Función para cerrar el modal
document.getElementById("closeModalBtn").addEventListener("click", function () {
  document.getElementById("createTableModal").style.display = "none";
});

// Función para crear una nueva mesa
async function createNewTable(status) {
  try {
    const response = await fetch("../../controllers/TableController.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ action: "create", status: status }),
    });
    const result = await response.json();
    console.log(result.message);
    loadTablesAdmin(); // Recargar las mesas
  } catch (error) {
    console.error("Error creating new table:", error);
  }
}

// Escuchar el evento de enviar el formulario para crear la mesa
document
  .getElementById("createTableForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    const status = document.querySelector('input[name="status"]:checked').value;
    createNewTable(status);
    document.getElementById("createTableModal").style.display = "none"; // Cerrar el modal
  });

// Cargar las mesas al cargar la página
loadTablesAdmin();
