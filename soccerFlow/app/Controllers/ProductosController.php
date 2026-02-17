<?php


class ProductosController extends Controller
{
    public function index(): void
    {
        $model = new Productos(); //Instancia del modelo

        $productos = $model->getAll(); //Lista de productos

        $sizesMap = $model->getSizesMap(); //Mapa de tallas del producto


        // Agregar imagen principal a cada producto
        foreach ($productos as &$p) {
            $id = (int)($p['id'] ?? $p['ID'] ?? 0);
            $imagePath = $model->getPortraitImageById($id);
            $p['image'] = $this->normalizeImagePath($imagePath);
            $p['sizes'] = $sizesMap[$id] ?? '';
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
