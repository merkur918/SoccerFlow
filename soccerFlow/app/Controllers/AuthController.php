<?php

include_once __DIR__ . '/../libs/bGeneral.php';

class AuthController extends Controller
{
    // Muestra el formulario
    public function index()
    {
        $this->render('auth/register', [
            'title' => 'Registro',
            'errores' => []
        ]);
    }

    // Procesa el formulario
    public function create()
    {
        $erroresRegistro = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre = recoge('nombre');
            $email = recoge('email');
            $password = recoge('password');
            $passwordVerify = recoge('password_confirm');
            $activarNoticias = recoge('activar_notificaciones');

            cTexto($nombre, 'nombre', $erroresRegistro, 20, 3);
            cEmail($email, 'email', $erroresRegistro);
            cPassword($password, 'password', $erroresRegistro);
            cPassword($passwordVerify, 'password_confirm', $erroresRegistro);

            if (empty($erroresRegistro)) {
                // Aquí iría guardar en BD
                $this->render('home/index', [
                    'title' => 'Home'
                ]);
                return;
            }
        }

        // Si hay errores, volvemos al formulario
        $this->render('auth/register', [
            'title' => 'Registro',
            'errores' => $erroresRegistro
        ]);
    }

    public function login()
    {
        $this->render('auth/login', [
            'title' => 'Login'
        ]);
    }
}
