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

        /*
        $password = recoge('password');
        $passwordConfirm = recoge('password_confirm');

        */

        $errores = [];

        cTexto($nombre, 'nombre', $errores);
        cEmail($email, 'email', $errores);
        /*
        cPassword($password, 'password', $errores, true);

        if ($password !== $passwordConfirm) {
            $errores['password_confirm'] = 'Las contraseñas no coinciden';
        }
            */

        // 🔴 Si hay errores → volver al registro

        
        if (!empty($errores)) {
            $this->render('auth/register', [
                'title' => 'Registro',
                'errores' => $errores
            ]);
            return;
        }
            

        // 🟢 Aquí iría:
        // - hash de password
        // - insert en BD
        // - login automático (opcional)
       

        header('Location: /login');
        exit();
    }

    public function login(): void
    {
        $this->render('auth/login', [
            'title' => 'Login'
        ]);
    }
}
