<?php

/**
 * Front Controller
 */

require_once __DIR__ . '/../app/Core/autoload.php';
require_once __DIR__ . '/../app/libs/bGeneral.php';
require_once __DIR__ . '/../app/libs/bSeguridad.php';
require_once __DIR__ . '/../app/libs/Config.php';
require_once __DIR__ . '/../app/libs/MailConfig.php';

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
        'nivel' => 5 
    ],

    'verify-email' => [
        'controller' => 'AuthController',
        'action' => 'verifyEmail',
        'nivel' => 0
    ],

    // Vista donde se introduce el email (passw.php)
    'passw' => [
        'controller' => 'AuthController',
        'action' => 'requestPassword',
        'nivel' => 0
    ],

    // Procesa el email y envía el correo
    'email_post' => [
        'controller' => 'AuthController',
        'action' => 'sendPasswordEmail',
        'nivel' => 0
    ],

    // Enlace desde el correo (con token)
    'password-verify' => [
        'controller' => 'AuthController',
        'action' => 'passwordVerify',
        'nivel' => 0
    ],

    // Procesa la nueva contraseña
    'password_post' => [
        'controller' => 'AuthController',
        'action' => 'passwordUpdate',
        'nivel' => 0
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


if ($requiredLevel > 0 && !$session->hasLevel($requiredLevel)) {
    echo "<h1>Acceso denegado</h1>";
    exit;
}


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
