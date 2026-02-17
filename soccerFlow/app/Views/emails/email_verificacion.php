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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #079C40;
            font-size: 2rem;
            margin-bottom: 15px;
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
        <h2>Hola <?= $nombre ?></h2>

        <p>Gracias por registrarte en <strong>SoccerFlow</strong>. Para activar tu cuenta, haz clic en el siguiente botón:</p>

        <a class="btn" href="<?= $verifyUrl ?>">Verificar cuenta</a>

        <p style="margin-top:20px;">Si no solicitaste esta cuenta, puedes ignorar este mensaje.</p>

        <div class="footer">
            © <?= date('Y') ?> SoccerFlow — Tu plataforma de fútbol
        </div>
    </div>

</body>

</html>