<?php

class MailVerification
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    public function createTokenForUser(int $userId, int $ttlSeconds): string
    {
        $token = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $token);
        $expiresAt = date('Y-m-d H:i:s', time() + $ttlSeconds);

        // Invalidar tokens anteriores
        $sql = "UPDATE email_verifications 
                SET expires_at = NOW() 
                WHERE user_id = :user_id AND verified_at IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        // Insertar nuevo token
        $sql = "INSERT INTO email_verifications (user_id, token, expires_at)
                VALUES (:user_id, :token, :expires_at)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'token' => $tokenHash,
            'expires_at' => $expiresAt
        ]);

        return $token;
    }

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

        // Marcar verificado
        $sql = "UPDATE email_verifications 
                SET verified_at = NOW() 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $verification['id']]);

        // Marcar usuario como verificado
        $sql = "UPDATE users 
                SET email_verified_at = NOW() 
                WHERE ID = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $verification['user_id']]);

        return true;
    }
}