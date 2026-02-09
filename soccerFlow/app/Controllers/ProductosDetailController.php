<?php

class ProductosDetailController extends Controller
{
    public function details(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "<h2>Error: ID de producto no válido</h2>";
            return;
        }

        $id = (int)$_GET['id'];

        $model = new Productos();
        $producto = $model->getById($id);

        if (!$producto) {
            echo "<h2>Producto no encontrado</h2>";
            return;
        }

        // Obtener imágenes del producto
        $imagenes = $model->getImagesByProductId($id);

        // Normalizar rutas
        foreach ($imagenes as &$img) {
            $img = str_replace('soccerFlow/public', '', $img);
            if ($img[0] !== '/') $img = '/' . $img;
        }

        $this->render('products/productDetails', [
            'title' => $producto['name'],
            'producto' => $producto,
            'imagenes' => $imagenes
        ]);
    }
}
