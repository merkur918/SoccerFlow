<div class="login">


    <div class="login__body">


        <div class="login__header">
            <h1 class="login__title">SOCCER FLO<span style="color: #079C40;">W</span></h1>
            <img class="login__logo" src="/assets/img/logo.png" alt="Logo Soccer Flow">

        </div>
            <form class="login__form" action="/login_post" method="post">

            <h2>INICIO DE SESIÓN</h2>

            <p class="login__notice">Accede a diseños exclusivos, experiencias, ofertas...<br><span style="color: #079C40;">¡Y mucho más!</span></p>

            <input type="email" name="email" placeholder="DIRECCIÓN DE CORREO ELECTRÓNICO" required>
            <input type="password" name="password" placeholder="CONTRASEÑA" required>

            <div class="login__checkbox">
                <input type="checkbox" name="MantenerSesion" id="mantenerSesion">

                <p class="login__notice">Mantener sesión iniciada
                </p>
            </div>

            <div class="login__row">
                <a class="forgot-password" href="/passw">¿Has olvidado tu contraseña?</a>
                <button class="login__button" type="submit">Enviar</button>
            </div>

            <p>¿No tienes una cuenta? <a href="/register">Regístrate</a></p>

        </form>

    </div>
</div>