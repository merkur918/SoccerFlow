window.onload = function(){
document.querySelectorAll('.user-delete-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const userId = btn.getAttribute('data-user-id');
        document.getElementById('deleteUserId').value = userId;
        document.getElementById('deleteModal').style.display = 'flex';
    });
});

document.getElementById('cancelBtn').addEventListener('click', () => {
    document.getElementById('deleteModal').style.display = 'none';
});

// Cerrar modal al hacer click fuera del contenido
document.getElementById('deleteModal').addEventListener('click', (e) => {
    if (e.target === document.getElementById('deleteModal')) {
        document.getElementById('deleteModal').style.display = 'none';
    }
});
}