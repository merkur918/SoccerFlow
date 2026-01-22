
<?php


class Controller {

    protected function render(string $view, array $data = []){
        extract($data);

         $cssFile = str_replace('/', '-', $view) . '.css';

        require_once __DIR__ . '/../Views/layouts/main.php';

    }
}