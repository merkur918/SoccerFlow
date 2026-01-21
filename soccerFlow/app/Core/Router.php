<?php

class Router
{
    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/') {
            $uri = substr($uri, strlen($basePath));
        }

        $uri = trim($uri, '/');

        $segments = array_values(array_filter(explode('/', $uri)));

        $controllerName = ucfirst($segments[0] ?? 'home') . 'Controller';
        $method = $segments[1] ?? 'index';

        $controllerFile = __DIR__ . '/../Controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            die("Controlador no encontrado: $controllerFile");
        }

        require_once $controllerFile;
        require_once __DIR__ . '/Controller.php';

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            die("Método no encontrado: $method");
        }

        $controller->$method();
    }
}
