// Esperamos a que el DOM esté completamente cargado para asegurarnos de que los elementos existen
document.addEventListener('DOMContentLoaded', () => {
    // Obtenemos las referencias al formulario y al mensaje de éxito por sus IDs
    const form = document.getElementById('formContacto');
    const mensaje = document.getElementById('mensajeExito');

    // Si no existe el formulario, detenemos la ejecución para evitar errores
    if (!form) return;

    // Agregamos un event listener para cuando se envíe el formulario
form.addEventListener('submit', async e => { e.preventDefault(); 
    // Evita recargar la página  
const datos = new FormData(form); 
const respuesta = await fetch('/contactanos_post', { method: 'POST', body: datos }); 
const resultado = await respuesta.text(); 
if (resultado === "success") 
    { mensaje.classList.add('mostrar'); 
        setTimeout(() => { mensaje.classList.remove('mostrar'); }, 3000); 
        form.reset(); } 
        else 
            { alert("Hubo un error al enviar el mensaje"); } });
});