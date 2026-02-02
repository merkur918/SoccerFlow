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
            $this->render('auth/register', ['errores' => ['email' => 'Este email ya está registrado']]);
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

        $this->render('auth/login');
    }

    public function login(): void
    {
        $this->render('auth/login');
    }

    public function authenticate(): void
    {
        $email = recoge('email');
        $password = recoge('password');

        $userModel = new User();
        $user = $userModel->findByEmail($email);

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

    public function requestPassword(): void
    {
        $this->render('auth/passw');
    }

    public function sendPasswordEmail(): void
    {
        $email = recoge('email');

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            $this->render('auth/passw', ['error' => 'No existe ninguna cuenta con ese email']);
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

        $this->render('auth/password-email-sent');
    }

    public function passwordVerify(): void
    {
        $token = $_GET['token'] ?? '';

        $verification = new MailVerification();
        if (!$verification->verifyToken($token)) {
            echo "Token inválido o expirado";
            return;
        }

        $this->render('auth/passw-Ver', ['token' => $token]);
    }

    public function passwordUpdate(): void
    {
        $password = recoge('password');
        $confirm = recoge('confirm_password');
        $token = recoge('token');

        if ($password !== $confirm) {
            $this->render('auth/passw-Ver', [
                'token' => $token,
                'error' => 'Las contraseñas no coinciden'
            ]);
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

    public function logout(): void
    {
        $this->session->logout();
        header('Location: /login');
        exit;
    }
}
