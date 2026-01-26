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

    // POST /register_post
    public function create(): void
    {
        // Solo permitir POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            var_dump(headers_sent($file, $line));
            var_dump($file, $line);
            exit;

            header('Location: /register');
            exit;
        }

        // Recoger datos
        $nombre = recoge('nombre');
        $email = recoge('email');
        $password = recoge('password');
        $passwordConfirm = recoge('password_confirm');

        // Validar
        $errores = [];

        cTexto($nombre, 'nombre', $errores);
        cEmail($email, 'email', $errores);
        cPassword($password, 'password', $errores);

        if ($password !== $passwordConfirm) {
            $errores['password_confirm'] = 'Las contraseñas no coinciden';
        }

        // 4️⃣ Si hay errores → volver al formulario (render)
        if (!empty($errores)) {
            $this->render('auth/register', [
                'title' => 'Registro',
                'errores' => $errores
            ]);
            return;
        }

        // Guardar en BD (aquí iría el insert)
        // password_hash($password, PASSWORD_DEFAULT);

        // Redirect tras POST (NO render)
        header('Location: /login');
        exit;
    }

    // GET /login
    public function login(): void
    {
        $this->render('auth/login', [
            'title' => 'Login'
        ]);
    }
}
