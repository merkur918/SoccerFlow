<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            font-family: 'Jersey 10', Arial, Helvetica, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            border-top: 4px solid #079C40;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .header-title {
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 10px;
        }

        .header-title span {
            color: #079C40;
        }

        .logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 80px;
        }

        p {
            font-size: 1.2rem;
            color: #000000;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            background: #079C40;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 1.2rem;
            margin-top: 20px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #C5C4C4;
            text-align: center;
            font-size: 1rem;
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">

    <h1 class="header-title">SOCCER FLO<span>W</span></h1>
    <img class="logo" src="https://tuservidor.com/assets/img/logo.png" alt="Logo Soccer Flow">

    <p>Hola <?= $nombre ?>,</p>

    <p>Hemos recibido una solicitud para restablecer tu contraseña.  
    Para continuar, haz clic en el siguiente botón:</p>

    <a class="btn" href="<?= $resetUrl ?>">Restablecer Contraseña</a>

    <p style="margin-top:20px;">Si no solicitaste este cambio, puedes ignorar este mensaje.</p>

    <div class="footer">
        © <?= date('Y') ?> SoccerFlow — Tu plataforma de fútbol
    </div>

</div>

</body>
</html>
