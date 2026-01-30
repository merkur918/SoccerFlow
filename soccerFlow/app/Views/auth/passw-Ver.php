<link rel="stylesheet" href="/assets/css/auth-password">

<div class="password">
    <div class="password__body">
        <div class="password__header">
            <h1 class="password__title">SOCCER FLO<span style="color: #079C40;">W</span></h1>
            <img class="password__logo" src="/assets/img/logo.png" alt="Logo Soccer Flow">
        </div>

        <form class="password__form" action="/password_post" method="post">
            <input type="hidden" name="token" value="<?= $token ?>">

            <h2>Nueva Contraseña</h2>

            <p><span style="color: #079C40;">Nueva Contraseña</span></p>
            <input type="password" name="password" required>

            <p><span style="color: #079C40;">Confirmar Contraseña</span></p>
            <input type="password" name="confirm_password" required>

            <?php if (!empty($error)): ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>

            <button class="password__button" type="submit">Cambiar Contraseña</button>
        </form>
    </div>
</div>
