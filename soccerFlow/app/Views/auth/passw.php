<!-- Contenedor principal de la página para solicitar recuperación de contraseña -->
<div class="password">
    <!-- Cuerpo principal que contiene todo el contenido -->
    <div class="password__body">
        <!-- Cabecera con el logo y nombre de la aplicación (mismo estilo en toda la web) -->
        <div class="password__header">
            <!-- Título con la palabra "SOCCER FLOW" y la letra W en verde corporativo (#079C40) -->
            <h1 class="password__title">SOCCER FLO<span style="color:#079C40;">W</span></h1>
            <!-- Logo gráfico de la aplicación para mantener la identidad visual consistente -->
            <img class="password__logo" src="/assets/img/logo.png" alt="Logo Soccer Flow">
        </div>

        <!-- Formulario para solicitar el correo de recuperación -->
        <form class="password__form" action="/email_post" method="post">
            <!-- Título principal que indica la funcionalidad de la página -->
            <h2>¿Olvidaste tu contraseña?</h2>

            <!-- Mensaje tranquilizador y explicativo para el usuario -->
            <p class="password__notice">
                ¡No te preocupes! Introduce el e-mail con el que te registraste y te enviaremos un correo para cambiarla.
            </p>

            <!-- Campo para introducir el email -->
            <input type="email" name="email" placeholder="tucorreo@gmail.com" required>

            <!-- Botón principal para enviar la solicitud -->
            <button class="password__button" type="submit">Enviar</button>

            <!-- Bloque PHP: Muestra errores si ocurren durante el proceso -->
            <?php if (!empty($error)): ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>
        </form>
    </div>
</div>