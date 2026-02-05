<?php

class CartController extends Controller
{
    public function index(): void
    {
        $this->render('products/Cart', [
            'title'   => 'Cart',
            'jsFile'  => 'Cart.js'
        ]);
    }
}