<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8">
    <!-- Título dinámico: usa $title si existe, o "SoccerFlow" por defecto -->
    <title><?= $title ?? 'SoccerFlow' ?></title>

    <!-- Detección del tema (claro/oscuro) desde cookie -->
    <?php $isDarkTheme = (($_COOKIE['sf_theme'] ?? '') === 'dark'); ?>

    <!-- === CSS GLOBAL === -->
    <?php
    // Ruta al archivo CSS principal (tema claro)
    $mainCssPath = __DIR__ . '/../../../public/assets/css/main.css';
    // Versión basada en la fecha de modificación para cache busting
    $mainCssVersion = file_exists($mainCssPath) ? filemtime($mainCssPath) : time();

    // Ruta al archivo CSS del tema oscuro
    $darkCssPath = __DIR__ . '/../../../public/assets/css/mainOscuro.css';
    $darkCssVersion = file_exists($darkCssPath) ? filemtime($darkCssPath) : time();
    ?>

    <!-- Carga del CSS principal (siempre) -->
    <link rel="stylesheet" href="/assets/css/main.css?v=<?= $mainCssVersion ?>">
    <!-- Carga condicional del tema oscuro según la cookie -->
    <link
        rel="stylesheet"
        href="/assets/css/mainOscuro.css?v=<?= $darkCssVersion ?>"
        id="dark-theme-css"
        media="<?= $isDarkTheme ? 'all' : 'not all' ?>"
    <?= $isDarkTheme ? '' : 'disabled' ?>
    >

    <!-- === CSS ESPECÍFICO POR VISTA (opcional) === -->
    <?php if (!empty($cssFile)): ?>
        <?php
        $viewCssPath = __DIR__ . '/../../../public/assets/css/' . $cssFile;
        $viewCssVersion = file_exists($viewCssPath) ? filemtime($viewCssPath) : time();
        ?>
        <link rel="stylesheet" href="/assets/css/<?= $cssFile ?>?v=<?= $viewCssVersion ?>">
    <?php endif; ?>

    <!-- === FUENTES === -->
    <!-- Precarga de Google Fonts para optimización -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Carga de la fuente "Jersey 10" -->
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&display=swap" rel="stylesheet">

    <!-- Favicon (icono de pestaña) -->
    <link rel="shortcut icon" href="/assets/img/logo.png" />
</head>

<body>

    <!-- === CABECERA (condicional) === -->
    <?php if ($showLayout ?? true): ?> <!-- Por defecto se muestra, pero se puede ocultar con $showLayout=false -->
        <?php require __DIR__ . '/../general/header.php'; ?>
    <?php endif; ?>

    <!-- === CONTENIDO PRINCIPAL === -->
    <main>
        <!-- Incluye la vista específica pasada desde el controlador -->
        <?php require __DIR__ . '/../' . $view . '.php'; ?>
    </main>

    <!-- === PIE DE PÁGINA (condicional) === -->
    <?php if ($showLayout ?? true): ?>
        <?php require __DIR__ . '/../general/footer.php'; ?>
    <?php endif; ?>

    <!-- === JAVASCRIPT ESPECÍFICO POR VISTA (opcional) === -->
    <?php if (!empty($jsFile)): ?>
        <?php
        $jsPath = __DIR__ . '/../../../public/assets/js/' . $jsFile;
        $jsVersion = file_exists($jsPath) ? filemtime($jsPath) : time();
        ?>
        <script src="/assets/js/<?= $jsFile ?>?v=<?= $jsVersion ?>"></script>
    <?php endif; ?>

</body>

</html>