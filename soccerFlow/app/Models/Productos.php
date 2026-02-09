<?php 

 Class Productos
 {
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM products";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

public function create(string $nombre,string $descripcion,float $precio,string $marca,string $equipo,string $categoria,string $genero,string $url_imagen,string $url_imagen2): int 
{
   
    $sql = "INSERT INTO products (name, description, price, brand, team, category, gender) 
            VALUES (:nombre, :descripcion, :precio, :marca, :equipo, :categoria, :genero)";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'precio' => $precio,
        'marca' => $marca,
        'equipo' => $equipo,
        'categoria' => $categoria,
        'genero' => $genero
    ]);
    $productId = (int)$this->db->lastInsertId();

    $sqlImg = "INSERT INTO product_images (product_id, image_url) VALUES (:product_id, :image_url)";
    $stmtImg = $this->db->prepare($sqlImg);

    $stmtImg->execute([
        'product_id' => $productId,
        'image_url' => $url_imagen
    ]);

    $stmtImg->execute([
        'product_id' => $productId,
        'image_url' => $url_imagen2
    ]);

    return $productId;
}

public function update(int $id,string $nombre,string $descripcion,float $precio,string $marca,string $equipo,string $categoria,string $genero,string $url_imagen,string $url_imagen2): bool 
{
    // 1. Actualizar datos del producto
    $sql = "UPDATE products 
            SET name = :nombre,
                description = :descripcion,
                price = :precio,
                brand = :marca,
                team = :equipo,
                category = :categoria,
                gender = :genero
            WHERE id = :id";

    $stmt = $this->db->prepare($sql);
    $ok = $stmt->execute([
        'id' => $id,
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'precio' => $precio,
        'marca' => $marca,
        'equipo' => $equipo,
        'categoria' => $categoria,
        'genero' => $genero
    ]);

    if (!$ok) {
        return false;
    }

    
    $sqlDelete = "DELETE FROM product_images WHERE product_id = :id";
    $stmtDelete = $this->db->prepare($sqlDelete);
    $stmtDelete->execute(['id' => $id]);

    $sqlImg = "INSERT INTO product_images (product_id, image_url) 
               VALUES (:product_id, :image_url)";
    $stmtImg = $this->db->prepare($sqlImg);

    $stmtImg->execute([
        'product_id' => $id,
        'image_url' => $url_imagen
    ]);

    $stmtImg->execute([
        'product_id' => $id,
        'image_url' => $url_imagen2
    ]);

    return true;
}



        

     public function delete(int $id): bool
     {
         $sql = "DELETE FROM products WHERE id = :id";
         $stmt = $this->db->prepare($sql);
         return $stmt->execute(['id' => $id]);
     }
    public function search(string $query): array
    {
        $sql = "SELECT * FROM products 
                WHERE name LIKE :query OR description LIKE :query";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['query' => '%' . $query . '%']);
        return $stmt->fetchAll();
    }
   
    public function getByCategory(string $categoria): array
    {
        $sql = "SELECT * FROM products WHERE category = :categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['categoria' => $categoria]);
        return $stmt->fetchAll();
    }
   
   public function getBySize(string $size): array
{
    $sql = "SELECT p.*
            FROM products p
            INNER JOIN products_variants v ON p.id = v.product_id
            WHERE v.size = :size OR v.size_shoe = :size";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['size' => $size]);

    return $stmt->fetchAll();
}

        public function getPriceById(int $id): ?float
{
    $sql = "SELECT price FROM products WHERE id = :id LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);

    $precio = $stmt->fetchColumn();

    return $precio !== false ? (float)$precio : null;
}
public function getByTeam(string $equipo): array {
    $sql = "SELECT * FROM products WHERE team = :equipo";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['equipo' => $equipo]);
    return $stmt->fetchAll();
}
public function getByBrand(string $marca): array {
    $sql = "SELECT * FROM products WHERE brand = :marca";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['marca' => $marca]);
    return $stmt->fetchAll();
}
public function getPortraitImageById(int $productId): ?string
{
    $sql = "SELECT image_url FROM product_images WHERE product_id = :productId ORDER BY id ASC LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['productId' => $productId]);

    $imagen = $stmt->fetchColumn();

    return $imagen !== false ? $imagen : null;
}
public function getImagesByProductId(int $id): array
{
    $sql = "SELECT image_url FROM product_images WHERE product_id = :id ORDER BY id ASC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);

    $imagenes = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $imagenes ?: [];
}

 }