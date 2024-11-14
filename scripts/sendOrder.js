const checkoutButton = document.querySelector(".send");

if (checkoutButton) {
  checkoutButton.addEventListener("click", async (event) => {
    event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

    const storedCart = localStorage.getItem("cart");
    const storedDeliveryMode = localStorage.getItem("deliveryMode");
    const storedTable = localStorage.getItem("selectedTableId");

    if (storedCart) {
      const cart = JSON.parse(storedCart);
      const orderData = {
        items: cart,
        deliveryMode: storedDeliveryMode,
        selectedTable: storedTable,
      };

      try {
        // Enviar datos a PHP
        const response = await fetch("../controllers/OrderController.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(orderData),
        });

        if (response.ok) {
          const result = await response.json();
          if (result.orderId) {
            const orderId = result.orderId;
            localStorage.setItem("orderId", result.orderId);
            localStorage.removeItem("cart");
            localStorage.removeItem("selectedTableId");
            localStorage.removeItem("deliveryMode");
            alert("Orden procesada exitosamente! ID de orden: " + orderId);
            //Como estamos en desarrollo sin metodos de pago hacemos que en estos dos metodos ya pagaron para actualizar
            if (
              storedDeliveryMode == "pickup" ||
              storedDeliveryMode == "delivery"
            ) {
              try {
                const response = await fetch(
                  "../controllers/OrderController.php",
                  {
                    method: "POST",
                    headers: {
                      "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ orderId: orderId }), // Enviamos el orderId en el cuerpo de la solicitud
                  }
                );

                // Redireccionamos si la solicitud fue exitosa
                localStorage.removeItem("orderId");
                window.location.href = "../index.php";
              } catch (error) {
                console.error("Error en la solicitud:", error);
              }
            }
          } else {
            alert(
              "Error al procesar la orden: " +
                (result.error || "No se pudo obtener el ID de la orden.")
            );
          }
        } else {
          const errorResponse = await response.json();
          alert("Error al procesar la orden: " + errorResponse.error);
        }
      } catch (error) {
        alert("Error en la conexión: " + error.message);
      }
    }
  });
}
