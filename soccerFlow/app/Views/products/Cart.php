<!-- Contenedor principal de la ventana del carrito -->
<div class="cart__body-window">

    <!-- SECCIÓN IZQUIERDA: Lista de productos en el carrito -->
    <div class="cart__products">
        <!-- Título de la sección -->
        <h1>Mi Carrito</h1>

        <!-- Mensaje informativo sobre fecha de envío (destacado en verde) -->
        <p>Fecha de salida: <span style="color: #079C40;">Mañana!</span></p>

        <!-- Bloque PHP: Verifica si hay productos en el carrito -->
        <?php if (!empty($items)): ?>
            <!-- Itera sobre cada producto en el carrito -->
            <?php foreach ($items as $item): ?>
                <?php
                // Procesamiento de la imagen del producto
                $img = $item['image_url'] ?? '/assets/img/products/placeholder.png';
                // Limpia la ruta eliminando prefijos específicos del proyecto
                $img = str_replace('soccerFlow/public', '', $img);
                // Asegura que la ruta comience con /
                if ($img && $img[0] !== '/') $img = '/' . $img;

                // Formatea el precio para mostrarlo con 2 decimales
                $rawPrice = (float)$item['unit_price'];
                $price = number_format($rawPrice, 2);
                ?>

                <!-- Bloque de producto individual con atributos de datos para JavaScript -->
                <div class="cart__product-block"
                    data-cart-item-id="<?= (int)$item['cart_item_id'] ?>"
                    data-qty="<?= (int)$item['quantity'] ?>"
                    data-price="<?= $rawPrice ?>">

                    <!-- Imagen del producto -->
                    <img src="<?= htmlspecialchars($img) ?>"
                        alt="<?= htmlspecialchars($item['name']) ?>"
                        class="cart__product-image-window">

                    <!-- Detalles del producto -->
                    <div class="cart__product-details">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p>Cantidad: <?= (int)$item['quantity'] ?></p>
                        <p>Talla: <?= htmlspecialchars($item['size'] ?? '') ?></p>
                        <?php if (!empty($item['color'])): ?>
                            <p>Color: <?= htmlspecialchars($item['color']) ?></p>
                        <?php endif; ?>
                        <p class="cart__price" data-price="<?= htmlspecialchars($rawPrice) ?>">
                            Precio: $<?= $price ?>
                        </p>
                    </div>

                    <!-- Botón para eliminar producto (la X) -->
                    <p class="product__block-quit" aria-label="Eliminar producto" title="Eliminar">X</p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- MENSAJE DE CARRITO VACÍO (corregido e integrado) -->
            <div class="cart__empty">
                <p>Tu carrito está vacío</p>
                <a href="/productos" class="cart__continue-shopping">Seguir comprando</a>S
            </div>
        <?php endif; ?>
    </div>

    <!-- SECCIÓN DERECHA: Resumen de pago y checkout -->
    <!-- Solo se muestra si hay productos en el carrito -->
    <?php if (!empty($items)): ?>
        <div class="cart__payment">
            <h2>Resumen</h2>

            <!-- Subtotales -->
            <p>Precio Total de productos</p>
            <p id="total-products">0.00$</p> <!-- Se actualizará con JavaScript -->

            <p>Gastos de envío</p>
            <p>0$</p> <!-- Envío gratuito -->

            <p>Total a pagar</p>
            <p id="total-pay">0.00$</p> <!-- Se actualizará con JavaScript (productos + envío) -->

            <!-- Formulario para proceder al checkout -->
            <form method="POST" action="index.php?ctl=cart-checkout">
                <button class="cart__checkout-button" type="submit">
                    Finalizar Compra 🛒
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>