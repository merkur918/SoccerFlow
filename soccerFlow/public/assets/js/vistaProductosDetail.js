document.addEventListener('DOMContentLoaded', () => {
    const qtyInput = document.querySelector('.quantity-input');
    const btnMinus = document.querySelector('.quantity-btn.minus');
    const btnPlus = document.querySelector('.quantity-btn.plus');
    const form = document.querySelector('.product__form');
    const sizeSelect = document.querySelector('.product__size-select');

    const mainImg = document.querySelector('.product__img');
    const thumbs = document.querySelectorAll('.product__images-preview-img');

    const toInt = (value, fallback) => {
        const n = parseInt(value, 10);
        return Number.isFinite(n) ? n : fallback;
    };

    const clamp = (value, min, max) => Math.min(Math.max(value, min), max);

    if (qtyInput) {
        const min = toInt(qtyInput.min, 1);
        const max = toInt(qtyInput.max, 10);
        qtyInput.value = clamp(toInt(qtyInput.value, min), min, max);

        const setQty = (next) => {
            qtyInput.value = clamp(next, min, max);
        };

        if (btnMinus) {
            btnMinus.addEventListener('click', () => {
                setQty(toInt(qtyInput.value, min) - 1);
            });
        }

        if (btnPlus) {
            btnPlus.addEventListener('click', () => {
                setQty(toInt(qtyInput.value, min) + 1);
            });
        }

        qtyInput.addEventListener('input', () => {
            setQty(toInt(qtyInput.value, min));
        });
    }

    if (mainImg && thumbs.length) {
        thumbs.forEach((thumb) => {
            thumb.addEventListener('click', () => {
                const src = thumb.getAttribute('src');
                if (src) {
                    mainImg.setAttribute('src', src);
                }
                thumbs.forEach(t => t.classList.remove('is-active'));
                thumb.classList.add('is-active');
            });
        });
    }

    if (form && sizeSelect) {
        form.addEventListener('submit', (e) => {
            if (!sizeSelect.value) {
                e.preventDefault();
                alert('Selecciona una talla antes de agregar al carrito.');
                sizeSelect.focus();
            }
        });
    }
});
