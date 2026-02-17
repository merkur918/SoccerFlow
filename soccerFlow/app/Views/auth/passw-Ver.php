<!-- Contenedor principal de la página de recuperación/cambio de contraseña -->
<div class="password">
    <!-- Cuerpo principal que contiene todo el contenido -->
    <div class="password__body">
        <!-- Cabecera con el logo y nombre de la aplicación (mismo estilo que login/registro) -->
        <div class="password__header">
            <!-- Título con la palabra "SOCCER FLOW" y la letra W en verde corporativo (#079C40) -->
            <h1 class="password__title">SOCCER FLO<span style="color:#079C40;">W</span></h1>
            <!-- Logo gráfico de la aplicación para mantener la identidad visual -->
            <img class="password__logo" src="/assets/img/logo.png" alt="Logo Soccer Flow">
        </div>

        <!-- Formulario para establecer la nueva contraseña -->
        <form class="password__form" action="/password_post" method="post">
            <!-- Campo oculto que contiene el token de verificación
                 Este token se recibe por email y asegura que solo el usuario legítimo
                 puede cambiar la contraseña -->
            <input type="hidden" name="token" value="<?= $token ?>">

            <!-- Título de la sección -->
            <h2>Nueva Contraseña</h2>

            <!-- Campo para la nueva contraseña -->
            <input type="password" name="password" placeholder="Nueva contraseña" required>

            <!-- Campo para confirmar la nueva contraseña (debe coincidir con el anterior) -->
            <input type="password" name="confirm_password" placeholder="Confirmar contraseña" required>

            <!-- Bloque PHP: Muestra errores si ocurren durante el proceso
                 (ej: token inválido, contraseñas no coinciden, requisitos no cumplidos) -->
            <?php if (!empty($error)): ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>

            <!-- Botón principal para enviar el formulario y completar el cambio de contraseña -->
            <button class="password__button" type="submit">Cambiar Contraseña</button>
        </form>
    </div>
</div>