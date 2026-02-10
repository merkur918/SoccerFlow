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
                    <option value="shoes">Botas</option>
                    <option value="t-shirts">Camisetas</option>
                    <option value="gloves">Guantes</option>
                    <option value="pants">Chandals</option>
                </select>

                <select class="product__filter-size">
                    <option value="all-sizes">Filtrar por talla</option>
                    <option value="size-38">Talla 38</option>
                    <option value="size-39">Talla 39</option>
                    <option value="size-40">Talla 40</option>
                    <option value="size-41">Talla 41</option>
                    <option value="size-42">Talla 42</option>
                    <option value="size-43">Talla 43</option>
                </select>

                <select class="product__filter-teams">
                    <option value="all-teams">Filtrar por equipo</option>
                    <option value="team-a">Equipo A</option>
                    <option value="team-b">Equipo B</option>
                    <option value="team-c">Equipo C</option>
                </select>

                <select class="product__filter-brand">
                    <option value="all-brands">Filtrar por marca</option>
                    <option value="brand-a">Nike</option>
                    <option value="brand-b">Adidas</option>
                    <option value="brand-c">Puma</option>
                </select>

                <select class="product__filter-gender">
                    <option value="all-genders">Filtrar por género</option>
                    <option value="Masculino">Hombre</option>
                    <option value="Femenino">Mujer</option>
                    <option value="Unisex">Unisex</option>
                </select>
                    

            </div>
           
        </div>
        
        <!-- LOS PRODUCTOS DEBEN ESTAR DENTRO DE ESTE CONTENEDOR -->
       <div class="product__container">
    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $p): 
            $id = $p['id'] ?? $p['ID'] ?? null;
            $name = htmlspecialchars($p['name'] ?? 'Producto');
            $price = number_format((float)($p['price'] ?? 0), 2);
            $img = htmlspecialchars($p['image'] ?? '/assets/img/products/placeholder.png');
            $category = htmlspecialchars($p['category'] ?? '');
            $team = htmlspecialchars($p['team'] ?? '');
            $brand = htmlspecialchars($p['brand'] ?? '');
            $gender = htmlspecialchars($p['gender'] ?? '');
        ?>
<a href="/product-details?id=<?= $id ?>" class="product__block"
    data-category="<?= $category ?>"
    data-size=""
    data-team="<?= $team ?>"
    data-brand="<?= $brand ?>"
    data-gender="<?= $gender ?>">

    <img src="<?= $img ?>" alt="<?= $name ?>" class="product__image-window">
    <h3 class="product__name"><?= $name ?></h3>
    <p class="precio">Precio: $<?= $price ?></p>
    <p><span class="product__size-hidden">tallas:</span></p>

</a>

        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>
</div>

    </div>