<div class="add-product">
    <div class="add-product__body">
        <h2 class="section-title">Añadir Producto</h2>
        <form action="/admin/createProduct" method="POST" enctype="multipart/form-data" class="add-product__form">

            <!-- Nombre -->
            <div class="add-product__form-group">
                <label for="name" class="add-product__form-label">Nombre del producto</label>
                <input type="text" id="name" name="name" required placeholder="Ej: Camiseta FC Barcelona" class="add-product__form-input">
            </div>

            <!-- Precio -->
            <div class="add-product__form-group">
                <label for="price" class="add-product__form-label">Precio (€)</label>
                <input type="number" step="0.01" id="price" name="price" required placeholder="Ej: 49.99" class="add-product__form-input">
            </div>

            <!-- Descripción -->
            <div class="add-product__form-group">
                <label for="description" class="add-product__form-label">Descripción</label>
                <textarea id="description" name="description" rows="4" placeholder="Descripción del producto" class="add-product__form-textarea"></textarea>
            </div>

            <!-- Marca -->
            <div class="add-product__form-group">
                <label for="brand" class="add-product__form-label">Marca</label>
                <input type="text" id="brand" name="brand" placeholder="Ej: Nike" class="add-product__form-input">
            </div>

            <!-- Color -->
            <div class="add-product__form-group">
                <label for="color" class="add-product__form-label">Color</label>
                <input type="text" id="color" name="color" placeholder="Ej: Rojo" class="add-product__form-input">
            </div>

            <!-- Equipo -->
            <div class="add-product__form-group">
                <label for="team" class="add-product__form-label">Equipo</label>
                <input type="text" id="team" name="team" placeholder="Ej: FC Barcelona" class="add-product__form-input">
            </div>

            <!-- Categoría -->
            <div class="add-product__form-group">
                <label for="category" class="add-product__form-label">Categoría</label>
                <select id="category" name="category" required class="add-product__form-select">
                    <option value="">Selecciona categoría</option>
                    <option value="camiseta" data-category="camiseta">Camiseta</option>
                    <option value="chandal" data-category="chandal">Chandal</option>
                    <option value="botas" data-category="botas">Botas</option>
                    <option value="guantes" data-category="guantes">Guantes</option>
                </select>
            </div>

            <!-- Género -->
            <div class="add-product__form-group">
                <label for="gender" class="add-product__form-label">Género</label>
                <select id="gender" name="gender" class="add-product__form-select">
                    <option value="Unisex">Unisex</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>

            <!-- Imágenes -->
            <div class="add-product__form-group">
                <label for="images" class="add-product__form-label">Imágenes del producto</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple required>
                <small>Puedes seleccionar varias imágenes a la vez.</small>
            </div>

            <!-- Previsualización -->
            <div id="preview" class="add-product__preview"></div>

            <!-- Tallas / Stock -->
            <div class="add-product__form-group">
                <label class="add-product__form-label">Tallas disponibles</label>
                <table class="product-sizes-table">
                    <thead>
                        <tr>
                            <th>Talla</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tallas = ['XS', 'S', 'M', 'L', 'XL', 'XXL']; // para ropa
                        foreach ($tallas as $talla): ?>
                            <tr>
                                <td><?= $talla ?></td>
                                <td>
                                    <input type="number" name="sizes[<?= $talla ?>]" min="0" value="0" class="add-product__form-input">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Botón -->
            <button type="submit" class="add-product__form-submit">Añadir Producto</button>
        </form>
    </div>
</div>

<!-- Script para previsualizar imágenes -->
<script src="/assets/js/adminProduct.js"></script>