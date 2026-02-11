<div class="cart__body-window">
    <div class="cart__products">
      <h1>Mi Carrito</h1>
      <p>Fecha de salida: <span style="color: #079C40;">Mañana!</span></p>

      <?php if (!empty($items)): ?>
        <?php foreach ($items as $item): ?>
          <?php
            $img = $item['image_url'] ?? '/assets/img/products/placeholder.png';
            $img = str_replace('soccerFlow/public', '', $img);
            if ($img && $img[0] !== '/') $img = '/' . $img;
            $rawPrice = (float)$item['unit_price'];
            $price = number_format($rawPrice, 2);
          ?>
          <div class="cart__product-block" data-cart-item-id="<?= (int)$item['cart_item_id'] ?>" data-qty="<?= (int)$item['quantity'] ?>" data-price="<?= $rawPrice ?>">
            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="cart__product-image-window">
            <div class="cart__product-details">
              <h3><?= htmlspecialchars($item['name']) ?></h3>
              <p>Cantidad: <?= (int)$item['quantity'] ?></p>
              <p>Talla: <?= htmlspecialchars($item['size'] ?? '') ?></p>
              <?php if (!empty($item['color'])): ?>
                <p>Color: <?= htmlspecialchars($item['color']) ?></p>
              <?php endif; ?>
              <p class="cart__price" data-price="<?= htmlspecialchars($rawPrice) ?>">Precio: $<?= $price ?></p>
            </div>
            <p class="product__block-quit" aria-label="Eliminar producto" title="Eliminar">X</p>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="cart__payment">
      <h2>Resumen</h2>
      <p>Precio Total de productos</p>
      <p id="total-products">0.00$</p>
      <p>Gastos de envío</p>
      <p>0$</p>
      <p>Total a pagar</p>
      <p id="total-pay">0.00$</p>
      <form method="POST" action="index.php?ctl=cart-checkout">
        <button class="cart__checkout-button" type="submit">Finalizar Compra 🛒</button>
      </form>
    </div>
  </div>
