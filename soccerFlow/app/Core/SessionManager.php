<?php
/**
 * Gestión segura de sesiones
 */
class SessionManager
{
    private string $loginPage;
    private int $timeout;

    private const ROLE_INVITADO    = 0;
    private const ROLE_USUARIO    = 1;
    private const ROLE_ADMINISTRADOR = 9;

    public function __construct(string $loginPage = 'index.php', int $timeout = 600)
    {
        $this->loginPage = $loginPage;
        $this->timeout   = $timeout;

        // CLAVE: solo iniciar si no existe sesión
        if (session_status() === PHP_SESSION_NONE) {
            $this->start();
        }
    }

    private function start(array $options = []): void
    {
        // ini_set SOLO antes de session_start
        ini_set('session.use_strict_mode', '1');
        ini_set('session.cookie_httponly', '1');
        ini_set('session.cookie_samesite', 'Lax');
        ini_set('session.cookie_secure', '0');

        session_start();

        if (!isset($_SESSION['usuarioNivel'])) {
            $_SESSION['usuarioNivel'] = self::ROLE_INVITADO;
        }
    }
}
