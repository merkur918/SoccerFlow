<?php
class AdminController extends Controller
{
    private Admin $adminModel;

    public function __construct(SessionManager $session)
    {
        parent::__construct($session);
        $this->adminModel = new Admin();
    }

    /**
     * Mostrar listado de usuarios
     */
    public function index(): void
    {
        $users = $this->adminModel->getAllUsers();
        $this->render('admin/user', ['users' => $users]);
    }

    /**
     * Eliminar usuario
     */
    public function deleteUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $this->adminModel->deleteUser((int)$id);
            }
        }
        header('Location: /admin/user');
        exit;
    }

    /**
     * Añadir producto
     */
    public function addProduct(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Datos del formulario
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $description = $_POST['description'] ?? '';
            $brand = $_POST['brand'] ?? '';
            $team = $_POST['team'] ?? '';
            $category = $_POST['category'] ?? '';
            $gender = $_POST['gender'] ?? 'Unisex';
            $sizes = $_POST['sizes'] ?? [];
            $color = $_POST['color'] ?? '';

            // Crear el producto en la base de datos
            $productId = $this->adminModel->createProduct($name, $price, $description, $brand, $team, $category, $gender);

            // Carpeta donde guardaremos las imágenes
            $uploadDir = __DIR__ . '/../../public/assets/img/productAdmin/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $maxSize = 5 * 1024 * 1024; // 5 MB
            $allowedMime = ['image/jpeg' => 'jpg', 'image/png' => 'png'];

            //Imagen principal
            if (!empty($_FILES['main_image']['name'])) {
                $tmpName = $_FILES['main_image']['tmp_name'];
                $nameFile = $_FILES['main_image']['name'];
                $error = $_FILES['main_image']['error'];
                $size = $_FILES['main_image']['size'];

                if ($error === UPLOAD_ERR_OK && $size > 0 && $size <= $maxSize) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeReal = finfo_file($finfo, $tmpName);
                    finfo_close($finfo);

                    if (array_key_exists($mimeReal, $allowedMime)) {
                        $ext = $allowedMime[$mimeReal];
                        $filename = uniqid('main_', true) . '.' . $ext;
                        if (move_uploaded_file($tmpName, $uploadDir . $filename)) {
                            $this->adminModel->addProductImage($productId, $filename, true); // true = principal
                        }
                    }
                }
            }

            //Imágenes secundarias
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                    $error = $_FILES['images']['error'][$key];
                    $size = $_FILES['images']['size'][$key];
                    $nameFile = $_FILES['images']['name'][$key];

                    if ($error !== UPLOAD_ERR_OK || $size === 0 || $size > $maxSize) continue;

                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeReal = finfo_file($finfo, $tmpName);
                    finfo_close($finfo);

                    if (!array_key_exists($mimeReal, $allowedMime)) continue;

                    $ext = $allowedMime[$mimeReal];
                    $filename = uniqid('sec_', true) . '.' . $ext;
                    if (move_uploaded_file($tmpName, $uploadDir . $filename)) {
                        $this->adminModel->addProductImage($productId, $filename, false); // false = secundaria
                    }
                }
            }

            // Guardar tallas y stock
            foreach ($sizes as $talla => $stock) {
                $stock = (int)$stock;
                if ($stock > 0) {
                    $this->adminModel->addProductVariant($productId, $talla, $stock, $color);
                }
            }

            // Después de añadir el producto y guardar imágenes y stock
            $_SESSION['successMessage'] = "Producto añadido correctamente";

            // Redirigir al formulario nuevamente
            header('Location: /admin/createProduct');
            exit;
        }

        // Mostrar el formulario
        $this->render('admin/createProduct');
    }
}
