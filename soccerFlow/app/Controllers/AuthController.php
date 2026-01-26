<?php

class AuthController extends Controller
{
    // Mostrar formulario
    public function index(): void
    {
        $this->render('auth/register', [
            'title' => 'Registro',
            'errores' => []
        ]);
    }

    // Procesar registro (SOLO POST)
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit;
        }

        $erroresRegistro = [];

        $nombre = recoge('nombre');
        $email = recoge('email');
        $password = recoge('password');
        $passwordVerify = recoge('password_confirm');

        cTexto($nombre, 'nombre', $erroresRegistro);
        cEmail($email, 'email', $erroresRegistro);
        cPassword($password, 'password', $erroresRegistro);

        if ($password !== $passwordVerify) {
            $erroresRegistro['password_confirm'] = 'Las contraseñas no coinciden';
        }

        if (!empty($erroresRegistro)) {
            $this->render('auth/register', [
                'title' => 'Registro',
                'errores' => $erroresRegistro
            ]);
            return;
        }

        // Aquí guardas en BD

        header('Location: /home');
        exit;
    }

    public function login(): void
    {
        $this->render('auth/login', [
            'title' => 'Login'
        ]);
    }
}
