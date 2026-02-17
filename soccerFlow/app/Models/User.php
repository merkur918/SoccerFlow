<?php

/**
 * Clase User - Modelo para gestionar usuarios
 * 
 * Esta clase maneja todas las operaciones relacionadas con usuarios:
 * - Búsqueda de usuarios por email o ID
 * - Creación de nuevos usuarios
 * - Verificación de existencia de email
 * - Actualización de contraseñas
 * - Consultas relacionadas con verificación de email
 * 
 * Es la capa de acceso a datos para la tabla 'users' y colabora
 * con otras tablas como 'email_verifications'
 */
class User
{
    private PDO $db;

    /**
     * Constructor: establece la conexión con la base de datos
     * Se ejecuta automáticamente al crear una instancia de User
     */
    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    /**
     * Busca un usuario por su dirección de email
     * Útil para login, verificación de existencia y recuperación de contraseña
     * Devuelve el registro completo del usuario o false si no existe
     */
    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Busca un usuario por su ID
     * Útil para obtener datos del usuario cuando ya está identificado
     * (ej: después del login, para mostrar perfil)
     */
    public function findById(int $id)
    {
        $sql = "SELECT * FROM users WHERE ID = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Comprueba si un email ya está registrado en la base de datos
     * Útil durante el registro para evitar duplicados
     * Devuelve true si el email existe, false si está disponible
     */
    public function emailExists(string $email): bool
    {
        return $this->findByEmail($email) !== false;
    }

    /**
     * Crea un nuevo usuario en la base de datos
     * Recibe el nombre, email y password ya hasheado
     * Devuelve true si la inserción fue exitosa
     * 
     * Nota: La contraseña debe ser hasheada antes de llamar a este método
     * (generalmente con password_hash())
     */
    public function create(string $name, string $email, string $passwordHash): bool
    {
        $sql = "INSERT INTO users (name, email, password) 
                VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $passwordHash
        ]);
    }

    /**
     * Actualiza la contraseña de un usuario
     * Se usa en recuperación de contraseña (cuando el usuario la olvida)
     * o cuando el usuario quiere cambiarla desde su perfil
     * 
     * La nueva contraseña debe venir ya hasheada
     */
    public function updatePassword(int $userId, string $passwordHash): bool
    {
        $sql = "UPDATE users SET password = :password WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'password' => $passwordHash,
            'id' => $userId
        ]);
    }

    /**
     * Obtiene el ID de usuario asociado a un token de verificación
     * Útil durante el proceso de verificación de email para saber
     * qué usuario está intentando verificar su cuenta
     * 
     * Recibe el token hasheado (no el token original) y devuelve
     * el user_id si existe o false si no
     */
    public function findUserIdByToken(string $tokenHash)
    {
        $sql = "SELECT user_id FROM email_verifications 
                WHERE token = :token LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $tokenHash]);
        return $stmt->fetchColumn();
    }
}
