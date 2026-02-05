<div class="register">


    <div class="register__body">


    <div class="register__header">
    <h1 class="register__title">SOCCER FLO<span style="color: #079C40;">W</span></h1>
    <img class="register__logo" src="/assets/img/logo.png" alt="Logo Soccer Flow">

    </div>

   

    
        <form class="register__form" action="/register_post" method="post">

            <h2>REGISTRO</h2>

                    <?php if (!empty($errores)): ?>
                <p class="register__global-error" role="alert">Revisa los campos del formulario.</p>
            <?php endif; ?>

            <input type="text" name="nombre" placeholder="NOMBRE DE USUARIO" required>
            <p class="register__field-error" data-error-for="nombre"><?= htmlspecialchars($errores['nombre'] ?? '') ?></p>

            <input type="email" name="email" placeholder="DIRECCIÓN DE CORREO ELECTRÓNICO" required>
            <p class="register__field-error" data-error-for="email"><?= htmlspecialchars($errores['email'] ?? '') ?></p>

            <input type="password" name="password" placeholder="CONTRASEÑA" required>
            <p class="register__field-error" data-error-for="password"><?= htmlspecialchars($errores['password'] ?? '') ?></p>

            <input type="password" name="password_confirm" placeholder="CONFIRMAR CONTRASEÑA" required>
            <p class="register__field-error" data-error-for="password_confirm"><?= htmlspecialchars($errores['password_confirm'] ?? '') ?></p>



            <div class="register__checkbox">
            <input type="checkbox" name="activar_notificaciones" id="noticias">

            <p class="register__notice">
                ¡Nunca te pierdas nada gracias a los anuncios personalizados de <br> Soccer Flow en los medios digitales!
                Estate atento a las últimas promociones,<br> productos y noticias de <span style="color: #079C40;">Soccer Flow</span>.
            </p>
            </div>

          


            <button class="register__button" type="submit">Enviar</button>
        
        </form>
    
</div>
</div>
