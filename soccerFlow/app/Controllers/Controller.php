
<?php


class Controller {

    

    protected function render(string $view, array $data = []){
        extract($data);

         $viewPath = $view; 
         $cssFile = str_replace('/', '-', $view) . '.css';
         $jsFile = str_replace('/', '-', $view) . '.js';
         

        require_once __DIR__ . '/../Views/layouts/main.php';

    }

    protected SessionManager $session;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

        

}