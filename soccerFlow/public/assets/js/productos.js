// Función para buscar productos por nombre
const searchInput = document.querySelector('.product__search-input');

searchInput.addEventListener('input', function () {
    const searchTerm = this.value.trim().toLowerCase();

    const products = document.querySelectorAll('.product__block');

    products.forEach(product => {
        const productName = product.querySelector('.product__name').textContent.toLowerCase();

        if (productName.includes(searchTerm)) {
            product.style.display = '';
        } else {
            product.style.display = 'none';
        }
    });
});
// Función para ordenar productos por precio
const priceFilter = document.querySelector('.product__order-price');
priceFilter.addEventListener('change', function () {
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

    // Reorganizar los productos en el contenedor
    products.forEach(product => productsContainer.appendChild(product));
}
);





// Función para filtrar productos por categoría, talla, equipo, marca o género
const filtros = document.querySelector('.product__order-filter');
filtros.addEventListener('change', function () {
    const selectedOption = this.value;
    const products = document.querySelectorAll('.product__block');
    products.forEach(product => {
        const category = product.getAttribute('data-category');
        const size = product.getAttribute('data-size');
        const team = product.getAttribute('data-team');
        const brand = product.getAttribute('data-brand');
        const gender = product.getAttribute('data-gender');
        let showProduct = true;
        if (selectedOption.startsWith('category-') && category !== selectedOption.split('-')[1]) {
            showProduct = false;
        }
        if (selectedOption.startsWith('size-') && size !== selectedOption.split('-')[1]) {
            showProduct = false;
        }
        if (selectedOption.startsWith('team-') && team !== selectedOption.split('-')[1]) {
            showProduct = false;
        }
        if (selectedOption.startsWith('brand-') && brand !== selectedOption.split('-')[1]) {
            showProduct = false;
        }
        if (selectedOption.startsWith('gender-') && gender !== selectedOption.split('-')[1]) {
            showProduct = false;
        }

        product.style.display = showProduct ? '' : 'none';
    });
});