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

            // Subir imágenes
            if (!empty($_FILES['images']['name'][0])) {
                $maxSize = 5 * 1024 * 1024; // 5 MB
                $allowedMime = ['image/jpeg' => 'jpg', 'image/png' => 'png'];

                foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                    $errores = [];

                    // Validar errores de PHP
                    if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK || $_FILES['images']['size'][$key] === 0) {
                        $errores[] = "Error al subir {$_FILES['images']['name'][$key]}";
                        continue;
                    }
                    if ($_FILES['images']['size'][$key] > $maxSize) {
                        $errores[] = "El archivo {$_FILES['images']['name'][$key]} excede 5MB";
                        continue;
                    }

                    // Validar MIME real
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeReal = finfo_file($finfo, $tmpName);
                    finfo_close($finfo);

                    if (!array_key_exists($mimeReal, $allowedMime)) {
                        $errores[] = "Tipo no permitido: {$mimeReal}";
                        continue;
                    }

                    // Generar nombre seguro
                    $ext = $allowedMime[$mimeReal];
                    $filename = uniqid('prod_', true) . '.' . $ext;

                    // Mover el archivo
                    if (!move_uploaded_file($tmpName, $uploadDir . $filename)) {
                        $errores[] = "No se pudo guardar {$filename}";
                        continue;
                    }

                    // Guardar en la DB
                    $this->adminModel->addProductImage($productId, $filename);
                }
            }

            // Guardar tallas y stock
            foreach ($sizes as $talla => $stock) {
                $stock = (int)$stock;
                if ($stock > 0) {
                    $this->adminModel->addProductVariant($productId, $talla, $stock, $color);
                }
            }

            // Redirigir al formulario nuevamente
            header('Location: /admin/createProduct');
            exit;
        }

        // Mostrar el formulario
        $this->render('admin/createProduct');
    }
}