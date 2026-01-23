<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SoccerFlow' ?></title>
    <link rel="stylesheet" href="/assets/css/estilos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&display=swap" rel="stylesheet">
     <link rel="shortcut icon" href="/assets/img/logo.png" />
   


      <!-- CSS específico de la vista -->
    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/assets/css/$cssFile")): ?>
        <link rel="stylesheet" href="/assets/css/<?= $cssFile ?>">
    <?php endif; ?>

    <!-- JS específico de la vista -->

      <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/assets/js/$jsFile")): ?>
       <script src="/assets/js/<?= $jsFile ?>"></script>
    <?php endif; ?>
</head>
<body>


<main>
    <?php require __DIR__ . '/../' . $view . '.php'; ?>
</main>

</body>
</html>
