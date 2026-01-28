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

        if (!empty($errores)) {
            $this->render('auth/register', [
                'title' => 'Registro',
                'errores' => $errores
            ]);
            return;
        }

        $userModel = new User();

        if ($userModel->emailExists($email)) {
            $errores['email'] = 'Este email ya está registrado';
            $this->render('auth/register', [
                'title' => 'Registro',
                'errores' => $errores
            ]);
            return;
        }

        $passwordHash = encriptar($password);

        if (!$userModel->create($nombre, $email, $passwordHash)) {
            $errores['general'] = 'Error al crear el usuario';
            $this->render('auth/register', [
                'title' => 'Registro',
                'errores' => $errores
            ]);
            return;
        }
$mail = new MailConfig();

$mail->send(
    $email,
    'Verificacion de Email',
    '<h2>Bienvenido</h2><p>Verifica tu cuenta</p>',
    '<button>Verifica</button>'
);

        // Registro exitoso → redirige a login
        header('Location: /login');
        exit;
    }

    // GET /login
    public function login(): void
    {
        // Si ya está logueado, redirigir a home
        if ($this->session->isLoggedIn()) {
            header('Location: /home');
            exit;
        }
        
        $this->render('auth/login', [
            'title' => 'Login'
        ]);


    }

    // POST /login
    public function authenticate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        $email = recoge('email');
        $password = recoge('password');

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !comprobarhash($password, $user['password'])) {
            $this->render('auth/login', [
                'title' => 'Login',
                'error' => 'Email o contraseña incorrectos'
            ]);
            return;
        }

        // Guardar datos del usuario en sesión
        unset($user['password']);
        $this->session->setUser($user);

        // Login exitoso → redirigir a home
        header('Location: /home');
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

