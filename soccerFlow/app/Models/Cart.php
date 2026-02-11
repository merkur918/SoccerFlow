<?php

class Cart
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    public function getActiveCartId(int $userId): ?int
    {
        $sql = "SELECT id FROM carts WHERE user_id = :uid AND status = 'active' LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        $id = $stmt->fetchColumn();
        return $id !== false ? (int)$id : null;
    }

    public function createCart(int $userId): int
    {
        $sql = "INSERT INTO carts (user_id, status) VALUES (:uid, 'active')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return (int)$this->db->lastInsertId();
    }

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

    public function addItem(int $cartId, int $variantId, int $quantity, float $unitPrice): void
    {
        $sqlFind = "SELECT id, quantity FROM cart_items WHERE cart_id = :cid AND product_variant_id = :vid LIMIT 1";
        $stmtFind = $this->db->prepare($sqlFind);
        $stmtFind->execute([
            'cid' => $cartId,
            'vid' => $variantId
        ]);
        $existing = $stmtFind->fetch();

        if ($existing) {
            $newQty = (int)$existing['quantity'] + $quantity;
            $sqlUpdate = "UPDATE cart_items SET quantity = :qty WHERE id = :id";
            $stmtUpdate = $this->db->prepare($sqlUpdate);
            $stmtUpdate->execute([
                'qty' => $newQty,
                'id' => (int)$existing['id']
            ]);
            return;
        }

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
            COALESCE(pv.size, pv.size_shoe) AS size,
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

    public function clearCartItems(int $cartId): void
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE cart_id = :cartId");
        $stmt->execute(['cartId' => $cartId]);
    }

    public function setCartStatus(int $cartId, string $status): void
    {
        $stmt = $this->db->prepare("UPDATE carts SET status = :status WHERE id = :cartId");
        $stmt->execute([
            'status' => $status,
            'cartId' => $cartId
        ]);
    }

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

        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE id = :itemId");
        $stmt->execute(['itemId' => $cartItemId]);
        return $stmt->rowCount() > 0;
    }

}
