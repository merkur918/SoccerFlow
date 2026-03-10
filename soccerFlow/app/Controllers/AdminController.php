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
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $description = $_POST['description'] ?? '';
            $image = $_FILES['image']['name'] ?? '';

            // Mover la imagen a la carpeta deseada
            if (!empty($_FILES['image']['tmp_name'])) {
                $targetDir = __DIR__ . '/../Views/assets/img/productAdmin/';
                move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $image);
            }

            $this->adminModel->createProduct($name, $price, $description, $image);
            header('Location: /admin/createProduct');
            exit;
        }

        // Renderizar formulario de añadir producto
        $this->render('admin/createProduct');
    }
}
