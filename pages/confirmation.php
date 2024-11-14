<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carrito de Compra</title>
    <link rel="stylesheet" href="../css/cart.css" />
    <link rel="stylesheet" href="../css/header.css" />
  </head>
  <body>
    <?php include 'cart_header.php'; ?>
    <div class="cart-page">
      <section id="cart" style="display: none">
        <div id="cart-items"></div>
        <div id="cart-details"></div>
        <!-- Elemento para mostrar detalles del carrito -->
      </section>
      <section class="buy-confirmation">
        <div class="delivery-details">
          <h2 class="selectable" id="delivery-title">Detalle de la Entrega</h2>
          <div id="delivery-method"></div>
          <!-- Muestra el método de entrega -->
        </div>
        <div class="payment-method">
          <h2 class="selectable" id="payment-title">Medios de Pago</h2>
        </div>
      </section>
      <section class="cart-summary">
        <h2>Resumen</h2>
        <div class="total">
          <ul>
            <li>SubTotal: <span class="total-amount">$0.00</span></li>
            <li class="shipping-fee">
              Envío: <span id="shipping-cost">$0.00</span>
            </li>
            <li class="service-fee">
              Tarifa de Servicio: <span id="service-fee">$1.00</span>
            </li>
            <li>Total: <span id="cart-total-amount">$0.00</span></li>
          </ul>
        </div>
        <a href="#" id="checkout" class="send checkout-btn">Pagar</a>
      </section>
    </div>
    <script src="../scripts/confirmation.js"></script>
    <script src="../scripts/sendOrder.js"></script>
  </body>
</html>
