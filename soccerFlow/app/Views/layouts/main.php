<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SoccerFlow' ?></title>
    <?php $isDarkTheme = (($_COOKIE['sf_theme'] ?? '') === 'dark'); ?>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="/assets/css/main.css">
    <link
        rel="stylesheet"
        href="/assets/css/mainOscuro.css"
        id="dark-theme-css"
        media="<?= $isDarkTheme ? 'all' : 'not all' ?>"
        <?= $isDarkTheme ? '' : 'disabled' ?>
    >

    <!-- CSS POR VISTA (opcional) -->
    <?php if (!empty($cssFile)): ?>
        <link rel="stylesheet" href="/assets/css/<?= $cssFile ?>">
    <?php endif; ?>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="/assets/img/logo.png" />
</head>
<body>



<?php if ($showLayout ?? true): ?>
    <?php require __DIR__ . '/../general/header.php'; ?>
<?php endif; ?>

<main>
    <?php require __DIR__ . '/../' . $view . '.php'; ?>
</main>

<?php if ($showLayout ?? true): ?>
    <?php require __DIR__ . '/../general/footer.php'; ?>
<?php endif; ?>

<!-- JS POR VISTA (opcional) -->
<?php if (!empty($jsFile)): ?>
    <script src="/assets/js/<?= $jsFile ?>"></script>
<?php endif; ?>

</body>
</html>
