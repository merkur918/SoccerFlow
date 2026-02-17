<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&display=swap" rel="stylesheet">
    <title>Acceso Denegado</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Jersey 10", Arial, Helvetica, sans-serif;
            color: var(--text-dark);
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .box {
            text-align: center;
            padding: 30px;
        }

        h1 {
            color: #d32f2f;
            margin: 20px 0 10px;
            font-size: 5em;
        }

        p {
            font-size: 1.5em;
            color: #666;
            margin-bottom: 25px;
        }

        .links {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .link {
            color: #d32f2f;
            text-decoration: none;
            padding: 10px 15px;
            border: 1px solid #d32f2f;
            border-radius: 4px;
        }

        .link:hover {
            background: #d32f2f;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Contenedor principal centrado que actúa como tarjeta de contenido -->
    <div class="box">
        <!-- Título principal en rojo indicando el error de acceso -->
        <h1>Acceso Denegado</h1>

        <!-- Mensaje descriptivo del error y sugerencia de acciones -->
        <p>
            No tienes permisos para ver esta página.<br> <!-- <br> crea un salto de línea -->
            Inicia sesión o vuelve al inicio.
        </p>

        <!-- Contenedor para los botones/enlaces de navegación -->
        <div class="links">
            <!-- Enlace a la página de inicio de sesión con estilo de botón -->
            <a href="/login" class="link">Login</a>

            <!-- Enlace a la página principal del sitio -->
            <a href="/" class="link">Inicio</a>
        </div>
    </div>
</body>

</html>