<?php

class Controller
{
    protected SessionManager $session;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    protected function render(string $view, array $data = [], bool $showLayout = true): void
    {
        extract($data);
         $session = $this->session;

        // 🔥 SIEMPRE cargar layout completo (HTML + HEAD + CSS)
        require __DIR__ . '/../views/layouts/main.php';
    }
}