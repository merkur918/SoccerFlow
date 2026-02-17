<?php

/**
 * Clase Cart - Modelo para gestionar el carrito de compras
 * 
 * Esta clase maneja toda la lógica de negocio relacionada con el carrito:
 * - Creación y obtención de carritos activos
 * - Añadir, eliminar y modificar productos
 * - Consultar el contenido del carrito
 * - Calcular totales y gestionar estados
 */
class Cart
{
    private PDO $db;

    /**
     * Constructor: establece la conexión con la base de datos
     * Se ejecuta automáticamente al crear una instancia de Cart
     */
    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    /**
     * Obtiene el ID del carrito activo de un usuario
     * Busca si el usuario tiene un carrito pendiente (sin finalizar la compra)
     * Devuelve null si no existe carrito activo
     */
    public function getActiveCartId(int $userId): ?int
    {
        $sql = "SELECT id FROM carts WHERE user_id = :uid AND status = 'active' LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        $id = $stmt->fetchColumn();
        return $id !== false ? (int)$id : null;
    }

    /**
     * Crea un nuevo carrito para un usuario
     * Se usa cuando el usuario no tiene un carrito activo y quiere añadir un producto
     * Devuelve el ID del carrito recién creado
     */
    public function createCart(int $userId): int
    {
        $sql = "INSERT INTO carts (user_id, status) VALUES (:uid, 'active')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Busca el ID de una variante específica de producto
     * Las variantes combinan producto + talla (puede ser talla de ropa o número de calzado)
     * Es necesario para saber exactamente qué variante se añade al carrito
     */
    public function findVariantId(int $productId, string $size): ?int
    {
        $sql = "SELECT id FROM products_variants
                WHERE product_id = :pid AND (size = :size OR size_shoe = :size)
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['pid' => $productId, 'size' => $size]);
        $id = $stmt->fetchColumn();
        return $id !== false ? (int)$id : null;
    }

    /**
     * Añade un producto al carrito o actualiza su cantidad si ya existe
     * Primero verifica si el producto ya está en el carrito:
     * - Si existe: suma la nueva cantidad a la existente
     * - Si no existe: crea un nuevo registro
     */
    public function addItem(int $cartId, int $variantId, int $quantity, float $unitPrice): void
    {
        // Busca si el producto ya está en el carrito
        $sqlFind = "SELECT id, quantity FROM cart_items WHERE cart_id = :cid AND product_variant_id = :vid LIMIT 1";
        $stmtFind = $this->db->prepare($sqlFind);
        $stmtFind->execute([
            'cid' => $cartId,
            'vid' => $variantId
        ]);
        $existing = $stmtFind->fetch();

        if ($existing) {
            // Si ya existe, actualiza la cantidad sumando la nueva
            $newQty = (int)$existing['quantity'] + $quantity;
            $sqlUpdate = "UPDATE cart_items SET quantity = :qty WHERE id = :id";
            $stmtUpdate = $this->db->prepare($sqlUpdate);
            $stmtUpdate->execute([
                'qty' => $newQty,
                'id' => (int)$existing['id']
            ]);
            return;
        }

        // Si no existe, inserta un nuevo registro
        $sql = "INSERT INTO cart_items (cart_id, product_variant_id, quantity, unit_price)
                VALUES (:cid, :vid, :qty, :price)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'cid' => $cartId,
            'vid' => $variantId,
            'qty' => $quantity,
            'price' => $unitPrice
        ]);
    }

    /**
     * Obtiene todos los productos del carrito con todos sus detalles
     * Realiza una consulta compleja que combina varias tablas:
     * - cart_items: items del carrito
     * - products_variants: variantes (talla, color)
     * - products: información del producto
     * - product_images: primera imagen disponible
     * Devuelve un array con todos los datos necesarios para mostrar el carrito
     */
    public function getItems(int $cartId): array
    {
        $sql = "
            SELECT
                ci.id AS cart_item_id,
                ci.quantity,
                ci.unit_price,
                p.id AS product_id,
                p.name,
                p.team,
                p.brand,
                p.category,
                COALESCE(pv.size, pv.size_shoe) AS size, -- Usa talla de ropa o calzado
                pv.color,
                (
                    SELECT image_url
                    FROM product_images
                    WHERE product_id = p.id
                    ORDER BY id ASC
                    LIMIT 1
                ) AS image_url
            FROM cart_items ci
            INNER JOIN products_variants pv ON pv.id = ci.product_variant_id
            INNER JOIN products p ON p.id = pv.product_id
            WHERE ci.cart_id = :cartId
            ORDER BY ci.id DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['cartId' => $cartId]);
        return $stmt->fetchAll();
    }

    /**
     * Calcula el número total de productos en el carrito de un usuario
     * Suma las cantidades de todos los items (útil para el contador del header)
     * Ejemplo: si tiene 2 camisetas y 1 pantalón, devuelve 3
     */
    public function getCartCountByUser(int $userId): int
    {
        $sql = "
            SELECT COALESCE(SUM(ci.quantity), 0) AS total
            FROM carts c
            INNER JOIN cart_items ci ON ci.cart_id = c.id
            WHERE c.user_id = :uid AND c.status = 'active'
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        $total = $stmt->fetchColumn();
        return $total !== false ? (int)$total : 0;
    }

    /**
     * Vacía completamente un carrito eliminando todos sus items
     * Se usa cuando el usuario finaliza la compra o quiere vaciar el carrito
     */
    public function clearCartItems(int $cartId): void
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE cart_id = :cartId");
        $stmt->execute(['cartId' => $cartId]);
    }

    /**
     * Cambia el estado de un carrito
     * Estados posibles:
     * - 'active': carrito en uso (pendiente de compra)
     * - 'completed': compra finalizada
     * - 'abandoned': carrito abandonado
     */
    public function setCartStatus(int $cartId, string $status): void
    {
        $stmt = $this->db->prepare("UPDATE carts SET status = :status WHERE id = :cartId");
        $stmt->execute([
            'status' => $status,
            'cartId' => $cartId
        ]);
    }

    /**
     * Elimina un item específico del carrito
     * Primero verifica que el item pertenezca al usuario (seguridad)
     * Devuelve true si se eliminó correctamente, false si no existía o no pertenecía al usuario
     */
    public function removeItem(int $cartItemId, int $userId): bool
    {
        $sqlCart = "
            SELECT ci.id
            FROM cart_items ci
            INNER JOIN carts c ON c.id = ci.cart_id
            WHERE ci.id = :itemId AND c.user_id = :uid
            LIMIT 1
        ";
        $stmtCart = $this->db->prepare($sqlCart);
        $stmtCart->execute([
            'itemId' => $cartItemId,
            'uid' => $userId
        ]);
        $id = $stmtCart->fetchColumn();
        if (!$id) {
            return false;
        }

        // Elimina el item
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE id = :itemId");
        $stmt->execute(['itemId' => $cartItemId]);
        return $stmt->rowCount() > 0;
    }
}
