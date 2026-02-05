   // JavaScript para el control de cantidad
        document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.quantity-btn.plus').addEventListener('click', function() {
            const input = document.querySelector('.quantity-input');
            let value = parseInt(input.value);
            if (value < parseInt(input.max)) {
                input.value = value + 1;
            }
        });

        document.querySelector('.quantity-btn.minus').addEventListener('click', function() {
            const input = document.querySelector('.quantity-input');
            let value = parseInt(input.value);
            if (value > parseInt(input.min)) {
                input.value = value - 1;
            }
        });
        });
