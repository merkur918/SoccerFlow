<!-- Contenedor principal de la página de inicio de sesión -->
<div class="login">

    <!-- Cuerpo principal que contiene todo el contenido del login -->
    <div class="login__body">

        <!-- Cabecera con el logo y nombre de la aplicación -->
        <div class="login__header">
            <!-- Título con la palabra "SOCCER FLOW" y la letra W en verde corporativo -->
            <h1 class="login__title">SOCCER FLO<span style="color: #079C40;">W</span></h1>
            <!-- Logo gráfico de la aplicación -->
            <img class="login__logo" src="/assets/img/logo.png" alt="Logo Soccer Flow">
        </div>

        <!-- Formulario de inicio de sesión que envía los datos a /login_post mediante POST -->
        <form class="login__form" action="/login_post" method="post">

            <!-- Título de la sección -->
            <h2>INICIO DE SESIÓN</h2>

            <!-- Mensaje promocional atractivo para animar al usuario a iniciar sesión -->
            <p class="login__notice">
                Accede a diseños exclusivos, experiencias, ofertas...<br>
                <span style="color: #079C40;">¡Y mucho más!</span>
            </p>

            <!-- Bloque PHP: Muestra errores globales de autenticación (ej: credenciales incorrectas)
                 Solo aparece si hay un error en el envío del formulario -->
            <?php if (!empty($error)): ?>
                <p class="login__global-error" role="alert"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <!-- Campo de email: obligatorio, tipo email para validación básica en navegador -->
            <div class="contacto__form-group">
                <label for="email" class="contacto__form-label">
                    Email <span class="contacto__form-required">*</span>
                </label>
                <input type="email" name="email" placeholder="DIRECCIÓN DE CORREO ELECTRÓNICO" required>
                <!-- Contenedor para mostrar errores de validación del campo email (usado por JavaScript) -->
                <p class="login__field-error" data-error-for="email"></p>
            </div>

            <!-- Campo de contraseña: obligatorio, tipo password para ocultar caracteres -->
              <div class="contacto__form-group">
                <label for="password" class="contacto__form-label">
                    Contraseña <span class="contacto__form-required">*</span>
                </label>
            <input type="password" name="password" placeholder="CONTRASEÑA" required>
            <!-- Contenedor para mostrar errores de validación del campo contraseña -->
            <p class="login__field-error" data-error-for="password"></p>
            </div>

            <!-- Checkbox para la opción "Mantener sesión iniciada" -->
            <div class="login__checkbox">
                <input type="checkbox" name="MantenerSesion" id="mantenerSesion">
                <p class="login__notice">Mantener sesión iniciada</p>
            </div>

            <!-- Fila con dos elementos: enlace de contraseña olvidada y botón de envío -->
            <div class="login__row">
                <!-- Enlace para recuperación de contraseña -->
                <a class="forgot-password" href="/passw">¿Has olvidado tu contraseña?</a>
                <!-- Botón principal para enviar el formulario -->
                <button class="login__button" type="submit">Enviar</button>
            </div>

            <!-- Enlace para usuarios sin cuenta: redirige a la página de registro -->
            <p>¿No tienes una cuenta? <a href="/register">Regístrate</a></p>

        </form>

    </div>
</div>