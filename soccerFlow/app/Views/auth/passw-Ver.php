<div class="password">
    <div class="password__body">
        <div class="password__header">
            <h1 class="password__title">SOCCER FLO<span style="color: #079C40;">W</span></h1>
            <img class="password__logo" src="/assets/img/logo.png" alt="Logo Soccer Flow">
        </div>
        <form class="password__form" action="/password_post" method="post">
            <h2>Nueva Contraseña</h2>
            <p><span style="color: #079C40;">Nueva Contraseña</span></p>
             <input type="password" name="password" required>
             <br>
             <p><span style="color: #079C40;">Confirmar Contraseña</span></p>
             <input type="password" name="confirm_password" required>
             <div class="password__radio">
                <input type="radio" name="Mostrar" id="mostrarPassword">
                 <label for="mostrarPassword">Mostar Contraseña</label>
               
            </div>
             <button class="password__button" type="submit">Cambiar Contraseña</button>
</form>
    </div>
</div>