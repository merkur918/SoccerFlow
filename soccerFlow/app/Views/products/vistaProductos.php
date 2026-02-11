<div class="product__body-window">
        <div class="product__search">
            <div ></div>
             <input type="text" placeholder="Buscar productos..." class="product__search-input">
            <div class="product__order-filter">

               <select class="product__order-price">
                   <option value="default">Ordenar por</option>
                   <option value="price-asc">Precio: Bajo a Alto</option>
                   <option value="price-desc">Precio: Alto a Bajo</option>
                </select>

                 <select class="product__filter-category">
                    <option value="all">Filtrar por categoría</option>
                    <option value="botas">Botas</option>
                    <option value="camisetas">Camisetas</option>
                    <option value="guantes">Guantes</option>
                    <option value="chandals">Chandals</option>
                </select>

                <select class="product__filter-size">
                    <option value="all-sizes">Filtrar por talla</option>
                    <option value="xs">XS</option>
                    <option value="size-s">S</option>
                    <option value="size-m">M</option>
                    <option value="size-l">L</option>
                    <option value="size-xl">XL</option>
                    <option value="size-xxl">XXL</option>
                </select>

                <select class="product__filter-teams">
                    <option value="all-teams">Filtrar por equipo</option>
                    <option value="real madrid">Real Madrid </option>
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

                <select class="product__filter-brand">
                    <option value="all-brands">Filtrar por marca</option>
                    <option value="nike">Nike</option>
                    <option value="adidas">Adidas</option>
                    <option value="puma">Puma</option>
                    <option value="new balance">New Balance</option>
                    <option value="under armour">Under Armour</option>
                    <option value="joma">Joma</option>
                    
                </select>

                <select class="product__filter-gender">
                    <option value="all-genders">Filtrar por género</option>
                    <option value="Masculino">Hombre</option>
                    <option value="Femenino">Mujer</option>
                    <option value="Unisex">Unisex</option>
                </select>
                    

            </div>
           
        </div>
        
       
      <div class="product__container"> <!-- Grid principal de tarjetas -->
    <?php if (!empty($productos)): ?> <!-- Si hay productos -->
        <?php foreach ($productos as $p): ?> <!-- Recorremos cada producto -->
            <?php
                $id = $p['id'] ?? $p['ID'] ?? null; // ID del producto (soporta id/ID)
                $name = htmlspecialchars($p['name'] ?? 'Producto'); // Nombre seguro
                $price = number_format((float)($p['price'] ?? 0), 2); // Precio con 2 decimales
                $img = htmlspecialchars($p['image'] ?? '/assets/img/products/placeholder.png'); // Imagen o placeholder
                $category = htmlspecialchars($p['category'] ?? ''); // Categoria
                $team = htmlspecialchars($p['team'] ?? ''); // Equipo
                $brand = strtolower($p['brand'] ?? '');//Marca
                $gender = htmlspecialchars($p['gender'] ?? ''); // Genero
                $meta = trim($brand . ' - ' . $category); // Linea corta con marca y categoria
                $sizes = htmlspecialchars($p['sizes']??'');
                $sizes = htmlspecialchars(strtolower($sizes));
            ?>
            <div class="product__block"
                data-category="<?= $category ?>"
                data-size="<?= $sizes ?>" 
                data-team="<?= $team ?>" 
                data-brand="<?= $brand ?>" 
                data-gender="<?= $gender ?>"> 
                
                <div class="product__media"> <!-- Contenedor fijo de imagen -->
                    <img src="<?= $img ?>" alt="<?= $name ?>" class="product__image-window"> <!-- Imagen -->
                </div>

                <div class="product__info"> <!-- Contenedor de texto -->
                    <h3 class="product__name"><?= $name ?></h3> <!-- Nombre -->
                    <p class="precio">Precio: $<?= $price ?></p> <!-- Precio -->
                    <?php if ($meta !== ''): ?> <!-- Solo si hay meta -->
                        <p class="product__meta"><?= htmlspecialchars($meta) ?></p> <!-- Marca y categoria -->
                    <?php endif; ?>
                    <p><span class="product__size-hidden"><?= htmlspecialchars($sizes) ?></span></p> <!-- Placeholder tallas -->
                </div>
            </div>
        <?php endforeach; ?> <!-- Fin del foreach -->
    <?php else: ?> <!-- Si no hay productos -->
        <p>No hay productos disponibles.</p> <!-- Mensaje -->
    <?php endif; ?> <!-- Fin del if -->
</div>


    </div>