// Función para formatear números como moneda
    function formatCurrency(amount) {
        const value = Number.isFinite(amount) ? amount : 0;
        return value.toFixed(2) + '$';
    }

    // Función para calcular y actualizar el resumen del pago
    function updatePaymentSummary() {
        let totalProducts = 0;
        
        // Seleccionar todos los productos en el carrito
        const productBlocks = document.querySelectorAll('.cart__product-block');
        
        // Calcular el total sumando el precio de cada producto
        productBlocks.forEach(product => {
            // Asegurarnos de seleccionar el elemento correcto del precio
            const priceFromData = product.dataset.price
                || product.querySelector('.cart__price')?.dataset?.price
                || product.querySelector('.cart__price')?.textContent
                || '0';

            const qtyFromData = product.dataset.qty
                || product.querySelector('.cart__product-details p')?.textContent
                || '0';

            const price = parseFloat(String(priceFromData).replace(/[^0-9.]/g, '')) || 0;
            const quantity = parseInt(String(qtyFromData).replace(/[^0-9]/g, ''), 10) || 0;
            totalProducts += price * quantity;
        });
        
        // Gastos de envío
        const shipping = 0;
        
        // Total a pagar
        const totalToPay = totalProducts + shipping;
        
        // Usar los IDs que ya tienes en el HTML
        const totalProductsElement = document.getElementById('total-products');
        const totalPayElement = document.getElementById('total-pay');
        
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
                const cartItemId = productBlock?.dataset?.cartItemId;

                if (!cartItemId) {
                    productBlock.remove();
                    updatePaymentSummary();
                    return;
                }

                fetch('index.php?ctl=cart-remove', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `cart_item_id=${encodeURIComponent(cartItemId)}`
                }).then(resp => {
                    if (!resp.ok) throw new Error('Error al eliminar');
                    return resp.json();
                }).then(data => {
                    if (!data || !data.ok) throw new Error('No se pudo eliminar');
                    // Agregar animación de eliminación
                    productBlock.style.opacity = '0';
                    productBlock.style.transform = 'translateX(100px)';
                    setTimeout(() => {
                        productBlock.remove();
                        updatePaymentSummary();
                        if (document.querySelectorAll('.cart__product-block').length === 0) {
                            showEmptyCartMessage();
                        }
                    }, 300);
                }).catch(() => {
                    // Si falla, no eliminamos del DOM
                    alert('No se pudo eliminar el producto del carrito.');
                });
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
