<!-- Sección principal que muestra la confirmación de compra exitosa -->
<!-- aria-live="polite" permite que los lectores de pantalla anuncien cambios sin interrumpir -->
<section class="checkout-success" aria-live="polite">

    <!-- Tarjeta contenedora del mensaje de éxito -->
    <!-- role="status" indica que es un mensaje de estado importante para accesibilidad -->
    <div class="checkout-success__card" role="status">

        <!-- Spinner animado que indica que el proceso está en marcha -->
        <!-- aria-label proporciona descripción para lectores de pantalla -->
        <div class="checkout-success__spinner" aria-label="Procesando compra"></div>

        <!-- Mensaje principal de agradecimiento -->
        <h2>¡Gracias por tu compra!</h2>

        <!-- Información sobre el envío de la factura -->
        <p>Hemos enviado tu factura al correo asociado a tu cuenta.</p>

        <!-- Mensaje de redirección automática -->
        <p>Te llevamos al inicio en unos segundos...</p>
    </div>
</section>S