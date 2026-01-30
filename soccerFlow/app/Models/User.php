<?php

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function emailExists(string $email): bool
    {
        return $this->findByEmail($email) !== false;
    }

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

    public function updatePassword(int $userId, string $passwordHash): bool
    {
        $sql = "UPDATE users SET password = :password WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'password' => $passwordHash,
            'id' => $userId
        ]);
    }

    public function findUserIdByToken(string $tokenHash)
    {
        $sql = "SELECT user_id FROM email_verifications 
                WHERE token = :token LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $tokenHash]);
        return $stmt->fetchColumn();
    }
}
