<?php


class HomeController extends Controller
{
    public function index(): void
    {
        $model = new Productos();
        $productos = $model->getAll();
        $sizesMap = $model->getSizesMap();

        if (!empty($productos)) {
            shuffle($productos);
            $productos = array_slice($productos, 0, 4);

            foreach ($productos as &$p) {
                $id = (int)($p['id'] ?? $p['ID'] ?? 0);
                $imagePath = $model->getPortraitImageById($id);
                $p['image'] = $this->normalizeImagePath($imagePath);
                $p['sizes'] = $sizesMap[$id] ?? '';
            }
            unset($p);
        }

        $this->render('home/index', [
            'title' => 'Home',
            'jsFile' => 'competiciones.js',
            'productos' => $productos
        ]);
    }

    private function normalizeImagePath(?string $path): string
    {
        if (!$path) {
            return '/assets/img/products/placeholder.png';
        }

        $path = str_replace('\\', '/', $path);
        $path = str_replace('soccerFlow/public', '', $path);

        if ($path[0] !== '/') {
            $path = '/' . $path;
        }

        return $path;
    }
}
