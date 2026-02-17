<!-- Contenedor principal de la página de registro -->
<div class="register">

    <!-- Cuerpo principal que contiene todo el contenido del registro -->
    <div class="register__body">

        <!-- Cabecera con el logo y nombre de la aplicación (consistente con login y otras páginas) -->
        <div class="register__header">
            <!-- Título con la palabra "SOCCER FLOW" y la letra W en verde corporativo (#079C40) -->
            <h1 class="register__title">SOCCER FLO<span style="color: #079C40;">W</span></h1>
            <!-- Logo gráfico de la aplicación -->
            <img class="register__logo" src="/assets/img/logo.png" alt="Logo Soccer Flow">
        </div>

        <!-- Formulario de registro que envía los datos a /register_post mediante POST -->
        <form class="register__form" action="/register_post" method="post">

            <!-- Título de la sección -->
            <h2>REGISTRO</h2>

            <!-- Bloque PHP: Muestra un mensaje de error global si hay problemas con el formulario
                 Aparece cuando el array $errores no está vacío (ej: después de un envío fallido) -->
            <?php if (!empty($errores)): ?>
                <p class="register__global-error" role="alert">Revisa los campos del formulario.</p>
            <?php endif; ?>

            <!-- Campo de nombre de usuario -->
            <input type="text" name="nombre" placeholder="NOMBRE DE USUARIO" required>
            <!-- Contenedor para mostrar errores específicos del campo nombre
                 Muestra el error si existe en el array $errores, o vacío si no hay error -->
            <p class="register__field-error" data-error-for="nombre"><?= htmlspecialchars($errores['nombre'] ?? '') ?></p>

            <!-- Campo de email (validación HTML5 tipo email) -->
            <input type="email" name="email" placeholder="DIRECCIÓN DE CORREO ELECTRÓNICO" required>
            <!-- Error específico para el campo email -->
            <p class="register__field-error" data-error-for="email"><?= htmlspecialchars($errores['email'] ?? '') ?></p>

            <!-- Campo de contraseña -->
            <input type="password" name="password" placeholder="CONTRASEÑA" required>
            <!-- Error específico para el campo contraseña -->
            <p class="register__field-error" data-error-for="password"><?= htmlspecialchars($errores['password'] ?? '') ?></p>

            <!-- Campo de confirmación de contraseña (debe coincidir con el anterior) -->
            <input type="password" name="password_confirm" placeholder="CONFIRMAR CONTRASEÑA" required>
            <!-- Error específico para el campo confirmación -->
            <p class="register__field-error" data-error-for="password_confirm"><?= htmlspecialchars($errores['password_confirm'] ?? '') ?></p>

            <!-- Checkbox para suscripción a notificaciones/publicidad -->
            <div class="register__checkbox">
                <input type="checkbox" name="activar_notificaciones" id="noticias">
                <!-- Texto promocional animando al usuario a aceptar notificaciones -->
                <p class="register__notice">
                    ¡Nunca te pierdas nada gracias a los anuncios personalizados de <br> Soccer Flow en los medios digitales!
                    Estate atento a las últimas promociones,<br> productos y noticias de <span style="color: #079C40;">Soccer Flow</span>.
                </p>
            </div>

            <!-- Botón principal para enviar el formulario y completar el registro -->
            <button class="register__button" type="submit">Enviar</button>
        
        </form>
    
    </div>
</div>