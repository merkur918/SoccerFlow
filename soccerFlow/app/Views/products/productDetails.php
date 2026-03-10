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
    <div class="product__container">

        <!-- COLUMNA IZQUIERDA: Miniaturas de imágenes -->
        <?php if (!empty($imagenes)): ?>
            <div class="product__images-preview-column">
                <!-- Iteramos sobre cada imagen para crear una miniatura -->
                <?php foreach ($imagenes as $img): ?>
                    <?php
                    // Construimos la ruta correcta de la miniatura
                    $imgSrc = !empty($img) 
                        ? '/assets/img/productAdmin/' . htmlspecialchars($img) 
                        : '/assets/img/products/placeholder.png';
                    ?>
                    <img class="product__images-preview-img" src="<?= $imgSrc ?>" alt="Imagen previa">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- COLUMNA CENTRAL: Imagen principal del producto -->
        <div class="product__image">
            <?php
            // Mostramos la primera imagen del array o una por defecto
            $mainImg = !empty($imagenes[0]) 
                ? '/assets/img/productAdmin/' . htmlspecialchars($imagenes[0]) 
                : '/assets/img/products/placeholder.png';
            ?>
            <img src="<?= $mainImg ?>" class="product__img" alt="Imagen del producto">
        </div>

        <!-- COLUMNA DERECHA: Formulario de compra y descripción -->
        <div class="product__form-column">
            <form class="product__form" method="POST" action="index.php?ctl=cart-add">
                <input type="hidden" name="product_id" value="<?= (int)$producto['ID']; ?>">

                <h1 class="product__title"><?= htmlspecialchars($nombre) ?></h1>
                <p class="product__price"><?= $precio ?></p>
                <span style="color: #079C40;">¡Envío Gratis!</span>

                <!-- SELECTOR DE CANTIDAD -->
                <div class="quantity-container">
                    <div class="quantity-label">Cantidad</div>
                    <div class="quantity-control">
                        <button type="button" class="quantity-btn minus">-</button>
                        <input name="quantity" type="number" class="quantity-input" value="0" min="1" max="10">
                        <button type="button" class="quantity-btn plus">+</button>
                    </div>

                    <div class="size-error-message">
                        Por favor, selecciona una talla
                    </div>

                    <!-- SELECTOR DE TALLA -->
                    <label class="product__size-label" for="size">Talla:</label>
                    <select class="product__size-select" id="size" name="size">
                        <option value="" disabled selected>Escoge tu talla</option>
                        <?php if (!empty($sizes)): ?>
                            <?php foreach ($sizes as $size): ?>
                                <option value="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        <?php endif; ?>
                    </select>

                    <input class="product__cart-button" type="submit" value="🛒 Agregar al Carrito">
                </div>
            </form>

            <!-- DESCRIPCIÓN DETALLADA DEL PRODUCTO -->
            <div class="product__description">
                <ul>
                    <li><p class="product__description-text"><?= htmlspecialchars($descripcion) ?></p></li>
                    <li><p class="product__description-text">Marca: <?= htmlspecialchars($marca) ?></p></li>
                    <li><p class="product__description-text">Color: <?= htmlspecialchars($color) ?></p></li>
                    <li><p class="product__description-text">Equipo: <?= htmlspecialchars($equipo) ?></p></li>
                    <li><p class="product__description-text">Genero: <?= htmlspecialchars($genero) ?></p></li>
                </ul>
            </div>

        </div>
    </div>
</div>