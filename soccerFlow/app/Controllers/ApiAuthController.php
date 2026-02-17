<?php

class ApiAuthController extends ApiController
{
    // POST /api/v1/auth/register
    public function register(): void
    {
        $this->requireMethod('POST');

        $data = $this->input();
        $nombre = $data['nombre'] ?? '';
        $email  = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $passwordConfirm = $data['password_confirm'] ?? '';

        $errores = [];

        // Reutilizas tus validaciones
        cTexto($nombre, 'nombre', $errores);
        cEmail($email, 'email', $errores);
        cPassword($password, 'password', $errores, true);

        if ($password !== $passwordConfirm) {
            $errores['password_confirm'] = 'Las contraseñas no coinciden';
        }

        if (!empty($errores)) {
            $this->fail('Datos inválidos', 422, $errores);
        }

        $userModel = new User();

        if ($userModel->emailExists($email)) {
            $this->fail('Este email ya está registrado', 409, ['email' => 'Este email ya está registrado']);
        }

        $passwordHash = encriptar($password);
        $userModel->create($nombre, $email, $passwordHash);

        $user = $userModel->findByEmail($email);

        $verification = new MailVerification();
        $token = $verification->createTokenForUser($user['ID'], 86400);

        // En API, mejor construir URL base automáticamente
        $verifyUrl = $this->baseUrl() . "/verify-email?token=$token";

        ob_start();
        $nombreLocal = $nombre;
        include __DIR__ . '/../views/emails/email_verificacion.php';
        $html = ob_get_clean();

        MailConfig::send($email, 'Verifica tu cuenta', $html);

        // 201 Created
        $this->ok([
            'message' => 'Usuario creado. Revisa tu correo para verificar la cuenta.'
        ], 201);
    }

    // POST /api/v1/auth/login
    public function login(): void
    {
        $this->requireMethod('POST');

        $data = $this->input();
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $errores = [];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores['email'] = 'Email inválido';
        if ($password === '') $errores['password'] = 'Password requerido';

        if ($errores) $this->fail('Datos inválidos', 422, $errores);

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        // Tu código web usa comprobarhash($password, $user['password'])
        if (!$user || !comprobarhash($password, $user['password'])) {
            $this->fail('Credenciales incorrectas', 401);
        }

        if (($user['email_verified_at'] ?? null) === null) {
            $this->fail('Debes verificar tu email', 403);
        }

        // Login por sesión (cookie)
        $this->session->login($user['ID'], $user['name'], 5);

        $this->ok([
            'user' => [
                'id' => $user['ID'],
                'name' => $user['name'],
                'level' => 5
            ]
        ]);
    }

    // GET /api/v1/auth/me
    public function me(): void
    {
        $this->requireMethod('GET');

        if (!$this->session->isLoggedIn()) {
            $this->fail('No autenticado', 401);
        }

        $this->ok([
            'user' => [
                'id' => $this->session->getUserId(),
                'name' => $this->session->getUserName(),
                'level' => $this->session->getUserLevel()
            ]
        ]);
    }

    // POST /api/v1/auth/logout
    public function logout(): void
    {
        $this->requireMethod('POST');

        // Importantísimo: en API NO rediriges
        $this->session->logout(false);

        $this->ok(['message' => 'Sesión cerrada']);
    }

    // GET /api/v1/auth/verify-email?token=...
    public function verifyEmail(): void
    {
        $this->requireMethod('GET');

        $token = $_GET['token'] ?? '';
        if ($token === '') {
            $this->fail('Token requerido', 400);
        }

        $verification = new MailVerification();

        if (!$verification->verifyToken($token)) {
            $this->fail('Token inválido o expirado', 400);
        }

        $this->ok(['message' => 'Email verificado correctamente']);
    }
}
