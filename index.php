<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PixFood</title>
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />

    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
  </head>
  <body>
    <header>
      <nav class="navbar">
        <div class="navbar-container">
          <a href="index.php" class="logo">PixFood</a>
          <button class="hamburger" aria-label="Abrir menú">
            <i class="fas fa-bars"></i>
          </button>
          <ul class="nav-links">
            <li><a href="#about">Sobre Nosotros</a></li>
            <li><a href="#location">Ubicación</a></li>
            <li><a href="#contact">Contacto</a></li>
          </ul>
        </div>
      </nav>
    </header>

    <main>
      <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
          <h1>PixFood</h1>
          <p>Una experiencia inolvidable</p>
          <div class="cta-buttons">
            <a href="pages/menu.php?mode=delivery" class="btn"
              >Pedir Delivery</a
            >
            <a href="pages/tables.php" class="btn">Estoy en el Local</a>
          </div>
        </div>
      </section>
      <section id="about" class="about-section">
        <h2>Sobre Nosotros</h2>
        <div class="about-content">
          <img src="images/local.jpg" alt="Nuestro Restaurante" />
          <div class="about-text">
            <p>
              Nuestro restaurante nace de una pasión por la gastronomía y el
              deseo de compartir experiencias únicas con nuestros clientes.
              Fundado en el corazón de la ciudad, nos hemos comprometido a
              ofrecer platos que combinan tradición y creatividad, utilizando
              solo los ingredientes más frescos y de alta calidad.
            </p>
            <p>
              Nuestros principios se basan en la honestidad, la dedicación y el
              respeto por nuestros clientes y la comunidad. Creemos que cada
              comida debe ser una celebración, y nos esforzamos por hacer de
              cada visita una experiencia memorable.
            </p>
          </div>
        </div>
      </section>
      <section id="delivery" class="info-section">
        <h2>Servicio de Delivery</h2>
        <p>Haz tu pedido y disfrútalo en la comodidad de tu hogar.</p>
        <a href="pages/menu.php?mode=delivery" class="btn">Ir a Delivery</a>
      </section>

      <section id="location" class="info-section">
        <h2>Disfruta en Nuestro Local</h2>
        <p>Visítanos y vive una experiencia culinaria inigualable.</p>

        <div class="location">
          <iframe
            class="map-iframe"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5080.967223806056!2d-55.89195857872319!3d-27.359543994898804!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9457bff17de5f0b5%3A0x767ba0cc12cf61f1!2sHOLY%20Posadas!5e0!3m2!1sen!2sar!4v1724104326443!5m2!1sen!2sar"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      </section>

      <section id="contact" class="contact-section">
        <h2>Contacto</h2>
        <p>Si tienes alguna pregunta o comentario, no dudes en contactarnos.</p>
        <form action="#" method="post" class="contact-form">
          <input type="text" name="name" placeholder="Tu Nombre" required />
          <input
            type="email"
            name="email"
            placeholder="Tu Correo Electrónico"
            required
          />
          <textarea
            name="message"
            rows="5"
            placeholder="Tu Mensaje"
            required
          ></textarea>
          <button type="submit" class="btn">Enviar</button>
        </form>
      </section>
    </main>

    <footer class="footer">
      <div class="footer-container">
        <div class="footer-section">
          <h4>Contacto</h4>
          <p>Email: pixfood@gmail.com</p>
          <p>Teléfono: +34 123 456 789</p>
        </div>
        <div class="footer-section">
          <h4>Dirección</h4>
          <p>Costanera, 128811, Posadas</p>
          <p>Código Postal 4567</p>
        </div>
        <div class="footer-section">
          <h4>Horarios</h4>
          <p>Lunes - Viernes: 20:00 - 24:00</p>
          <p>Sábado - Domingo: 20:00 - 2:00</p>
        </div>
      </div>
      <div class="social-icons">
        <a href="https://www.facebook.com" target="_blank">
          <i class="fa-brands fa-facebook"></i>
        </a>
        <a href="https://www.instagram.com" target="_blank">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.twitter.com" target="_blank">
          <i class="fab fa-twitter"></i>
        </a>
      </div>
      <p class="copyright">
        &copy; PixFood Created By
        <span> Miguel Angel Neumann </span>
        <a
          href="https://www.linkedin.com/in/miguel-angel-neumann-a45639229/"
          target="_blank"
          title="Link to Linkedin"
        >
          <i class="fab fa-linkedin-in"></i>
        </a>
      </p>
    </footer>
    <script src="scripts/header.js"></script>
  </body>
</html>
