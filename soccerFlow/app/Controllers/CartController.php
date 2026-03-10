<?php



class CartController extends Controller
{
    public function cart()
    {

        // Verificar si el usuario está logueado
        if (!isset($_SESSION['usuarioId'])) {
            header("Location: index.php");
            exit;
        }

        // Verificar nivel
        if ($_SESSION['usuarioNivel'] != 5 && $_SESSION['usuarioNivel'] != 10) {
            echo "No tienes permiso para acceder al carrito";
            exit;
        }

        $cartModel = new Cart();
        $cartId = $cartModel->getActiveCartId((int)$_SESSION['usuarioId']);
        $items = $cartId ? $cartModel->getItems($cartId) : [];

        $this->render('products/Cart', [
            'title'  => 'Cart',
            'jsFile' => 'cart.js',
            'items'  => $items
        ]);
    }

    public function add()
    {
        // 1) Asegurarnos que es POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?ctl=productos');
            exit;
        }

        // 2) Recoger datos del formulario
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $size = trim($_POST['size'] ?? '');
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

        // 3) Validaciones mínimas
        if ($productId <= 0 || $quantity <= 0 || $size === '') {
            echo "Datos incompletos";
            exit;
        }

        // 4) Guardar en BD
        $userId = (int)($_SESSION['usuarioId'] ?? 0);
        if ($userId <= 0) {
            header('Location: index.php?ctl=login');
            exit;
        }

        $cartModel = new Cart();
        $cartId = $cartModel->getActiveCartId($userId);

        if (!$cartId) {
            $cartId = $cartModel->createCart($userId);
        }

        $variantId = $cartModel->findVariantId($productId, $size);
        if (!$variantId) {
            echo "No se encontró variante para esa talla";
            exit;
        }

        $productModel = new Productos();
        $unitPrice = $productModel->getPriceById($productId);

        if ($unitPrice === null) {
            echo "Producto no encontrado";
            exit;
        }

        $cartModel->addItem($cartId, $variantId, $quantity, $unitPrice);

        // Redirigir al carrito
        header('Location: index.php?ctl=cart');
        exit;
    }

    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['ok' => false, 'message' => 'Metodo no permitido']);
            return;
        }

        $userId = (int)($_SESSION['usuarioId'] ?? 0);
        if ($userId <= 0) {
            http_response_code(401);
            echo json_encode(['ok' => false, 'message' => 'No autenticado']);
            return;
        }

        $cartItemId = isset($_POST['cart_item_id']) ? (int)$_POST['cart_item_id'] : 0;
        if ($cartItemId <= 0) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'message' => 'ID invalido']);
            return;
        }

        $cartModel = new Cart();
        $ok = $cartModel->removeItem($cartItemId, $userId);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => (bool)$ok, 'itemId' => $cartItemId]);
    }

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?ctl=cart');
            exit;
        }

        $userId = (int)($_SESSION['usuarioId'] ?? 0);
        if ($userId <= 0) {
            header('Location: index.php?ctl=login');
            exit;
        }

        $cartModel = new Cart();
        $cartId = $cartModel->getActiveCartId($userId);
        if (!$cartId) {
            header('Location: index.php?ctl=cart');
            exit;
        }

        $items = $cartModel->getItems($cartId);
        if (empty($items)) {
            header('Location: index.php?ctl=cart');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($userId);
        $email = $user['email'] ?? null;
        $nombre = $user['name'] ?? 'Usuario';

        if (!$email) {
            echo "No se pudo encontrar el email del usuario.";
            exit;
        }

        $total = 0;
        foreach ($items as $item) {
            $qty = (int)($item['quantity'] ?? 0);
            $price = (float)($item['unit_price'] ?? 0);
            $total += $qty * $price;
        }

        $invoiceId = 'SF-' . date('Ymd') . '-' . rand(1000, 9999);
        $invoiceDate = date('d/m/Y H:i');

        ob_start();
        include __DIR__ . '/../Views/emails/invoice.php';
        $html = ob_get_clean();

        $altText = "Factura SoccerFlow\n" .
            "Factura: {$invoiceId}\n" .
            "Fecha: {$invoiceDate}\n" .
            "Total: $" . number_format($total, 2);

        $sendResult = MailConfig::send($email, 'Factura de tu compra - SoccerFlow', $html, $altText);

        if ($sendResult !== true) {
            echo "No se pudo enviar el email. Intenta más tarde.";
            exit;
        }

        $cartModel->setCartStatus($cartId, 'converted');
        $cartModel->clearCartItems($cartId);

        $this->render('products/checkoutSuccess', [
            'title' => 'Compra realizada',
            'jsFile' => 'checkout-success.js'
        ]);
        exit;
    }
}
