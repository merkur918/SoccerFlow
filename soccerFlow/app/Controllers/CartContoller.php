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
        if ($_SESSION['usuarioNivel'] != 5) {
            echo "No tienes permiso para acceder al carrito";
            exit;
        }

        $this->render('products/Cart', [
            'title'  => 'Cart',
            'jsFile' => 'cart.js'
        ]);
    }
}
