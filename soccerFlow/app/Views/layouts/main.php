<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SoccerFlow' ?></title>
    <?php $isDarkTheme = (($_COOKIE['sf_theme'] ?? '') === 'dark'); ?>

    <!-- CSS GLOBAL -->
    <?php
        $mainCssPath = __DIR__ . '/../../../public/assets/css/main.css';
        $mainCssVersion = file_exists($mainCssPath) ? filemtime($mainCssPath) : time();
        $darkCssPath = __DIR__ . '/../../../public/assets/css/mainOscuro.css';
        $darkCssVersion = file_exists($darkCssPath) ? filemtime($darkCssPath) : time();
    ?>
    <link rel="stylesheet" href="/assets/css/main.css?v=<?= $mainCssVersion ?>">
    <link
        rel="stylesheet"
        href="/assets/css/mainOscuro.css?v=<?= $darkCssVersion ?>"
        id="dark-theme-css"
        media="<?= $isDarkTheme ? 'all' : 'not all' ?>"
        <?= $isDarkTheme ? '' : 'disabled' ?>
    >

    <!-- CSS POR VISTA (opcional) -->
    <?php if (!empty($cssFile)): ?>
        <?php
            $viewCssPath = __DIR__ . '/../../../public/assets/css/' . $cssFile;
            $viewCssVersion = file_exists($viewCssPath) ? filemtime($viewCssPath) : time();
        ?>
        <link rel="stylesheet" href="/assets/css/<?= $cssFile ?>?v=<?= $viewCssVersion ?>">
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
    <?php
        $jsPath = __DIR__ . '/../../../public/assets/js/' . $jsFile;
        $jsVersion = file_exists($jsPath) ? filemtime($jsPath) : time();
    ?>
    <script src="/assets/js/<?= $jsFile ?>?v=<?= $jsVersion ?>"></script>
<?php endif; ?>

</body>
</html>
