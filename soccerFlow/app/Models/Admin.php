<?php

class Admin
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    /**
     * Obtener todos los usuarios
     */
    public function getAllUsers()
    {
        $sql = "SELECT ID, name, email, rol, email_verified_at FROM users";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Eliminar un usuario
     */
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE ID = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    /**
     * Añadir un producto
     */
    public function createProduct($name, $price, $description, $image)
    {
        $sql = "INSERT INTO products (name, price, description, image)
                VALUES (:name, :price, :description, :image)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':description' => $description,
            ':image' => $image
        ]);
    }
}