<?php


class ProductosController extends Controller
{
    public function index(): void
    {
        $model = new Productos();

        $productos = $model->getAll();

        // Agregar imagen principal a cada producto
        foreach ($productos as &$p) {
            $imagePath = $model->getPortraitImageById((int)$p['ID']);
            $p['image'] = $this->normalizeImagePath($imagePath);
        }
        unset($p);

        $this->render('products/vistaProductos', [
            'title'  => 'productos',
            'jsFile' => 'vistaProductos.js',
            'productos' => $productos
        ]);
    }

    private function normalizeImagePath(?string $path): string
    {
        if (!$path) {
            return '/assets/img/products/placeholder.png';
        }

        $path = str_replace('\\', '/', $path);

        // Si la ruta viene como "soccerFlow/public/assets/..."
        $path = str_replace('soccerFlow/public', '', $path);

        if ($path[0] !== '/') {
            $path = '/' . $path;
        }

        return $path;
    }
}
