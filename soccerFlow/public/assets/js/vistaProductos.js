document.addEventListener('DOMContentLoaded', function () {

  // --- BUSCADOR ---
  const searchInput = document.querySelector('.product__search-input');

  searchInput.addEventListener('input', function () {
    filtrarProductos();
  });

  // --- FILTROS ---
  const selects = document.querySelectorAll('.product__order-filter select');

  selects.forEach(select => {
    select.addEventListener('change', filtrarProductos);
  });

  // --- ORDENAR POR PRECIO ---
  const priceFilter = document.querySelector('.product__order-price');
  priceFilter.addEventListener('change', ordenarPorPrecio);

  // --- Mapeo de categorías singular → plural ---
  const categoryMap = {
    'camiseta': 'camisetas',
    'chandal': 'chandals',
    'bota': 'botas',
    'guante': 'guantes'
  };

  function filtrarProductos() {
    const searchTerm = searchInput.value.trim().toLowerCase();

    const categorySelect = document.querySelector('.product__filter-category').value.toLowerCase();
    const sizeValue = document.querySelector('.product__filter-size').value;
    const team = document.querySelector('.product__filter-teams').value.toLowerCase();
    const brand = document.querySelector('.product__filter-brand').value.toLowerCase();
    const gender = document.querySelector('.product__filter-gender').value.toLowerCase();

    const size = sizeValue.replace('size-', '').toLowerCase();

    const products = document.querySelectorAll('.product__block');

    products.forEach(product => {
      const name = product.querySelector('.product__name').textContent.toLowerCase();

      // Datos del producto normalizados
      let pCategory = (product.dataset.category || '').toLowerCase();
      let pTeam = (product.dataset.team || '').toLowerCase();
      let pBrand = (product.dataset.brand || '').toLowerCase();
      let pGender = (product.dataset.gender || '').toLowerCase();

      // Mapear categoría singular → plural si aplica
      if (categoryMap[pCategory]) pCategory = categoryMap[pCategory];

      const pSizes = (product.dataset.size || '')
        .toLowerCase()
        .split(',')
        .map(s => s.trim());

      let visible = true;

      // Filtros
      if (!name.includes(searchTerm)) visible = false;
      if (categorySelect !== 'all' && pCategory !== categorySelect) visible = false;
      if (team !== 'all-teams' && pTeam !== team) visible = false;
      if (brand !== 'all-brands' && pBrand !== brand) visible = false;
      if (gender !== 'all-genders' && pGender !== gender) visible = false;
      if (sizeValue !== 'all-sizes' && !pSizes.includes(size)) visible = false;

      product.style.display = visible ? '' : 'none';
    });

  }

  function ordenarPorPrecio() {
    const selectedOption = this.value;
    const productsContainer = document.querySelector('.product__container');
    const products = Array.from(productsContainer.querySelectorAll('.product__block'));

    if (selectedOption === 'price-asc') {
      products.sort((a, b) => {
        const priceA = parseFloat(a.querySelector('.precio').textContent.replace('Precio: $', ''));
        const priceB = parseFloat(b.querySelector('.precio').textContent.replace('Precio: $', ''));
        return priceA - priceB;
      });
    } else if (selectedOption === 'price-desc') {
      products.sort((a, b) => {
        const priceA = parseFloat(a.querySelector('.precio').textContent.replace('Precio: $', ''));
        const priceB = parseFloat(b.querySelector('.precio').textContent.replace('Precio: $', ''));
        return priceB - priceA;
      });
    }

    products.forEach(product => productsContainer.appendChild(product));
  }

  function cambiarTallas() {
    const selectSizes = document.querySelector('.product__filter-size');
    const selectCategorias = document.querySelector('.product__filter-category');

    // Cuando cambia la categoría...
    selectCategorias.addEventListener('change', () => {
      const categoria = selectCategorias.value.toLowerCase();

      // Limpiamos las opciones actuales
      selectSizes.innerHTML = '';

      // Siempre dejamos la opción "todas"
      const optionAll = document.createElement('option');
      optionAll.value = 'all-sizes';
      optionAll.textContent = 'Filtrar por talla';
      selectSizes.appendChild(optionAll);

      // Si es botas -> tallas numéricas
      if (categoria === 'botas') {
        ['38', '39', '40', '41', '42', '43'].forEach(talla => {
          const opt = document.createElement('option');
          opt.value = `size-${talla}`;
          opt.textContent = `Talla ${talla}`;
          selectSizes.appendChild(opt);
        });
      }
      // Si es camisetas o chandals -> tallas alfabeticas
      if (categoria === 'camisetas' || categoria === 'chandals') {
        ['XS', 'S', 'M', 'L', 'XL', 'XXL'].forEach(talla => {
          const opt = document.createElement('option');
          opt.value = `size-${talla}`;
          opt.textContent = `Talla ${talla}`;
          selectSizes.appendChild(opt);
        });
      }
      // Si es guantes -> tallas 7-11
      if (categoria === 'guantes') {
        ['7', '8', '10', '11'].forEach(talla => {
          const opt = document.createElement('option');
          opt.value = `size-${talla}`;
          opt.textContent = `Talla ${talla.toUpperCase()}`;
          selectSizes.appendChild(opt);
        });
      }
    });
  }

  cambiarTallas();

});