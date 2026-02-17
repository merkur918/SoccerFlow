<?php

/**
 * Clase Productos - Modelo para gestionar productos
 * 
 * Esta clase maneja todas las operaciones relacionadas con productos:
 * - CRUD básico (Crear, Leer, Actualizar, Eliminar)
 * - Búsquedas y filtros por diferentes criterios
 * - Gestión de imágenes y variantes (tallas)
 * - Consultas especializadas para el catálogo
 */
class Productos
{
    private PDO $db;

    /**
     * Constructor: establece la conexión con la base de datos
     * Se ejecuta automáticamente al crear una instancia de Productos
     */
    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    /**
     * Obtiene todos los productos de la base de datos
     * Útil para listados generales o administración
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM products";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Obtiene un producto específico por su ID
     * Devuelve null si no existe
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Crea un nuevo producto en la base de datos
     * Inserta tanto los datos del producto como sus imágenes
     * Devuelve el ID del producto creado
     */
    public function create(
        string $nombre,
        string $descripcion,
        float $precio,
        string $marca,
        string $equipo,
        string $categoria,
        string $genero,
        string $url_imagen,
        string $url_imagen2
    ): int {
        // Inserta el producto principal
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

        // Inserta las dos imágenes asociadas al producto
        $sqlImg = "INSERT INTO product_images (product_id, image_url) VALUES (:product_id, :image_url)";
        $stmtImg = $this->db->prepare($sqlImg);

        $stmtImg->execute(['product_id' => $productId, 'image_url' => $url_imagen]);
        $stmtImg->execute(['product_id' => $productId, 'image_url' => $url_imagen2]);

        return $productId;
    }

    /**
     * Actualiza un producto existente
     * Primero actualiza los datos, luego reemplaza las imágenes (borra las antiguas e inserta nuevas)
     * Devuelve true si la operación fue exitosa
     */
    public function update(
        int $id,
        string $nombre,
        string $descripcion,
        float $precio,
        string $marca,
        string $equipo,
        string $categoria,
        string $genero,
        string $url_imagen,
        string $url_imagen2
    ): bool {
        // Actualiza datos del producto
        $sql = "UPDATE products 
                SET name = :nombre, description = :descripcion, price = :precio,
                    brand = :marca, team = :equipo, category = :categoria, gender = :genero
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

        if (!$ok) return false;

        // Reemplaza las imágenes (borra todas y luego inserta las nuevas)
        $sqlDelete = "DELETE FROM product_images WHERE product_id = :id";
        $stmtDelete = $this->db->prepare($sqlDelete);
        $stmtDelete->execute(['id' => $id]);

        $sqlImg = "INSERT INTO product_images (product_id, image_url) VALUES (:product_id, :image_url)";
        $stmtImg = $this->db->prepare($sqlImg);
        $stmtImg->execute(['product_id' => $id, 'image_url' => $url_imagen]);
        $stmtImg->execute(['product_id' => $id, 'image_url' => $url_imagen2]);

        return true;
    }

    /**
     * Elimina un producto de la base de datos
     * (Las imágenes se borrarán en cascada por la BD o habría que borrarlas antes)
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Busca productos por texto en nombre o descripción
     * Útil para el buscador general de la tienda
     */
    public function search(string $query): array
    {
        $sql = "SELECT * FROM products WHERE name LIKE :query OR description LIKE :query";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['query' => '%' . $query . '%']);
        return $stmt->fetchAll();
    }

    /**
     * Filtra productos por categoría (ej: botas, camisetas)
     */
    public function getByCategory(string $categoria): array
    {
        $sql = "SELECT * FROM products WHERE category = :categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['categoria' => $categoria]);
        return $stmt->fetchAll();
    }

    /**
     * Filtra productos por talla (busca en variantes)
     * Soporta tanto tallas de ropa (S,M,L) como números de calzado
     */
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

    /**
     * Filtra productos por equipo (Real Madrid, Barça, etc.)
     */
    public function getByTeam(string $equipo): array
    {
        $sql = "SELECT * FROM products WHERE team = :equipo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['equipo' => $equipo]);
        return $stmt->fetchAll();
    }

    /**
     * Filtra productos por marca (Nike, Adidas, etc.)
     */
    public function getByBrand(string $marca): array
    {
        $sql = "SELECT * FROM products WHERE brand = :marca";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['marca' => $marca]);
        return $stmt->fetchAll();
    }

    /**
     * Filtra productos por género (Hombre, Mujer, Unisex)
     * Nota: El método actual tiene un error (debería ser SELECT * no SELECT gender by id)
     */
    public function getIdByGender(string $gender): array
    {
        $sql = "SELECT * FROM products WHERE gender = :gender"; // Corregido
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['gender' => $gender]);
        return $stmt->fetchAll();
    }

    /**
     * Obtiene el precio de un producto por su ID
     */
    public function getPriceById(int $id): ?float
    {
        $sql = "SELECT price FROM products WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $precio = $stmt->fetchColumn();
        return $precio !== false ? (float)$precio : null;
    }

    /**
     * Obtiene la imagen principal de un producto (la primera)
     */
    public function getPortraitImageById(int $productId): ?string
    {
        $sql = "SELECT image_url FROM product_images WHERE product_id = :productId ORDER BY id ASC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['productId' => $productId]);
        $imagen = $stmt->fetchColumn();
        return $imagen !== false ? $imagen : null;
    }

    /**
     * Obtiene todas las imágenes de un producto
     */
    public function getImagesByProductId(int $id): array
    {
        $sql = "SELECT image_url FROM product_images WHERE product_id = :id ORDER BY id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $imagenes = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $imagenes ?: [];
    }

    /**
     * Obtiene el color de un producto desde sus variantes
     */
    public function getColorById(int $id): ?string
    {
        $sql = "SELECT color FROM products_variants WHERE product_id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $color = $stmt->fetchColumn();
        return $color !== false ? $color : null;
    }

    /**
     * Obtiene las tallas disponibles de un producto específico
     * Las ordena adecuadamente: números ascendentes o tallas de ropa en orden lógico (XS, S, M, L, XL...)
     */
    public function getSizesByProductId(int $id): array
    {
        // Consulta todas las tallas del producto
        $sql = "SELECT DISTINCT COALESCE(size_shoe, size) AS size
                FROM products_variants
                WHERE product_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $sizes = $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];

        // Filtra valores vacíos
        $sizes = array_values(array_filter($sizes, fn($s) => $s !== null && $s !== ''));
        if (empty($sizes)) return [];

        // Determina si son todas numéricas (tallas de calzado)
        $allNumeric = true;
        foreach ($sizes as $s) {
            if (!ctype_digit((string)$s)) {
                $allNumeric = false;
                break;
            }
        }

        // Ordena numéricamente si son números
        if ($allNumeric) {
            usort($sizes, fn($a, $b) => (int)$a <=> (int)$b);
            return $sizes;
        }

        // Ordena tallas de ropa según orden predefinido
        $order = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
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

    /**
     * Obtiene un mapa de todos los productos con sus tallas disponibles
     * Útil para filtrar rápidamente sin consultar uno por uno
     * Devuelve: [product_id => "S,M,L,XL", otro_id => "38,39,40", ...]
     */
    public function getSizesMap(): array
    {
        $sql = "SELECT product_id,
                       GROUP_CONCAT(DISTINCT COALESCE(size_shoe, size) 
                                    ORDER BY COALESCE(size_shoe, size) SEPARATOR ',') AS sizes
                FROM products_variants
                GROUP BY product_id";
        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll();

        $map = [];
        foreach ($rows as $row) {
            $map[(int)$row['product_id']] = $row['sizes'];
        }
        return $map;
    }
}
