<!-- Contenedor principal de la ventana de productos (tienda) -->
<div class="product__body-window">

    <!-- SECCIÓN DE BÚSQUEDA Y FILTROS -->
    <div class="product__search">
        <!-- Espacio vacío (posiblemente para futuros elementos) -->
        <div></div>

        <!-- Campo de búsqueda por texto -->
        <input type="text" placeholder="Buscar productos..." class="product__search-input">

        <!-- Contenedor de filtros desplegables -->
        <div class="product__order-filter">

            <!-- FILTRO 1: Ordenar por precio -->
            <select class="product__order-price">
                <option value="default">Ordenar por</option>
                <option value="price-asc">Precio: Bajo a Alto</option>
                <option value="price-desc">Precio: Alto a Bajo</option>
            </select>

            <!-- FILTRO 2: Por categoría -->
            <select class="product__filter-category">
                <option value="all">Filtrar por categoría</option>
                <option value="botas">Botas</option>
                <option value="camisetas">Camisetas</option>
                <option value="guantes">Guantes</option>
                <option value="chandals">Chandals</option>
            </select>

            <!-- FILTRO 3: Por talla -->
            <select class="product__filter-size">
                <option value="all-sizes">Filtrar por talla</option>
                <option value="xs">XS</option>
                <option value="size-s">S</option>
                <option value="size-m">M</option>
                <option value="size-l">L</option>
                <option value="size-xl">XL</option>
                <option value="size-xxl">XXL</option>
            </select>

            <!-- FILTRO 4: Por equipo -->
            <select class="product__filter-teams">
                <option value="all-teams">Filtrar por equipo</option>
                <option value="real madrid">Real Madrid</option>
                <option value="fc barcelona">FC Barcelona</option>
                <option value="manchester city">Manchester City</option>
                <option value="real betis balon pie">Betis</option>
                <option value="atletico de madrid">Atletico de Madrid</option>
                <option value="paris saint-germain">PSG</option>
                <option value="liverpool fc">Liverpool</option>
                <option value="chelsea">Chelsea</option>
                <option value="inter de milan">Inter de Milan</option>
                <option value="argentina">Argentina</option>
                <option value="españa">España</option>
                <option value="francia">Francia</option>
                <option value="brasil">Brasil</option>
            </select>

            <!-- FILTRO 5: Por marca -->
            <select class="product__filter-brand">
                <option value="all-brands">Filtrar por marca</option>
                <option value="nike">Nike</option>
                <option value="adidas">Adidas</option>
                <option value="puma">Puma</option>
                <option value="new balance">New Balance</option>
                <option value="under armour">Under Armour</option>
                <option value="joma">Joma</option>
            </select>

            <!-- FILTRO 6: Por género -->
            <select class="product__filter-gender">
                <option value="all-genders">Filtrar por género</option>
                <option value="Masculino">Hombre</option>
                <option value="Femenino">Mujer</option>
                <option value="Unisex">Unisex</option>
            </select>
        </div>
    </div>

    <!-- GRID DE PRODUCTOS (listado principal) -->
    <div class="product__container"> <!-- Contenedor grid de tarjetas -->

        <?php if (!empty($productos)): ?> <!-- Verifica si hay productos -->

            <!-- Itera sobre cada producto en el array -->
            <?php foreach ($productos as $p): ?>
                <?php
                // Procesamiento y sanitización de datos del producto
                $id = $p['id'] ?? $p['ID'] ?? null; // ID del producto (acepta id o ID)
                $name = htmlspecialchars($p['name'] ?? 'Producto'); // Nombre seguro
                $price = number_format((float)($p['price'] ?? 0), 2); // Precio con 2 decimales
                $img = htmlspecialchars($p['image'] ?? '/assets/img/products/placeholder.png'); // Imagen o placeholder
                $category = htmlspecialchars($p['category'] ?? ''); // Categoría
                $team = htmlspecialchars($p['team'] ?? ''); // Equipo
                $brand = strtolower($p['brand'] ?? ''); // Marca (minúsculas)
                $gender = htmlspecialchars($p['gender'] ?? ''); // Género
                $meta = trim($brand . ' - ' . $category); // Línea corta (marca + categoría)
                $sizes = htmlspecialchars($p['sizes'] ?? ''); // Tallas
                $sizes = strtolower($sizes); // Convertir a minúsculas
                ?>

                <!-- Enlace que envuelve toda la tarjeta del producto -->
                <a href="/product-details?id=<?= $id ?>" class="product__block"
                    data-category="<?= $category ?>"
                    data-size="<?= $sizes ?>"
                    data-team="<?= $team ?>"
                    data-brand="<?= $brand ?>"
                    data-gender="<?= $gender ?>"> <!-- Atributos data para filtros JS -->

                    <!-- Contenedor de imagen con relación de aspecto fija -->
                    <div class="product__media">
                        <img src="<?= $img ?>" alt="<?= $name ?>" class="product__image-window">
                    </div>

                    <!-- Contenedor de información textual -->
                    <div class="product__info">
                        <h3 class="product__name"><?= $name ?></h3> <!-- Nombre del producto -->
                        <p class="precio">Precio: $<?= $price ?></p> <!-- Precio formateado -->

                        <!-- Muestra marca y categoría si existen -->
                        <?php if ($meta !== '' && $meta !== ' - '): ?>
                            <p class="product__meta"><?= htmlspecialchars($meta) ?></p>
                        <?php endif; ?>

                        <!-- Tallas disponibles (ocultas hasta hover) -->
                        <p><span class="product__size-hidden"><?= $sizes ?></span></p>
                    </div>
                </a>
            <?php endforeach; ?>

        <?php else: ?> <!-- Si no hay productos -->
            <p>No hay productos disponibles.</p> <!-- Mensaje de vacío -->
        <?php endif; ?>
    </div>
</div>