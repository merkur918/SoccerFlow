<?php

class Contactanos {
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    public function guardarMensaje(string $nombre, string $email, string $asunto, string $mensaje): bool
    {
        $sql = "INSERT INTO contactanos (nombre, email,asunto, mensaje) VALUES (:nombre, :email,:asunto, :mensaje)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nombre' => $nombre,
            'email' => $email,
            'asunto' => $asunto,
            'mensaje' => $mensaje
        ]);
    }
}
