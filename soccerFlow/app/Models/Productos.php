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
   //Seleccionar por categoria
    public function getByCategory(string $categoria): array
    {
        $sql = "SELECT * FROM products WHERE category = :categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['categoria' => $categoria]);
        return $stmt->fetchAll();
    }
   //Seleccionar por talla 
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
//Seleccionar por percio
        public function getPriceById(int $id): ?float
{
    $sql = "SELECT price FROM products WHERE id = :id LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);

    $precio = $stmt->fetchColumn();

    return $precio !== false ? (float)$precio : null;
}
//Seleccionar por equipo
public function getByTeam(string $equipo): array {
    $sql = "SELECT * FROM products WHERE team = :equipo";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['equipo' => $equipo]);
    return $stmt->fetchAll();
}
//Seleccionar por marca
public function getByBrand(string $marca): array {
    $sql = "SELECT * FROM products WHERE brand = :marca";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['marca' => $marca]);
    return $stmt->fetchAll();
}
//Seleccionar imagen principal por id
public function getPortraitImageById(int $productId): ?string
{
    $sql = "SELECT image_url FROM product_images WHERE product_id = :productId ORDER BY id ASC LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['productId' => $productId]);

    $imagen = $stmt->fetchColumn();

    return $imagen !== false ? $imagen : null;
}





// Devuelve un mapa: [product_id => "38,39,40"]
public function getSizesMap(): array
{
    // Traemos todas las tallas agrupadas por producto
    $sql = "SELECT product_id,
                   GROUP_CONCAT(DISTINCT COALESCE(size_shoe, size) 
                                ORDER BY COALESCE(size_shoe, size) SEPARATOR ',') AS sizes
            FROM products_variants
            GROUP BY product_id";

    $stmt = $this->db->query($sql); // Ejecuta la consulta
    $rows = $stmt->fetchAll();      // Obtiene todas las filas

    $map = []; // Aqui guardaremos product_id => "38,39,40"

    foreach ($rows as $row) {
        $map[(int)$row['product_id']] = $row['sizes']; // Asigna el string de tallas
    }

    return $map; // Devuelve el mapa completo
}

//Seleccionar imagenes por id del producto
public function getImagesByProductId(int $id): array
{
    $sql = "SELECT image_url FROM product_images WHERE product_id = :id ORDER BY id ASC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);

    $imagenes = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $imagenes ?: [];
}
//Seleccionar por genero
public function getIdByGender(string $gender): array{
    $sql = "SELECT gender by id FROM products WHERE gender=:gender";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['gender' => $gender]);
    return $stmt-> fetchAll();
}
//Seleccionar color por id
public function getColorById(int $id): ?string{
    $sql = "SELECT color FROM products_variants WHERE product_id = :id LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);
    $color = $stmt->fetchColumn();
    return $color !== false ? $color : null;
}

    public function getSizesByProductId(int $id): array
    {
        $sql = "SELECT DISTINCT COALESCE(size_shoe, size) AS size
                FROM products_variants
                WHERE product_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $sizes = $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];

        $sizes = array_values(array_filter($sizes, fn($s) => $s !== null && $s !== ''));
        if (empty($sizes)) return [];

        $allNumeric = true;
        foreach ($sizes as $s) {
            if (!ctype_digit((string)$s)) {
                $allNumeric = false;
                break;
            }
        }

        if ($allNumeric) {
            usort($sizes, fn($a, $b) => (int)$a <=> (int)$b);
            return $sizes;
        }

        $order = ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
        usort($sizes, function ($a, $b) use ($order) {
            $aKey = strtoupper((string)$a);
            $bKey = strtoupper((string)$b);
            $aIndex = array_search($aKey, $order, true);
            $bIndex = array_search($bKey, $order, true);
            if ($aIndex === false && $bIndex === false) {
                return strnatcasecmp((string)$a, (string)$b);
            }
            if ($aIndex === false) return 1;
            if ($bIndex === false) return -1;
            return $aIndex <=> $bIndex;
        });

        return $sizes;
    }
 }
