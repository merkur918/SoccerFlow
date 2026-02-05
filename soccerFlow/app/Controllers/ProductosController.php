<?php

class ProductosController extends Controller
{
    public function index(): void
    {
        $this->render('products/vistaProductos', [
            'title'   => 'productos',
            'jsFile'  => 'vistaProductos.js',
        ]);
    }
}
