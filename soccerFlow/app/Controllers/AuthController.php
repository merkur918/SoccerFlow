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

        // Cargar plantilla HTML de verificación
        ob_start();
        $nombreLocal = $nombre;
        $verifyUrlLocal = $verifyUrl;
        $nombre = $nombreLocal;
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

    // GET /passw → muestra el formulario para introducir el email
    public function requestPassword(): void
    {
        $this->render('auth/passw');
    }

    // POST /email_post → envía el correo de recuperación
    public function sendPasswordEmail(): void
    {
        $email = recoge('email');

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            $this->render('auth/passw', ['error' => 'No existe ninguna cuenta con ese email']);
            return;
        }

        // Crear token válido 1 hora
        $verification = new MailVerification();
        $token = $verification->createTokenForUser($user['ID'], 3600);

        $resetUrl = "http://localhost:8080/password-verify?token=$token";

        // Cargar plantilla HTML de reset de contraseña
        ob_start();
        $nombre = $user['name'];
        include __DIR__ . '/../views/emails/password_reset.php';
        $html = ob_get_clean();

        MailConfig::send($email, 'Restablecer contraseña', $html);

        $this->render('auth/password-email-sent');
    }

    // GET /password-verify?token=...
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

    // POST /password_post
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

        $db = Database::getConexion();
        $stmt = $db->prepare("SELECT * FROM email_verifications WHERE token = :token LIMIT 1");
        $stmt->execute(['token' => $tokenHash]);
        $row = $stmt->fetch();

        if (!$row) {
            echo "Token inválido";
            return;
        }

        $userId = $row['user_id'];

        // Actualizar contraseña
        $passwordHash = encriptar($password);
        $stmt = $db->prepare("UPDATE users SET password = :password WHERE ID = :id");
        $stmt->execute([
            'password' => $passwordHash,
            'id' => $userId
        ]);

        // Redirigir al login
        header("Location: /login");
        exit;
    }

    // GET /logout
    public function logout(): void
    {
        $this->session->logout();
        header('Location: /login');
        exit;
    }
}
