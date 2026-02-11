<?php
if (!empty($producto)){
    // $producto YA es un array individual, NO necesitas foreach
    $nombre = $producto['name'];
    $descripcion = $producto['description'];
    $precio = number_format((float)($producto['price'] ?? 0), 2);
    $marca = $producto['brand'];
    $equipo = $producto['team'];
    $categoria = $producto['category'];
    $genero = $producto['gender'];
    $color = $color ?? ''; 
}
?>
<div class="product__body">
        <div class="product__container"> 
            <?php if (!empty($imagenes)): ?>
                <div class="product__images-preview-column">
                    <?php foreach ($imagenes as $img): ?>
                        <img class="product__images-preview-img" src="<?= htmlspecialchars($img) ?>" alt="Imagen previa">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="product__image">
                <img src="<?php echo $imagenes[0] ?? '/assets/img/products/placeholder.png'; ?>" class="product__img" alt="Imagen del producto">
            </div>
            <div class="product__form-column">
                <form class="product__form" method="POST" action="index.php?ctl=cart-add">
                    <input type="hidden" name="product_id" value="<?php echo $producto['ID']; ?>">

                    <h1 class="product__title"><?php echo $nombre ?></h1>
                    <p class="product__price"><?php echo $precio ?></p>
                    <span style="color: #079C40;">¡Envío Gratis!</span>

                  
                    <div class="quantity-container">
                        <div class="quantity-label">Cantidad</div>
                        <div class="quantity-control">
                            <button type="button" class="quantity-btn minus">-</button>
                            <input name="quantity" type="number" class="quantity-input" value="0" min="1" max="10">
                            <button type="button" class="quantity-btn plus">+</button>
                        </div>
                    </div>

                    
                    <label class="product__size-label" for="size">Talla:</label>
                    <select class="product__size-select" id="size" name="size">
                        <option value="" disabled selected>Escoge tu talla</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>

                    <input class="product__cart-button" type="submit" value="🛒 Agregar al Carrito">
                    
                </form>
                <div class="product__description">
                    <ul>
                    <li><p class="product__description-text"><?php  echo $descripcion ?></p></li>
                    <li><p class="product__description-text">Marca: <?php  echo $marca ?></li>
                    <li><p class="product__description-text">Color: <?php  echo $color ?></p></li>
                    <li><p class="product__description-text">Equipo: <?php  echo $equipo ?></p></li>
                    <li><p class="product__description-text">Genero: <?php  echo $genero ?></p></li>
                </ul>
                </div>
            </div>
        </div>
    </div>