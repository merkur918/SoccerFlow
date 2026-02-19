<?php

class ContactController extends Controller
{
    public function index(): void
    {
        $this->render('contact/contactanos', [
            'title'   => 'Contáctanos',
            'jsFile'  => 'contacto.js'
        ]);
    }
    public function saveMessage() { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
            { $nombre = $_POST['nombre'] ?? ''; 
        $email = $_POST['email'] ?? ''; 
        $asunto = $_POST['asunto'] ?? ''; 
        $mensaje = $_POST['mensaje'] ?? ''; 
        $contacto = new Contactanos(); 
        $ok = $contacto->guardarMensaje($nombre, $email, $asunto, $mensaje); 
        if ($ok) {
    echo "success";
} else {
    echo "error";
}
 exit;

          
}
    }
}