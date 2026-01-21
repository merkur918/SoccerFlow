
<?php


class Controller {

    protected function render(string $view, array $data = []){
        extract($data);

        require_once __DIR__ . '/../Views/layouts/main.php';

    }
}