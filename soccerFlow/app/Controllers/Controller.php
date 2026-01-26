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

        // Archivos opcionales
        $cssFile = str_replace('/', '-', $view) . '.css';
        $jsFile  = str_replace('/', '-', $view) . '.js';

        // 1️⃣ Renderizar la vista en buffer
        ob_start();
        require __DIR__ . "/../Views/$view.php";
        $content = ob_get_clean();

        // 2️⃣ Renderizar el layout (UNA sola salida)
        require __DIR__ . '/../Views/layouts/main.php';
    }
}
