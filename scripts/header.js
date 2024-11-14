const hamburger = document.querySelector(".hamburger");
const navLinks = document.querySelector(".nav-links");
const navItems = document.querySelectorAll(".nav-links li");

// Función para cerrar el menú
function closeMenu() {
  navLinks.classList.remove("active");
  hamburger.classList.remove("active");
}

// Abrir o cerrar el menú al hacer clic en la hamburguesa
hamburger.addEventListener("click", () => {
  navLinks.classList.toggle("active");
  hamburger.classList.toggle("active");
});

// Cerrar el menú al hacer clic en un ítem del menú
navItems.forEach((item) => {
  item.addEventListener("click", () => {
    closeMenu();
  });

  // Cerrar el menú si se hace clic fuera de él
  document.addEventListener("click", (event) => {
    if (!navLinks.contains(event.target) && !hamburger.contains(event.target)) {
      closeMenu();
    }
  });
});
