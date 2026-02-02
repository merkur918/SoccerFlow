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

    require __DIR__ . '/../Views/layouts/main.php';
}
}