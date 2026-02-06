<?php

/**
 * Front Controller
 */

require_once __DIR__ . '/../app/Core/autoload.php';
require_once __DIR__ . '/../app/libs/bGeneral.php';
require_once __DIR__ . '/../app/libs/bSeguridad.php';
require_once __DIR__ . '/../app/libs/Config.php';
require_once __DIR__ . '/../app/libs/MailConfig.php';



// ------------------------------
// Resolver ruta (URLs limpias)
// ------------------------------
$ruta = $_GET['ctl']
    ?? trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($ruta === '') {
    $ruta = 'home';
}


/**
 * ------Detectar API por URL---------
 * PHP_URL_PATH coge /api/v1/auth/login sin ?x=1
 *str_starts_with($path, '/api'): API si la URL real empieza por /api.
 *str_starts_with($ruta, 'api/'): por si la $ruta viene de ctl o ya va “recortada”.
 *HTTP para que pidan JSON si o si
 */

$path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';

$isApi =
    str_starts_with($path, '/api') ||
    str_starts_with($ruta, 'api/') ||
    (stripos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);






// Crear sesión UNA sola vez
$session = new SessionManager('login',600, $isApi);
$session->checkSecurity();

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
//Cargar pagina de contacto
    'contactanos' => [
        'controller' => 'ContactController',
        'action'     => 'index',
        'nivel'      => 0
],
   // Cargar pagina de productos
    'productos' => [
        'controller' => 'ProductosController',
        'action'     => 'index',
        'nivel'      => 0
    ],
    // Cargar pagina de competiciones
    'competiciones' => [
        'controller' => 'CompeticionesController',
        'action'     => 'index',
        'nivel'      => 0
    ],
    // Cargar pagina de noticias
    'noticias' => [
        'controller' => 'NewsController',
        'action'     => 'index',
        'nivel'      => 0
    ],
    // Cargar pagina de carrito
    'cart' => [
        'controller' => 'CartController',
        'action'     => 'cart',
        'nivel'      => 5
    ],
    // Cargar detalles del producto
    'product-details' => [
        'controller' => 'ProductosDetailController',
        'action'     => 'details',

        'nivel'      => 0
    ],
    /**
     * API V1 - AUTH
     */

    // ------------------------------
// API v1 - Auth
// ------------------------------
'api/v1/auth/register' => [
    'controller' => 'ApiAuthController',
    'action' => 'register',
    'nivel' => 0
],
'api/v1/auth/login' => [
    'controller' => 'ApiAuthController',
    'action' => 'login',
    'nivel' => 0
],
'api/v1/auth/me' => [
    'controller' => 'ApiAuthController',
    'action' => 'me',
    'nivel' => 5
],
'api/v1/auth/logout' => [
    'controller' => 'ApiAuthController',
    'action' => 'logout',
    'nivel' => 5
],
'api/v1/auth/verify-email' => [
    'controller' => 'ApiAuthController',
    'action' => 'verifyEmail',
    'nivel' => 0
],
// API - Noticias
'api/news' => [
    'controller' => 'ApiNewsController',
    'action' => 'index',
    'nivel' => 0
],
];

// ------------------------------
// Ruta no encontrada
// ------------------------------
if (!isset($map[$ruta])) {
    if ($isApi) {
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'ok' => false,
            'message' => "Ruta '$ruta' no encontrada"
        ], JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "<h1>Error 404: Ruta '$ruta' no encontrada</h1>";
    }
    exit;
}

// ------------------------------
// Obtener datos de la ruta
// ------------------------------
$controlador  = $map[$ruta]['controller'];
$actionName   = $map[$ruta]['action'];
$requiredLevel = $map[$ruta]['nivel'];





/**
 * -------Verificacion de acceso--------
 */
if ($requiredLevel > 0 && !$session->hasLevel($requiredLevel)) {

    $isLogged = $session->isLoggedIn();

    if($isApi){
        //401(no autenticado) o 403(Sin permisos)
        http_response_code($isLogged ? 403 : 401);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'ok'=>false,
            'message' => $isLogged ? 'No autorizado' : 'No autenticado'
        ],JSON_UNESCAPED_UNICODE);
    }else{
        echo '<h1>Acceso Denegado</h1>';
    }
    exit();
    
}


// ------------------------------
// Ejecutar controlador
// ------------------------------
$controller = new $controlador($session);

if (!method_exists($controller, $actionName)) {

    if($isApi) {
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'ok'=>false,
            'message' => $actionName . " " . "No encontrado"
        ],JSON_UNESCAPED_UNICODE);
        
    }else{
        header("HTTP/1.0 404 Not Found");
        echo "<h1>Error 404: Acción '$actionName' no encontrada</h1>";
    }
    
    exit;
}

$controller->$actionName();
