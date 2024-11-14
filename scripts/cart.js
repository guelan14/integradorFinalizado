let cart = {};
let deliveryCost = 0; // Inicializa el costo de entrega en 0
let serviceFee = 1.0;
let cartHeader;

// Ir atrás en el carrito
function goBack() {
  window.history.back();
}

// Añadir item al carrito
function addToCart(item) {
  // Verifica si el artículo ya está en el carrito
  if (cart[item.id]) {
    cart[item.id].quantity += 1; // Incrementa la cantidad si ya está en el carrito
  } else {
    // Añade el artículo al carrito con su id
    cart[item.id] = {
      name: item.name,
      price: item.price,
      quantity: 1,
      id: item.id, // Almacena el id
    };
  }
  updateCartUI(); // Actualiza la interfaz del carrito
  saveCart();
  showNotification(`${item.name} Añadido al carrito`, "added");
}

// Quitar item del carrito
function removeFromCart(item) {
  if (cart[item.id]) {
    if (cart[item.id].quantity > 1) {
      cart[item.id].quantity -= 1;
    } else {
      delete cart[item.id];
    }
    updateCartUI();
    saveCart();
    showNotification(`${item.name} eliminado del carrito`, "removed");
  }
}

function cancelOrder() {
  // Muestra una confirmación antes de cancelar
  const confirmation = confirm("¿Desea realmente cancelar la orden?");
  if (confirmation) {
    const id = localStorage.getItem("selectedTableId");
    toggleTableStatus(id, "free");
    // Si el usuario confirma, eliminamos los datos del carrito
    localStorage.removeItem("cart");
    localStorage.removeItem("orderId");
    localStorage.removeItem("selectedTableId");
    localStorage.removeItem("deliveryMode");
  }
}

// Función para cambiar el estado de una mesa
async function toggleTableStatus(id, newStatus) {
  try {
    const response = await fetch("../controllers/TableController.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ action: "updateStatus", id, status: newStatus }),
    });
    const result = await response.json();
    console.log(result.message);
    window.location.href = "../index.php";
  } catch (error) {
    console.error("Error updating table status:", error);
  }
}

// Función para vaciar el carrito
function clearCart() {
  cart = {};
  updateCartUI();
}

// Guardar carrito en Local Storage
function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}

// Mostrar notificación
function showNotification(message, type) {
  const notification = document.createElement("div");
  notification.className = `notification ${type} show`;
  notification.textContent = message;
  document.querySelector(".notifications-container").appendChild(notification);

  setTimeout(() => {
    notification.classList.add("hidden");
    setTimeout(() => notification.remove(), 500);
  }, 2000);
}

document.addEventListener("DOMContentLoaded", function () {
  const checkoutButton = document.getElementById("checkout");
  const sendOrderButton = document.getElementById("send-order");
  const leaveTableButton = document.getElementById("leave-table");
  let deliveryButton, pickupButton;

  // Verificar la URL para decidir si estamos en la página del carrito
  if (window.location.pathname.includes("cart.php")) {
    deliveryButton = document.getElementById("delivery");
    pickupButton = document.getElementById("pickup");
    cartHeader = document.querySelector(".cart-header");

    if (localStorage.getItem("deliveryMode") == "local") {
      leaveTableButton.addEventListener("click", async () => {
        let orderId = localStorage.getItem("orderId"); // Obtener orderId del localStorage

        if (orderId) {
          console.log(orderId);
          try {
            const response = await fetch("../controllers/OrderController.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify({ orderId: orderId }), // Enviamos el orderId en el cuerpo de la solicitud
            });

            const data = await response.json();

            // Manejar la respuesta del servidor
            if (data.success) {
              alert(data.message); // Muestra un mensaje de éxito
              localStorage.removeItem("orderId");
              // Redireccionamos si la solicitud fue exitosa
              window.location.href = "../index.php";
            } else {
              alert(data.message); // Muestra un mensaje de error
            }
          } catch (error) {
            console.error("Error:", error);
            alert(error);
          }
        } else {
          alert("No se encontró el orderId ");
        }
      });
    } else {
      // Solo se definen los eventos si los botones están presentes
      localStorage.removeItem("selectedTableId");
      localStorage.setItem("deliveryMode", "pickup");
      deliveryButton.addEventListener("click", () => {
        deliveryButton.classList.add("active");
        pickupButton.classList.remove("active");
        deliveryCost = 2; // Costo de entrega
        localStorage.setItem("deliveryMode", "delivery"); // Guarda el modo en localStorage
        updateCartUI(); // Actualiza la interfaz del carrito
      });

      pickupButton.addEventListener("click", () => {
        pickupButton.classList.add("active");
        deliveryButton.classList.remove("active");
        deliveryCost = 0; // Sin costo de entrega
        localStorage.setItem("deliveryMode", "pickup"); // Guarda el modo en localStorage
        updateCartUI(); // Actualiza la interfaz del carrito
      });
    }

    // Función para manejar el modo según la URL
    function handleMode() {
      const urlParams = new URLSearchParams(window.location.search);
      const mode = urlParams.get("mode");

      if (mode === "local") {
        console.log("Modo Local Activado");
        cartHeader.classList.add("hidden");
        checkoutButton.classList.add("hidden");

        sendOrderButton.classList.remove("hidden");
        sendOrderButton.style.display = "inline-flex";
        leaveTableButton.style.display = "inline-flex";
      } else {
        cartHeader.classList.remove("hidden");
        checkoutButton.classList.remove("hidden");
        checkoutButton.style.display = "inline-flex";
        sendOrderButton.classList.add("hidden");
      }

      // Cargar el modo de entrega desde localStorage
      const storedDeliveryMode = localStorage.getItem("deliveryMode");
      if (storedDeliveryMode === "delivery") {
        deliveryCost = 2; // Costo de entrega
        deliveryButton.classList.add("active");
        pickupButton.classList.remove("active");
      } else {
        deliveryCost = 0; // Sin costo de entrega
        pickupButton.classList.add("active");
        deliveryButton.classList.remove("active");
      }
      updateCartUI(); // Actualiza la interfaz del carrito al cargar
    }

    // Llama a la función para manejar el modo
    handleMode();
  }
});

// Función para cargar el carrito desde Local Storage
function loadCart() {
  const storedCart = localStorage.getItem("cart");
  if (storedCart) {
    cart = JSON.parse(storedCart); // Usamos la variable global 'cart'
    updateCartUI();
  }
}

// Actualizar la interfaz del carrito
function updateCartUI() {
  const cartItemsContainer = document.getElementById("cart-items");
  const cartTotalAmount = document.getElementById("cart-total-amount");
  const subtotalElements = document.querySelectorAll(".total-amount");
  const shippingCostDisplay = document.getElementById("shipping-cost");
  const serviceFeeDisplay = document.getElementById("service-fee");

  cartItemsContainer.innerHTML = "";

  let total = 0;
  for (const [id, item] of Object.entries(cart)) {
    const cartItem = document.createElement("div");
    cartItem.className = "cart-item";
    cartItem.innerHTML = `
        <p>${item.name}  - $${item.price.toFixed(2)}</p>
        <div class="item-controls">
          <button class="btn-minus">-</button>
          <span class="item-quantity">${item.quantity}</span>
          <button class="btn-plus">+</button>
        </div>
      `;

    cartItemsContainer.appendChild(cartItem);
    total += item.price * item.quantity;

    // Añadir eventos a los botones
    const plusButton = cartItem.querySelector(".btn-plus");
    const minusButton = cartItem.querySelector(".btn-minus");

    plusButton.addEventListener("click", () => addToCart(item));
    minusButton.addEventListener("click", () => removeFromCart(item));
  }

  // Validar antes de actualizar para evitar errores si no existen esos elementos
  if (shippingCostDisplay) {
    shippingCostDisplay.textContent = `$${deliveryCost.toFixed(2)}`; // Actualiza el costo de envío
  }

  if (serviceFeeDisplay) {
    serviceFeeDisplay.textContent = `$${serviceFee.toFixed(2)}`; // Actualiza la tarifa de servicio
  }

  // Calcular el total incluyendo el costo de envío y la tarifa de servicio
  const totalWithShippingAndService = total + deliveryCost + serviceFee;

  // Validar si el elemento de total existe antes de actualizar
  if (cartTotalAmount) {
    cartTotalAmount.textContent = `$${totalWithShippingAndService.toFixed(2)}`; // Muestra el total
  }

  // Actualizar el subtotal en todas las instancias donde se use la clase "total-amount"
  subtotalElements.forEach((subtotalElement) => {
    subtotalElement.textContent = `$${total.toFixed(2)}`;
  });
}

// Cargar el carrito cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", loadCart);
