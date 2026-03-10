window.onload = function () {
    // Obtenemos los inputs de archivos: principal y secundarias
    const mainInput = document.getElementById('main_image'); // Imagen principal
    const secondaryInput = document.getElementById('images'); // Imágenes secundarias
    const preview = document.getElementById('preview'); // Contenedor donde mostraremos las imágenes

    // ----------------------------------------------------------
    // PREVISUALIZACIÓN DE LA IMAGEN PRINCIPAL
    // ----------------------------------------------------------
    mainInput.addEventListener('change', function () {
        preview.innerHTML = ''; // Limpiamos cualquier imagen anterior
        const file = mainInput.files[0]; // Tomamos solo el primer archivo (principal)
        if (file) { // Si hay archivo
            const reader = new FileReader(); // Creamos un lector de archivos
            reader.onload = function (e) { // Cuando la imagen se haya cargado
                const img = document.createElement('img'); // Creamos un elemento <img>
                img.src = e.target.result; // Asignamos la imagen cargada
                img.classList.add('preview-img-main'); // Clase CSS para diferenciar principal
                preview.appendChild(img); // La agregamos al contenedor de previsualización
            }
            reader.readAsDataURL(file); // Convertimos el archivo a URL de datos para mostrarlo
        }
    });

    // ----------------------------------------------------------
    // PREVISUALIZACIÓN DE IMÁGENES SECUNDARIAS
    // ----------------------------------------------------------
    secondaryInput.addEventListener('change', function () {
        const files = secondaryInput.files; // Tomamos todos los archivos seleccionados
        if (files) {
            Array.from(files).forEach(file => {
                const reader = new FileReader(); // Creamos un lector de archivos
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('preview-img-secondary'); // Clase CSS para diferenciar secundarias
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }
    });

    // ----------------------------------------------------------
    // FUNCIÓN PARA MOSTRAR TOAST (MENSAJE DE ÉXITO VISTOSO)
    // ----------------------------------------------------------
    function showToast(message, duration = 4000) {
        const toastContainer = document.getElementById('toast-container'); // Contenedor de los toast
        const toast = document.createElement('div'); // Creamos un div para el mensaje
        toast.className = 'toast-message'; // Clase CSS del toast
        toast.textContent = message; // Asignamos el texto del mensaje
        toastContainer.appendChild(toast); // Lo agregamos al contenedor

        // Animación de entrada desde la derecha
        setTimeout(() => {
            toast.style.opacity = 1;
            toast.style.transform = 'translateX(0) scale(1)'; // Aparece en su posición final
        }, 10);

        // Después de 'duration' ms, desaparece suavemente
        setTimeout(() => {
            toast.style.opacity = 0; // Se desvanece
            toast.style.transform = 'translateX(50px) scale(0.8)'; // Se mueve hacia la derecha y reduce tamaño
            setTimeout(() => toast.remove(), 500); // Se elimina del DOM
        }, duration);
    }

    // ----------------------------------------------------------
    // MOSTRAR MENSAJE DE ÉXITO SI EXISTE
    // ----------------------------------------------------------
    const successMsg = document.querySelector('.add-product__success'); // Buscamos el mensaje
    if (successMsg) {
        showToast(successMsg.textContent); // Llamamos a showToast con el contenido
        successMsg.remove(); // Eliminamos el div original para no duplicar
    }
}