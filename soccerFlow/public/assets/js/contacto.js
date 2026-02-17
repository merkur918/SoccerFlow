// Esperamos a que el DOM esté completamente cargado para asegurarnos de que los elementos existen
document.addEventListener('DOMContentLoaded', () => {
    // Obtenemos las referencias al formulario y al mensaje de éxito por sus IDs
    const form = document.getElementById('formContacto');
    const mensaje = document.getElementById('mensajeExito');

    // Si no existe el formulario, detenemos la ejecución para evitar errores
    if (!form) return;

    // Agregamos un event listener para cuando se envíe el formulario
    form.addEventListener('submit', e => {
        // Prevenimos el comportamiento por defecto (recargar la página)
        e.preventDefault();

        // Mostramos el mensaje de éxito añadiendo la clase 'mostrar'
        mensaje.classList.add('mostrar');

        // Configuramos un temporizador para ocultar el mensaje después de 3 segundos
        setTimeout(() => {
            mensaje.classList.remove('mostrar');
        }, 3000);

        // Limpiamos todos los campos del formulario
        form.reset();
    });
});