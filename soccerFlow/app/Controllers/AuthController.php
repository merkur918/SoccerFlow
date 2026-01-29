<?php

class AuthController extends Controller
{
    public function index(): void
    {
        $this->render('auth/register', [
            'title' => 'Registro',
            'errores' => []
        ]);
    }

    public function create(): void
    {
        $nombre = recoge('nombre');
        $email = recoge('email');
        $password = recoge('password');
        $passwordConfirm = recoge('password_confirm');

        $errores = [];

        cTexto($nombre, 'nombre', $errores);
        cEmail($email, 'email', $errores);
        cPassword($password, 'password', $errores, true);

        if ($password !== $passwordConfirm) {
            $errores['password_confirm'] = 'Las contraseñas no coinciden';
        }

        if (!empty($errores)) {
            $this->render('auth/register', compact('errores'));
            return;
        }

        $userModel = new User();

        if ($userModel->emailExists($email)) {
            $errores['email'] = 'Este email ya está registrado';
            $this->render('auth/register', compact('errores'));
            return;
        }

        $passwordHash = encriptar($password);
        $userModel->create($nombre, $email, $passwordHash);

        $user = $userModel->findByEmail($email);

        $verification = new MailVerification();
        $token = $verification->createTokenForUser($user['ID'], 86400);

        $verifyUrl = "http://localhost:8080/verify-email?token=$token";

        $result = MailConfig::send($email, 'Verifica tu cuenta',
            "<h2>Hola $nombre</h2>
             <p>Haz click para verificar tu cuenta:</p>
             <a href='$verifyUrl'>Verificar cuenta</a>" );

        if ($result !== true) {
            // Guarda el error en logs o muestra un mensaje
            error_log("Error enviando email: " . $result);
            $errores['email'] = 'Error enviando correo de verificación';
            $this->render('auth/register', compact('errores'));
        return;
}

        $this->render('auth/Email');
    }

    public function verifyEmail(): void
    {
        $token = $_GET['token'] ?? '';

        $verification = new MailVerification();
        if (!$verification->verifyToken($token)) {
            echo "Token inválido o expirado";
            return;
        }

        $this->render('auth/Email-Ver');
    }

    public function login(): void
    {
        $this->render('auth/login');
    }

    public function authenticate(): void
    {
        $email = recoge('email');
        $password = recoge('password');

        $user = (new User())->findByEmail($email);

        if (!$user || !comprobarhash($password, $user['password'])) {
            $this->render('auth/login', ['error' => 'Credenciales incorrectas']);
            return;
        }

        if ($user['email_verified_at'] === null) {
            $this->render('auth/login', ['error' => 'Debes verificar tu email']);
            return;
        }

        unset($user['password']);
        $this->session->setUser($user);
        header('Location: /home');
    }
}