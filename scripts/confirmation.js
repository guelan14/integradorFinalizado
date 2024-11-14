// Mostrar detalles del carrito y método de entrega
function goBack() {
  window.history.back(); // Regresa a la página anterior
}

function loadConfirmation() {
  const storedCart = localStorage.getItem("cart");
  const storedDeliveryMode = localStorage.getItem("deliveryMode");

  let subtotal = 0; // Inicializa el subtotal
  const shippingCost = storedDeliveryMode === "delivery" ? 2 : 0; // Costo de envío
  const serviceFee = 1.0; // Tarifa de servicio

  // Cargar detalles del carrito
  if (storedCart) {
    const cart = JSON.parse(storedCart);
    const cartDetails = document.getElementById("cart-details");
    let details = "<ul>";

    for (const [name, item] of Object.entries(cart)) {
      details += `<li>${item.name} - Cantidad: ${item.quantity}</li>`;
      subtotal += item.price * item.quantity; // Calcula el subtotal
    }
    details += "</ul>";
    cartDetails.innerHTML = details;
  }

  // Mostrar método de entrega
  const deliveryMethod = document.getElementById("delivery-method");
  if (storedDeliveryMode) {
    deliveryMethod.innerHTML = `<h3>Método de entrega: ${
      storedDeliveryMode === "delivery" ? "Delivery" : "Retiro"
    }</h3>`;
  } else {
    deliveryMethod.innerHTML = "<h3>Método de entrega: No especificado</h3>";
  }

  // Mostrar los costos en el resumen
  document.querySelector(
    ".total .total-amount"
  ).innerText = `$${subtotal.toFixed(2)}`;
  document.getElementById("shipping-cost").innerText = `$${shippingCost.toFixed(
    2
  )}`;
  document.getElementById("service-fee").innerText = `$${serviceFee.toFixed(
    2
  )}`;

  // Calcular y mostrar el total
  const total = subtotal + shippingCost + serviceFee;
  document.getElementById("cart-total-amount").innerText = `$${total.toFixed(
    2
  )}`;
}

document.addEventListener("DOMContentLoaded", loadConfirmation);
