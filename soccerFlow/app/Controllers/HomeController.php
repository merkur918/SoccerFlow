<?php


class HomeController extends Controller
{
    public function index(): void
    {
        $this->session->requireLogin(); // si home es privado

        $this->render('home/index', [
            'title'   => 'Home',
            'cssFile' => 'main.css',     // <-- crea este archivo
            'jsFile'  => 'header.js',      // <-- si lo necesitas
        ]);
    }
}
