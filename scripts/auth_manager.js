// auth_manager.js

document
  .getElementById("login-form")
  .addEventListener("submit", async function (event) {
    event.preventDefault(); // Evita el envío del formulario tradicional

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    try {
      const response = await fetch("../../controllers/AuthController.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password }),
      });

      const result = await response.json();

      if (result.success) {
        console.log("Inicio de sesión exitoso");
        window.location.href = "../../pages/admin/admin_orders.php";
      } else {
        console.error("Error de inicio de sesión:", result.message);
        alert(result.message);
      }
    } catch (error) {
      console.error("Error en la autenticación:", error);
    }
  });
