<?php

/**
 * Clase MailVerification - Gestión de verificación de correo electrónico
 * 
 * Esta clase maneja todo el proceso de verificación de email:
 * - Generación de tokens únicos para cada usuario
 * - Almacenamiento seguro en base de datos
 * - Validación de tokens con control de expiración
 * - Marcado de usuarios como verificados
 * 
 */
class MailVerification
{
    private PDO $db;

    /**
     * Constructor: establece la conexión con la base de datos
     * Se ejecuta automáticamente al crear una instancia de MailVerification
     */
    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    /**
     * Genera un token único para un usuario y lo almacena en la base de datos
     * 
     * Parámetros:
     * - $userId: ID del usuario que solicita la verificación
     * - $ttlSeconds: tiempo de vida del token en segundos (ej: 3600 = 1 hora)
     * 
     * Proceso:
     * 1. Genera un token aleatorio seguro (64 caracteres hexadecimales)
     * 2. Crea un hash del token (SHA-256) para almacenarlo de forma segura
     * 3. Invalida cualquier token anterior no usado (por seguridad)
     * 4. Guarda el nuevo token con fecha de expiración
     * 
     * Devuelve el token original (sin hashear) para enviar al usuario por email
     */
    public function createTokenForUser(int $userId, int $ttlSeconds): string
    {
        $token = bin2hex(random_bytes(32));

        $tokenHash = hash('sha256', $token);

        $expiresAt = date('Y-m-d H:i:s', time() + $ttlSeconds);

        $sql = "UPDATE email_verifications 
                SET expires_at = NOW() 
                WHERE user_id = :user_id AND verified_at IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        $sql = "INSERT INTO email_verifications (user_id, token, expires_at)
                VALUES (:user_id, :token, :expires_at)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'token' => $tokenHash,
            'expires_at' => $expiresAt
        ]);

        // Devolvemos el token original para enviarlo por email
        return $token;
    }

    /**
     * Verifica si un token es válido y marca al usuario como verificado
     * 
     * Parámetros:
     * - $token: token original recibido por email (el que se generó con createTokenForUser)
     * 
     * Proceso:
     * 1. Hashea el token recibido para compararlo con el almacenado
     * 2. Busca en BD un token que:
     *    - Coincida con el hash
     *    - No haya expirado (expires_at > NOW())
     *    - No haya sido usado antes (verified_at IS NULL)
     * 3. Si existe, marca la verificación como completada y actualiza el usuario
     * 
     * Devuelve:
     * - true: token válido y usuario verificado correctamente
     * - false: token inválido, expirado o ya usado
     */
    public function verifyToken(string $token): bool
    {
        $tokenHash = hash('sha256', $token);

        $sql = "SELECT * FROM email_verifications 
                WHERE token = :token 
                AND expires_at > NOW()
                AND verified_at IS NULL
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $tokenHash]);
        $verification = $stmt->fetch();

        if (!$verification) return false;

        $sql = "UPDATE email_verifications 
                SET verified_at = NOW() 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $verification['id']]);

        $sql = "UPDATE users 
                SET email_verified_at = NOW() 
                WHERE ID = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $verification['user_id']]);

        return true;
    }
}
