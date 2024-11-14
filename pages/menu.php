<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PixFood</title>
    <link rel="stylesheet" href="../css/header.css" />
    <link rel="stylesheet" href="../css/menu.css" />
  </head>
  <?php include 'cart_header.php'; ?>
  <body class="bg-light-gray">
    <div class="super-container">
    <form class="search-container">
      <!-- Modal para mostrar los resultados -->
      <div id="modal" style="display: none;">
        <div id="modal-content"></div>
      </div>
      <input type="text" id="search-input" placeholder="Encuentra tu comida" />
      <i class="fa fa-search search-icon"></i>
    </form>

      <section class="container">
        <main class="menu-container">
          <nav class="menu-nav">
            <button class="tab color-white active" data-category="entradas">
              Entradas
            </button>
            <button
              class="tab bg-medium-gray color-dark-gray"
              data-category="principales"
            >
              Principales
            </button>
            <button
              class="tab bg-medium-gray color-dark-gray"
              data-category="bebidas"
            >
              Bebidas
            </button>
            <button
              class="tab bg-medium-gray color-dark-gray"
              data-category="postres"
            >
              Postres
            </button>
          </nav>
          <section class="menu-items"></section>
        </main>
        <aside class="order bg-white">
          <header class="order-header">
            <h1 class="color-dark-gray" id="order-title"></h1>
            <p id="table-info"></p>

            <div id="call-waiter-message" class="hidden">
              ¡Solicitud realizada!
            </div>
            <button id="call-waiter" class="call-waiter-btn none">
              Llamar al mozo
            </button>
          </header>
          <section id="cart">
            <div id="cart-items"></div>
          </section>

          <div id="cart-total">
            <ul>
              <li>SubTotal: <span class="total-amount"></span></li>
            </ul>
          </div>
          <div class="order-actions">
            <a href="cart.php" class="send-order"> Ir al Carrito </a>
          </div>
        </aside>
        <div class="notifications-container"></div>
      </section>
      <div class="subtotal-container">
        <div class="total">
          Subtotal del pedido: <span class="total-amount">$0.00</span>
        </div>
        <a href="cart.php" class="btn-cart">Ir al carrito</a>
      </div>
    </div>
    <script src="../scripts/cart.js"></script>
    <script src="../scripts/menu.js"></script>
  </body>
</html>
