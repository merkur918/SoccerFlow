// Función para formatear números como moneda
    function formatCurrency(amount) {
        return amount.toFixed(2) + '$';
    }

    // Función para calcular y actualizar el resumen del pago
    function updatePaymentSummary() {
        let totalProducts = 0;
        
        // Seleccionar todos los productos en el carrito
        const productBlocks = document.querySelectorAll('.cart__product-block');
        
        // Calcular el total sumando el precio de cada producto
        productBlocks.forEach(product => {
            // Asegurarnos de seleccionar el elemento correcto del precio
            const priceElement = product.querySelector('.cart__product-details p:nth-child(3)');
            if (priceElement) {
                const priceText = priceElement.textContent;
                // Manejar diferentes formatos de precio
                const price = parseFloat(priceText.replace(/[^0-9.]/g, ''));
                
                const quantityElement = product.querySelector('.cart__product-details p:nth-child(2)');
                if (quantityElement) {
                    const quantityText = quantityElement.textContent;
                    const quantity = parseInt(quantityText.replace(/[^0-9]/g, '')) || 1;
                    
                    totalProducts += price * quantity;
                }
            }
        });
        
        // Gastos de envío
        const shipping = 0;
        
        // Total a pagar
        const totalToPay = totalProducts + shipping;
        
        // Usar los IDs que ya tienes en el HTML
        const totalProductsElement = document.getElementById('total-products');
        const totalPayElement = document.querySelector('.total-pay');
        
        if (totalProductsElement) {
            totalProductsElement.textContent = formatCurrency(totalProducts);
        }
        
        if (totalPayElement) {
            totalPayElement.textContent = formatCurrency(totalToPay);
        }
        
        // Si el carrito está vacío
        if (productBlocks.length === 0) {
            if (totalProductsElement) {
                totalProductsElement.textContent = '0.00$';
            }
            if (totalPayElement) {
                totalPayElement.textContent = '0.00$';
            }
        }
    }

    // Función para eliminar productos del carrito
    function setupRemoveButtons() {
        document.querySelectorAll('.product__block-quit').forEach(button => {
            button.addEventListener('click', function() {
                const productBlock = this.closest('.cart__product-block');
                // Agregar animación de eliminación
                productBlock.style.opacity = '0';
                productBlock.style.transform = 'translateX(100px)';
                
                setTimeout(() => {
                    productBlock.remove();
                    updatePaymentSummary();
                    // Mostrar mensaje si el carrito está vacío
                    if (document.querySelectorAll('.cart__product-block').length === 0) {
                        showEmptyCartMessage();
                    }
                }, 300);
            });
        });
    }

    // Función para mostrar mensaje de carrito vacío
    function showEmptyCartMessage() {
        const productsContainer = document.querySelector('.cart__products');
        const existingMessage = productsContainer.querySelector('.cart__empty-message');
        
        if (!existingMessage) {
            const message = document.createElement('div');
            message.className = 'cart__empty-message';
            message.innerHTML = `
                <div style="text-align: center; padding: 40px; color: #666;">
                    <p style="font-size: 1.2rem; margin-bottom: 10px;">Tu carrito está vacío</p>
                    <p style="color: #079C40; font-weight: bold;">¡Agrega algunos productos!</p>
                </div>
            `;
            
            // Insertar después del primer párrafo
            const firstParagraph = productsContainer.querySelector('p');
            if (firstParagraph) {
                firstParagraph.insertAdjacentElement('afterend', message);
            }
        }
    }

    // Inicializar todo cuando la página cargue
    document.addEventListener('DOMContentLoaded', function() {
        setupRemoveButtons();
        updatePaymentSummary();
    });