<div class="product__body">
        <div class="product__container"> 
            <div class="product__images-preview-column">
                <img class="product__images-preview-img" src="preview1.jpg" alt="Imagen previa 1">
                <img class="product__images-preview-img" src="preview2.jpg" alt="Imagen previa 2">
                <img class="product__images-preview-img" src="preview3.jpg" alt="Imagen previa 3">
                <img class="product__images-preview-img" src="preview4.jpg" alt="Imagen previa 4">
            </div>
            <div class="product__image">
                <img src="zapatillas.jpg" class="product__img" alt="Imagen del producto">
            </div>
            <div class="product__form-column">
                <form class="product__form">
                    <h1 class="product__title">GUANTES SP FÚTBOL ZERO ELITE</h1>
                    <p class="product__price">59,99 €</p>
                    <span style="color: #079C40;">¡Envío Gratis!</span>

                    <!-- NUEVO BOTÓN DE CANTIDAD MEJORADO -->
                    <div class="quantity-container">
                        <div class="quantity-label">Cantidad</div>
                        <div class="quantity-control">
                            <button type="button" class="quantity-btn minus">-</button>
                            <input type="number" class="quantity-input" value="1" min="1" max="99">
                            <button type="button" class="quantity-btn plus">+</button>
                        </div>
                    </div>

                    <!-- Select de talla -->
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
                    <h2 class="product__description-title">Descripción del Producto</h2>
                    <p class="product__description-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>
        </div>
    </div>