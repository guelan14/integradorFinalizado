document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll(".tab");
  const menuItemsContainer = document.querySelector(".menu-items");
  const callWaiterButton = document.getElementById("call-waiter");
  const callWaiterMessage = document.getElementById("call-waiter-message");

  let menuData = {}; // Variable para almacenar los datos del menú

  // Obtener los parámetros de la URL
  const urlParams = new URLSearchParams(window.location.search);
  const mode = urlParams.get("mode"); // 'local' o 'delivery'
  const tableNumber = urlParams.get("table"); // Número de mesa si está disponible

  // Obtener los elementos donde se mostrará el título, el número de mesa
  const orderTitle = document.querySelector(".order-header h1");
  const tableInfo = document.querySelector("#table-info");

  // Actualizar la interfaz según el modo seleccionado
  if (mode === "local") {
    orderTitle.textContent = "Local";
    callWaiterButton.classList.remove("none");
    callWaiterButton.addEventListener("click", () => {
      const isConfirmed = confirm(
        "¿Estás seguro de que deseas llamar al mozo?"
      );
      if (isConfirmed) {
        callWaiterMessage.classList.remove("hidden");
        setTimeout(() => {
          callWaiterMessage.classList.add("hidden");
        }, 80000);
      }
    });
    tableInfo.textContent = tableNumber ? `Mesa: ${tableNumber}` : "";
  } else if (mode === "delivery") {
    orderTitle.textContent = "Delivery";
    tableInfo.textContent = "";
  }

  // Cargar datos del menú
  async function loadMenu() {
    try {
      const response = await fetch("../controllers/MenuController.php");
      const data = await response.json();
      menuData = data;
      filterMenu("entradas");
    } catch (error) {
      console.error("Error loading menu:", error);
    }
  }

  function searchMenuItems(query) {
    const results = [];
    const maxResults = 3;

    for (const category in menuData) {
      if (menuData.hasOwnProperty(category)) {
        const items = menuData[category].filter((item) =>
          item.name.toLowerCase().includes(query.toLowerCase())
        );
        results.push(...items);
        if (results.length >= maxResults) break; // Limita a 3 resultados
      }
    }
    return results.slice(0, maxResults); // Solo devuelve los primeros 3
  }

  function showSearchResults(query) {
    const results = searchMenuItems(query); // Llama a la función de búsqueda y obtiene los resultados
    const modalContent = document.getElementById("modal-content"); // Contenedor del modal

    modalContent.innerHTML = ""; // Limpia el contenido anterior

    results.forEach((item) => {
      const itemElement = document.createElement("div");
      itemElement.innerHTML = `
      <div class="item-info">
        <h2>${item.name}</h2>
        <div class="description"><p>${item.description}<p/></div> 
        <div class="button-container">
          <p class="price">$${item.price}</p>
          <button class="btn-minus" data-id="${item.id}">-</button>
          <button class="btn-plus" data-id="${item.id}">+</button>
        </div>
      </div>
    `;

      modalContent.appendChild(itemElement);
      const plusButtona = itemElement.querySelector(".btn-plus");
      const minusButtona = itemElement.querySelector(".btn-minus");

      plusButtona.addEventListener("click", () => addToCart(item));
      minusButtona.addEventListener("click", () => removeFromCart(item));
    });

    // Muestra el modal si hay resultados, ocúltalo si no hay resultados
    const modal = document.getElementById("modal");
    modal.style.display = results.length > 0 ? "block" : "none";
  }

  document.getElementById("search-input").addEventListener("input", (e) => {
    const query = e.target.value.trim();
    if (query) {
      showSearchResults(query); // Muestra resultados si hay texto en el campo
    } else {
      document.getElementById("modal").style.display = "none"; // Oculta el modal si está vacío
    }
  });

  // Cierra el modal si se hace clic fuera de él
  document.addEventListener("click", (e) => {
    const modal = document.getElementById("modal");
    const searchInput = document.getElementById("search-input");

    // Verifica si el clic no fue dentro del modal ni del campo de búsqueda
    if (
      !modal.contains(e.target) &&
      e.target !== searchInput &&
      !e.target.closest("#modal-content")
    ) {
      modal.style.display = "none"; // Cierra el modal
    }
  });

  // Filtrar menú por categoría
  function filterMenu(category) {
    menuItemsContainer.innerHTML = "";
    if (menuData[category]) {
      menuData[category].forEach((item) => {
        const menuItem = document.createElement("div");
        menuItem.className = `menu-item ${category}`;
        menuItem.innerHTML = `
          <div class="item-image"><img src="${item.image}" alt="${item.name}" /></div>
          <div class="item-info">
            <h2>${item.name}</h2>
            <div class="description"><p>${item.description}<p/></div> 
            <div class="button-container">
              <p class="price">$${item.price}</p>
              <button class="btn-minus" data-id="${item.id}">-</button>
              <button class="btn-plus" data-id="${item.id}">+</button>
            </div>
          </div>
        `;
        menuItemsContainer.appendChild(menuItem);

        const plusButton = menuItem.querySelector(".btn-plus");
        const minusButton = menuItem.querySelector(".btn-minus");

        plusButton.addEventListener("click", () => addToCart(item));
        minusButton.addEventListener("click", () => removeFromCart(item));
      });
    }
  }

  // Añadir evento a tabs
  tabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      tabs.forEach((t) => t.classList.remove("active"));
      this.classList.add("active");
      const category = this.getAttribute("data-category");
      filterMenu(category);
    });
  });

  // Función para obtener los parámetros de la URL actual
  function getUrlParams() {
    const params = new URLSearchParams(window.location.search);
    return {
      mode: params.get("mode"),
      table: params.get("table"),
    };
  }

  // Obtener el botón de "Ir al carrito"
  const cartButton = document.querySelector(".btn-cart");
  const sendOrderButton = document.querySelector(".send-order");

  // Asignar los parámetros a la URL del carrito al hacer clic en el enlace
  function updateCartLink(button) {
    button.addEventListener("click", function (event) {
      event.preventDefault(); // Evitar la redirección automática

      const { mode, table } = getUrlParams();

      // Verificar que ambos parámetros existan
      if (mode && table) {
        // Construir la nueva URL con los parámetros
        const newUrl = `cart.php?mode=${mode}&table=${table}`;

        // Redirigir a la nueva URL
        window.location.href = newUrl;
      } else {
        // Construir la nueva URL con los parámetros
        const newUrl = `cart.php?mode=${mode}`;

        // Redirigir a la nueva URL
        window.location.href = newUrl;
      }
    });
  }

  // Llamar a la función para ambos botones
  if (cartButton) updateCartLink(cartButton);
  if (sendOrderButton) updateCartLink(sendOrderButton);

  // Cargar menú
  loadMenu();
});
