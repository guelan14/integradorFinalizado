// Obtener el modal y los botones
var modal = document.getElementById("createUserModal");
var openModalBtn = document.getElementById("openModalBtn");
var closeModalBtn = document.getElementById("closeModalBtn");

// Mostrar el modal cuando se hace clic en el botón
openModalBtn.onclick = function () {
  modal.style.display = "block";
};

// Cerrar el modal cuando se hace clic en el botón de cerrar
closeModalBtn.onclick = function () {
  modal.style.display = "none";
};

// Cerrar el modal si se hace clic fuera del modal
window.onclick = function (event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
};

// Función para cargar los empleados en la tabla
async function loadEmployees() {
  try {
    const response = await fetch("../../controllers/UserController.php");
    const employees = await response.json();

    const employeeList = document.getElementById("employee-list");

    // Limpiar la tabla antes de agregar los nuevos empleados
    employeeList.innerHTML = "";

    employees.forEach((employee) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${employee.id}</td>
        <td>${employee.username}</td>
        <td>${employee.first_name} ${employee.last_name}</td>
        <td>${employee.birth_date}</td>
        <td>${employee.role}</td>
        <td>
            <button class="edit-button" data-item-id="${employee.id}" onclick="editMenuItem(${employee.id})">
                <i class="fas fa-edit"></i> Editar
            </button>
        </td>
        <td>
            <button class="delete-button" data-item-id="${employee.id}" onclick="deleteMenuItem(${employee.id})">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </td>
      `;
      employeeList.appendChild(row);
    });
  } catch (error) {
    console.error("Error al cargar empleados:", error);
  }
}

async function deleteMenuItem(itemId) {
  // Confirmación antes de eliminar
  if (!confirm("¿Estás seguro de que deseas eliminar este ítem?")) {
    return;
  }

  // Datos a enviar (puedes enviar el id del ítem que deseas eliminar)
  const deleteData = {
    action: "delete", // Acción para eliminar
    id: itemId, // ID del ítem a eliminar
  };

  try {
    // Realizar la solicitud POST al controlador de eliminar
    const response = await fetch("../../controllers/MenuController.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(deleteData), // Enviar los datos de eliminación
    });

    const data = await response.json();

    if (data.message === "Ítem eliminado exitosamente.") {
      alert("Ítem eliminado exitosamente.");
      loadItems(); // Recargar la lista de ítems después de eliminar
    } else {
      alert("Error al eliminar el ítem.");
    }
  } catch (error) {
    console.error("Error al enviar la solicitud de eliminación:", error);
  }
}

// Enviar el formulario para crear un nuevo usuario
document.getElementById("createUserForm").onsubmit = async function (e) {
  e.preventDefault();

  // Obtener los valores del formulario
  const userData = {
    username: document.getElementById("username").value,
    password: document.getElementById("password").value,
    first_name: document.getElementById("first_name").value,
    last_name: document.getElementById("last_name").value,
    birth_date: document.getElementById("birth_date").value,
    role: document.getElementById("role").value,
    action: "create", // Acción para eliminar
  };

  try {
    const response = await fetch("../../controllers/UserController.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(userData),
    });

    const data = await response.json();

    if (data.message === "Usuario creado exitosamente.") {
      alert("Usuario creado exitosamente.");
      loadEmployees(); // Recargar items después de agregar
      modal.style.display = "none"; // Cerrar el modal
    } else {
      alert("Error al crear el usuario.");
    }
  } catch (error) {
    console.error("Error al enviar los datos:", error);
  }
};

window.onload = loadEmployees;
