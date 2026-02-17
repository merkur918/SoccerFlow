<?php
// Verificamos si existe el producto (array individual, no colección)
if (!empty($producto)) {
    // Extraemos los datos del producto en variables para facilitar su uso en HTML
    $nombre = $producto['name'];
    $descripcion = $producto['description'];
    // Formateamos el precio con 2 decimales, si no existe usamos 0
    $precio = number_format((float)($producto['price'] ?? 0), 2);
    $marca = $producto['brand'];
    $equipo = $producto['team'];
    $categoria = $producto['category'];
    $genero = $producto['gender'];
    // Si existe color, lo usamos; si no, cadena vacía
    $color = $color ?? '';
}
?>
<!-- Contenedor principal del detalle del producto -->
<div class="product__body">
    <!-- Contenedor interno que organiza las tres columnas -->
    <div class="product__container">

        <!-- COLUMNA IZQUIERDA: Miniaturas de imágenes -->
        <?php if (!empty($imagenes)): ?>
            <div class="product__images-preview-column">
                <!-- Iteramos sobre cada imagen para crear una miniatura -->
                <?php foreach ($imagenes as $img): ?>
                    <img class="product__images-preview-img" src="<?= htmlspecialchars($img) ?>" alt="Imagen previa">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- COLUMNA CENTRAL: Imagen principal del producto -->
        <div class="product__image">
            <!-- Mostramos la primera imagen del array o una por defecto -->
            <img src="<?php echo $imagenes[0] ?? '/assets/img/products/placeholder.png'; ?>"
                class="product__img"
                alt="Imagen del producto">
        </div>

        <!-- COLUMNA DERECHA: Formulario de compra y descripción -->
        <div class="product__form-column">
            <!-- Formulario para añadir al carrito -->
            <form class="product__form" method="POST" action="index.php?ctl=cart-add">
                <!-- Campo oculto con el ID del producto -->
                <input type="hidden" name="product_id" value="<?php echo $producto['ID']; ?>">

                <!-- Título del producto -->
                <h1 class="product__title"><?php echo $nombre ?></h1>

                <!-- Precio formateado -->
                <p class="product__price"><?php echo $precio ?></p>

                <!-- Mensaje promocional de envío gratis (destacado en verde) -->
                <span style="color: #079C40;">¡Envío Gratis!</span>

                <!-- SELECTOR DE CANTIDAD -->
                <div class="quantity-container">
                    <div class="quantity-label">Cantidad</div>
                    <div class="quantity-control">
                        <!-- Botón para disminuir cantidad -->
                        <button type="button" class="quantity-btn minus">-</button>
                        <!-- Input numérico para la cantidad -->
                        <input name="quantity" type="number" class="quantity-input" value="0" min="1" max="10">
                        <!-- Botón para aumentar cantidad -->
                        <button type="button" class="quantity-btn plus">+</button>
                    </div>
                </div>

                <!-- SELECTOR DE TALLA -->
                <label class="product__size-label" for="size">Talla:</label>
                <select class="product__size-select" id="size" name="size">
                    <option value="" disabled selected>Escoge tu talla</option>
                    <?php if (!empty($sizes)): ?>
                        <!-- Si hay tallas específicas del producto, las mostramos -->
                        <?php foreach ($sizes as $size): ?>
                            <option value="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Si no hay tallas específicas, mostramos opciones por defecto -->
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    <?php endif; ?>
                </select>

                <!-- Botón de envío del formulario -->
                <input class="product__cart-button" type="submit" value="🛒 Agregar al Carrito">

            </form>

            <!-- DESCRIPCIÓN DETALLADA DEL PRODUCTO -->
            <div class="product__description">
                <ul>
                    <!-- Lista con todas las características del producto -->
                    <li>
                        <p class="product__description-text"><?php echo $descripcion ?></p>
                    </li>
                    <li>
                        <p class="product__description-text">Marca: <?php echo $marca ?></p>
                    </li>
                    <li>
                        <p class="product__description-text">Color: <?php echo $color ?></p>
                    </li>
                    <li>
                        <p class="product__description-text">Equipo: <?php echo $equipo ?></p>
                    </li>
                    <li>
                        <p class="product__description-text">Género: <?php echo $genero ?></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>