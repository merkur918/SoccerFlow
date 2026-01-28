<?php

/**
 * Front Controller
 */

require_once __DIR__ . '/../app/Core/autoload.php';
require_once __DIR__ . '/../app/libs/bGeneral.php';
require_once __DIR__ . '/../app/libs/bSeguridad.php';
require_once __DIR__ . '/../app/libs/Config.php';

if (headers_sent($file, $line)) {
    die("HEADERS YA ENVIADOS antes de SessionManager en: $file:$line");
}

// Crear sesión UNA sola vez
$session = new SessionManager();

// ------------------------------
// Definición de rutas
// ------------------------------
$map = [
    // Rutas generales
    'home' => [
        'controller' => 'HomeController',
        'action' => 'index',
        'nivel' => 0
    ],

    // Autenticación
    'register' => [
        'controller' => 'AuthController',
        'action' => 'index',
        'nivel' => 0
    ],

    'register_post' => [
        'controller' => 'AuthController',
        'action' => 'create',
        'nivel' => 0
    ],

    'login' => [
        'controller' => 'AuthController',
        'action' => 'login',
        'nivel' => 0
    ],

    'login_post' => [
        'controller' => 'AuthController',
        'action' => 'authenticate',
        'nivel' => 0
    ],

    'logout' => [
        'controller' => 'AuthController',
        'action' => 'logout',
        'nivel' => 1 
    ],
];

// ------------------------------
// Resolver ruta (URLs limpias)
// ------------------------------
$ruta = $_GET['ctl']
    ?? trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($ruta === '') {
    $ruta = 'home';
}

// ------------------------------
// Ruta no encontrada
// ------------------------------
if (!isset($map[$ruta])) {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>Error 404: Ruta '$ruta' no encontrada</h1>";
    exit;
}

// ------------------------------
// Obtener datos de la ruta
// ------------------------------
$controlador  = $map[$ruta]['controller'];
$actionName   = $map[$ruta]['action'];
$requiredLevel = $map[$ruta]['nivel'];

// ------------------------------
// (Permisos – lo activas luego)
// ------------------------------
/*
if (!$session->hasLevel($requiredLevel)) {
    header("HTTP/1.0 403 Forbidden");
    echo "<h1>403: No tienes permisos</h1>";
    exit;
}
*/

// ------------------------------
// Ejecutar controlador
// ------------------------------
$controller = new $controlador($session);

if (!method_exists($controller, $actionName)) {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>Error 404: Acción '$actionName' no encontrada</h1>";
    exit;
}

$controller->$actionName();
