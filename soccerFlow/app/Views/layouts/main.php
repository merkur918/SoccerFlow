<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SoccerFlow' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>


<main>
    <?php require __DIR__ . '/../' . $view . '.php'; ?>
</main>

</body>
</html>
