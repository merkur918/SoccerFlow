<?php 
class AuthController extends Controller
{
    // GET /register
    public function index(): void
    {
        $this->render('auth/register', [
            'title' => 'Registro',
            'errores' => []
        ]);
    }

    // POST /register
   public function create(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /register');
        exit;
    }

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

    // 🔴 Errores → volver
    if (!empty($errores)) {
        $this->render('auth/register', [
            'title' => 'Registro',
            'errores' => $errores
        ]);
        return;
    }

    $userModel = new User();

    // Email duplicado
    if ($userModel->emailExists($email)) {
        $errores['email'] = 'Este email ya está registrado';
        $this->render('auth/register', [
            'title' => 'Registro',
            'errores' => $errores
        ]);
        return;
    }

    // 🔐 Encriptar usando TU librería
    $passwordHash = encriptar($password);

    // Insertar
    if (!$userModel->create($nombre, $email, $passwordHash)) {
        $errores['general'] = 'Error al crear el usuario';
        $this->render('auth/register', [
            'title' => 'Registro',
            'errores' => $errores
        ]);
        return;
    }

    // ✅ OK → login
    header('Location: /login');
    exit;
}


    public function login(): void
    {
        $this->render('auth/login', [
            'title' => 'Login'
        ]);
    }
}

