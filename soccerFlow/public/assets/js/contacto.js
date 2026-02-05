document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formContacto');
    const mensaje = document.getElementById('mensajeExito');

    if (!form) return;

    form.addEventListener('submit', e => {
        e.preventDefault();

        mensaje.classList.add('mostrar');

        setTimeout(() => {
            mensaje.classList.remove('mostrar');
        }, 3000);

        form.reset();
    });
});
