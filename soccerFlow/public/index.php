
<?php

include_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Controller.php';

$router = new Router();

$router->run();