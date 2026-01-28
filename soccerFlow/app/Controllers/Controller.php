<?php

class Controller
{
    protected SessionManager $session;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    protected function render(string $view, array $data = []): void
    {
        extract($data);
        
        $session = $this->session;

        // Archivos opcionales
        $cssFile = str_replace('/', '-', $view) . '.css';
        $jsFile  = str_replace('/', '-', $view) . '.js';

        
        ob_start();
        require __DIR__ . "/../Views/$view.php";
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layouts/main.php';
    }
}