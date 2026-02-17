document.addEventListener('DOMContentLoaded', () => {
    // Seleccionar elementos del DOM
    const qtyInput = document.querySelector('.quantity-input');
    const btnMinus = document.querySelector('.quantity-btn.minus');
    const btnPlus = document.querySelector('.quantity-btn.plus');
    const form = document.querySelector('.product__form');
    const sizeSelect = document.querySelector('.product__size-select');
    const sizeErrorMsg = document.querySelector('.size-error-message');

    const mainImg = document.querySelector('.product__img');
    const thumbs = document.querySelectorAll('.product__images-preview-img');

    // Convierte un valor a entero, retorna fallback si no es válido
    const toInt = (value, fallback) => {
        const n = parseInt(value, 10);
        return Number.isFinite(n) ? n : fallback;
    };

    // Limita un valor entre un mínimo y máximo
    const clamp = (value, min, max) => Math.min(Math.max(value, min), max);

    // Controlar cantidad de productos
    if (qtyInput) {
        const min = toInt(qtyInput.min, 1);
        const max = toInt(qtyInput.max, 10);
        qtyInput.value = clamp(toInt(qtyInput.value, min), min, max);

        // Actualizar cantidad dentro del rango permitido
        const setQty = (next) => {
            qtyInput.value = clamp(next, min, max);
        };

        // Botón restar cantidad
        if (btnMinus) {
            btnMinus.addEventListener('click', () => {
                setQty(toInt(qtyInput.value, min) - 1);
            });
        }

        // Botón sumar cantidad
        if (btnPlus) {
            btnPlus.addEventListener('click', () => {
                setQty(toInt(qtyInput.value, min) + 1);
            });
        }

        // Validar entrada manual en el input
        qtyInput.addEventListener('input', () => {
            setQty(toInt(qtyInput.value, min));
        });
    }

    // Galería de imágenes - cambiar imagen principal al hacer clic en miniaturas
    if (mainImg && thumbs.length) {
        thumbs.forEach((thumb) => {
            thumb.addEventListener('click', () => {
                const src = thumb.getAttribute('src');
                if (src) {
                    mainImg.setAttribute('src', src);
                }
                // Remover clase activa de todas las miniaturas
                thumbs.forEach(t => t.classList.remove('is-active'));
                // Añadir clase activa a la miniatura seleccionada
                thumb.classList.add('is-active');
            });
        });
    }

    // Validar que se seleccione una talla antes de enviar el formulario
    if (form && sizeSelect) {
        form.addEventListener('submit', (e) => {
            if (!sizeSelect.value) {
                e.preventDefault();
                if (sizeErrorMsg) {
                    sizeErrorMsg.style.display = 'block';
                }
                sizeSelect.focus();
            }
        });
          sizeSelect.addEventListener('change', () => {
            if (sizeSelect.value && sizeErrorMsg) {
                sizeErrorMsg.style.display = 'none';
            }
        });
    }
});
