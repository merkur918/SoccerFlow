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
    public function getAllUsers(): array
    {
        $sql = "SELECT ID, name, email, rol, email_verified_at FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Eliminar un usuario
     */
    public function deleteUser(int $id): bool
    {
        $sql = "DELETE FROM users WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Crear un producto
     */
    public function createProduct(string $name, float $price, string $description, string $brand, string $team, string $category, string $gender): int
    {
        $sql = "INSERT INTO products (name, price, description, brand, team, category, gender)
                VALUES (:name, :price, :description, :brand, :team, :category, :gender)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':description' => $description,
            ':brand' => $brand,
            ':team' => $team,
            ':category' => $category,
            ':gender' => $gender
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Añadir imagen del producto
     */
    public function addProductImage(int $productId, string $imageUrl): bool
    {
        if (!$productId || empty($imageUrl)) return false;

        $sql = "INSERT INTO product_images (product_id, image_url) VALUES (:product_id, :image_url)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':product_id' => $productId,
            ':image_url' => $imageUrl
        ]);
    }

    /**
     * Añadir variante de producto (talla, stock y color)
     */
    public function addProductVariant(int $productId, string $size, int $stock, string $color = ''): bool
    {
        if (!$productId || empty($size) || $stock <= 0) return false;

        $sql = "INSERT INTO products_variants (product_id, size, color, stock) 
                VALUES (:product_id, :size, :color, :stock)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':product_id' => $productId,
            ':size' => $size,
            ':color' => $color,
            ':stock' => $stock
        ]);
    }
}
