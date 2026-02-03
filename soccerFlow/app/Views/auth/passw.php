<div class="password">
    <div class="password__body">
        <div class="password__header">
            <h1 class="password__title">SOCCER FLO<span style="color:#079C40;">W</span></h1>
            <img class="password__logo" src="/assets/img/logo.png" alt="Logo Soccer Flow">
        </div>

        <form class="password__form" action="/email_post" method="post">
            <h2>¿Olvidaste tu contraseña?</h2>

            <p class="password__notice">
                ¡No te preocupes! Introduce el e-mail con el que te registraste y te enviaremos un correo para cambiarla.
            </p>

            <input type="email" name="email" placeholder="tucorreo@gmail.com" required>

            <button class="password__button" type="submit">Enviar</button>

            <?php if (!empty($error)): ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>
        </form>
    </div>
</div>
