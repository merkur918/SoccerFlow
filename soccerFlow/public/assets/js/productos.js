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

    function filtrarProductos() {
        const searchTerm = searchInput.value.trim().toLowerCase();

        const category = document.querySelector('.product__filter-category').value;
        const size = document.querySelector('.product__filter-size').value;
        const team = document.querySelector('.product__filter-teams').value;
        const brand = document.querySelector('.product__filter-brand').value;
        const gender = document.querySelector('.product__filter-gender').value;

        const products = document.querySelectorAll('.product__block');

        products.forEach(product => {
            const name = product.querySelector('.product__name').textContent.toLowerCase();
            const pCategory = product.getAttribute('data-category');
            const pSize = product.getAttribute('data-size');
            const pTeam = product.getAttribute('data-team');
            const pBrand = product.getAttribute('data-brand');
            const pGender = product.getAttribute('data-gender');

            let visible = true;

            if (!name.includes(searchTerm)) visible = false;
            if (category !== 'all' && pCategory !== category) visible = false;
            if (size !== 'all-sizes' && pSize !== size.replace('size-', '')) visible = false;
            if (team !== 'all-teams' && pTeam !== team) visible = false;
            if (brand !== 'all-brands' && pBrand !== brand) visible = false;
            if (gender !== 'all-genders' && pGender !== gender) visible = false;

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

});
