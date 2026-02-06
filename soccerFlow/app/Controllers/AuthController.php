<?php

class AuthController extends Controller
{
    private function renderRegister(array $data = []): void
    {
        $defaults = [
            'title' => 'Registro',
            'errores' => [],
            'jsFile' => 'auth-register.js'
        ];

        $this->render('auth/register', array_merge($defaults, $data), false);
    }

    private function renderLogin(array $data = []): void
    {
        $defaults = [
            'title' => 'Login',
            'error' => '',
            'jsFile' => 'auth-login.js'
        ];

        $this->render('auth/login', array_merge($defaults, $data), false);
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER VIEW
    |--------------------------------------------------------------------------
    */

    public function index(): void
    {
        $this->renderRegister();
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE USER
    |--------------------------------------------------------------------------
    */

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
            $this->renderRegister(compact('errores'));
            return;
        }

        $userModel = new User();

        if ($userModel->emailExists($email)) {
            $this->renderRegister([
                'errores' => ['email' => 'Este email ya está registrado']
            ]);
            return;
        }

        $passwordHash = encriptar($password);
        $userModel->create($nombre, $email, $passwordHash);

        $user = $userModel->findByEmail($email);

        $verification = new MailVerification();
        $token = $verification->createTokenForUser($user['ID'], 86400);

        $verifyUrl = "http://localhost:8080/verify-email?token=$token";

        ob_start();
        $nombreLocal = $nombre;
        include __DIR__ . '/../views/emails/email_verificacion.php';
        $html = ob_get_clean();

        MailConfig::send($email, 'Verifica tu cuenta', $html);

        $this->render('auth/Email', [], false);
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFY EMAIL
    |--------------------------------------------------------------------------
    */

    public function verifyEmail(): void
    {
        $token = $_GET['token'] ?? '';

        $verification = new MailVerification();

        if (!$verification->verifyToken($token)) {
            echo "Token inválido o expirado";
            return;
        }

        $this->render('auth/login', [], false);
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN VIEW
    |--------------------------------------------------------------------------
    */

    public function login(): void
    {
        $this->renderLogin();
    }


    /*
    |--------------------------------------------------------------------------
    | AUTHENTICATE
    |--------------------------------------------------------------------------
    */

    public function authenticate(): void
    {
        $email = recoge('email');
        $password = recoge('password');

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !comprobarhash($password, $user['password'])) {
            $this->renderLogin([
                'error' => 'Credenciales incorrectas'
            ]);
            return;
        }

        if ($user['email_verified_at'] === null) {
            $this->renderLogin([
                'error' => 'Debes verificar tu email'
            ]);
            return;
        }

        unset($user['password']);

        $this->session->login(
            $user['ID'],
            $user['name'],
            5
        );

        header('Location: /home');
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | REQUEST PASSWORD VIEW
    |--------------------------------------------------------------------------
    */

    public function requestPassword(): void
    {
        $this->render('auth/passw', [], false);
    }


    /*
    |--------------------------------------------------------------------------
    | SEND RESET EMAIL
    |--------------------------------------------------------------------------
    */

    public function sendPasswordEmail(): void
    {
        $email = recoge('email');

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            $this->render('auth/passw', [
                'error' => 'No existe ninguna cuenta con ese email'
            ], false);
            return;
        }

        $verification = new MailVerification();
        $token = $verification->createTokenForUser($user['ID'], 3600);

        $resetUrl = "http://localhost:8080/password-verify?token=$token";

        ob_start();
        $nombre = $user['name'];
        include __DIR__ . '/../views/emails/password_reset.php';
        $html = ob_get_clean();

        MailConfig::send($email, 'Restablecer contraseña', $html);

        $this->render('auth/password-email-sent', [], false);
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFY RESET TOKEN
    |--------------------------------------------------------------------------
    */

    public function passwordVerify(): void
    {
        $token = $_GET['token'] ?? '';

        $verification = new MailVerification();

        if (!$verification->verifyToken($token)) {
            echo "Token inválido o expirado";
            return;
        }

        $this->render('auth/passw-Ver', [
            'token' => $token
        ], false);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PASSWORD
    |--------------------------------------------------------------------------
    */

    public function passwordUpdate(): void
    {
        $password = recoge('password');
        $confirm = recoge('confirm_password');
        $token = recoge('token');

        if ($password !== $confirm) {
            $this->render('auth/passw-Ver', [
                'token' => $token,
                'error' => 'Las contraseñas no coinciden'
            ], false);
            return;
        }

        $tokenHash = hash('sha256', $token);

        $userModel = new User();
        $userId = $userModel->findUserIdByToken($tokenHash);

        if (!$userId) {
            echo "Token inválido";
            return;
        }

        $passwordHash = encriptar($password);
        $userModel->updatePassword($userId, $passwordHash);

        header("Location: /login");
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(): void
    {
        $this->session->logout();
        header('Location: /login');
        exit;
    }
}
