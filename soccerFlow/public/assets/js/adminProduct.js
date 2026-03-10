    window.onload = function(){
    const inputImages = document.getElementById('images');
    const preview = document.getElementById('preview');

    inputImages.addEventListener('change', function() {
        preview.innerHTML = ''; // Limpiar previas
        const files = inputImages.files;

        if (files) {
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }
    });
    }