// Función para cargar los items del menú
async function loadMenuItems() {
  try {
    const response = await fetch("../../controllers/MenuController.php");
    const menuItems = await response.json();

    const menuListBody = document.getElementById("menu-list-body");
    menuListBody.innerHTML = ""; // Limpiar la lista antes de cargar

    // Iterar sobre cada categoría de menú
    for (const category in menuItems) {
      const items = menuItems[category];
      items.forEach((item) => {
        const row = document.createElement("tr");
        row.innerHTML = `
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>${item.price}</td>
                <td>${item.description}</td> 
                <td>${category}</td> 
                <td>
                    <button class="edit-button" data-item-id="${item.id}" onclick="openEditModal(${item.id})">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                </td>
                <td>
                    <button class="delete-button" data-item-id="${item.id}" onclick="deleteMenuItem(${item.id})">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </td>
            `;
        menuListBody.appendChild(row);
      });
    }
  } catch (error) {
    console.error("Error cargando items del menú:", error);
  }
}

// Función para eliminar un ítem del menú
async function deleteMenuItem(id) {
  if (confirm("¿Estás seguro de que quieres eliminar este ítem?")) {
    try {
      const response = await fetch("../../controllers/MenuController.php", {
        method: "POST",
        body: JSON.stringify({ id: id, action: "delete" }),
        headers: {
          "Content-Type": "application/json",
        },
      });
      loadMenuItems(); // Recargar items después de agregar
    } catch (error) {
      console.error("Error al eliminar el item:", error);
    }
  }
}

// Función para agregar un nuevo ítem del menú
// Función para agregar un nuevo ítem del menú
async function addMenuItem(event) {}

function updateMenuItem(item) {
  console.log(item);
  fetch("../../controllers/MenuController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      action: "update",
      id: item.id,
      name: item.name,
      category: item.category,
      price: item.price,
      description: item.description,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data); // Aquí puedes manejar la respuesta
      alert(data.message); // Mensaje de éxito o error
    })
    .catch((error) => console.error("Error updating item:", error));
}

// Funciones para manejar el modal
function openModal() {
  document.getElementById("add-menu-item-modal").style.display = "block";
}

function closeModal() {
  document.getElementById("add-menu-item-modal").style.display = "none";
}

// Función para abrir el modal y cargar los datos del ítem
async function openEditModal(itemId) {
  try {
    // Crear el objeto con la acción y la id del ítem
    const data = {
      action: "getItem", // Acción para obtener los datos del ítem
      id: itemId, // ID del ítem que se desea editar
    };

    // Realizar la solicitud POST para obtener los datos del ítem a editar
    const response = await fetch("../../controllers/MenuController.php", {
      method: "POST", // Método POST para enviar los datos
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data), // Enviar los datos en formato JSON
    });

    // Procesar la respuesta
    const result = await response.json();

    if (result) {
      // Rellenar el modal con los datos del ítem
      document.getElementById("edit-name").value = result.name;
      document.getElementById("edit-category").value = result.category;
      document.getElementById("edit-price").value = result.price;
      document.getElementById("edit-description").value = result.description;
      document.getElementById("edit-image").value = ""; // Si ya existe una imagen, puedes asignarla aquí

      // Abrir el modal
      document.getElementById("edit-menu-item-modal").style.display = "block";

      // Aquí es donde puedes llamar a `updateMenuItem` pasando el objeto `result` (que es el `item`)
      document.getElementById("save-edit-button").onclick = async function (
        event
      ) {
        event.preventDefault(); // Evitar que el formulario se envíe y recargue la página

        // Crear un objeto actualizado con los valores del modal
        const updatedItem = {
          id: result.id, // Mantener el mismo id del item original
          name: document.getElementById("edit-name").value,
          category: document.getElementById("edit-category").value,
          price: document.getElementById("edit-price").value,
          description: document.getElementById("edit-description").value,
        };

        updateMenuItem(updatedItem); // Pasar el objeto actualizado a la función de actualización
      };
    }
  } catch (error) {
    console.error("Error al obtener los datos:", error);
  }
}

// Función para cerrar el modal
function closeEditModal() {
  document.getElementById("edit-menu-item-modal").style.display = "none";
}

// Cargar items del menú al iniciar la página
document.addEventListener("DOMContentLoaded", loadMenuItems);

// Eventos para botones
document
  .getElementById("add-menu-item-button")
  .addEventListener("click", openModal);
document
  .getElementById("add-menu-item-form")
  .addEventListener("submit", addMenuItem);
document.querySelector(".close").addEventListener("click", closeModal);
