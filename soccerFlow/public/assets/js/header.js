/**
 * header-simple.js
 * Menú desplegable simplificado
 */

// Cuando la página cargue
document.addEventListener('DOMContentLoaded', function() {
    const userBtn = document.getElementById('userMenuButton');
    const menu = document.getElementById('userDropdown');
    
    // Si no hay elementos, salir
    if (!userBtn || !menu) return;
    
    // Abrir/cerrar menú al hacer clic
    userBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        menu.classList.toggle('show');
        userBtn.classList.toggle('active');
    });
    
    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', function() {
        menu.classList.remove('show');
        userBtn.classList.remove('active');
    });
    
    // Evitar que se cierre al hacer clic dentro del menú
    menu.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});