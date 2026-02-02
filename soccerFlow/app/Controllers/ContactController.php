<?php

class ContactController extends Controller
{
    public function index(): void
    {
        $this->render('contact/contactanos', [
            'title'   => 'Contáctanos',
            'cssFile' => 'main.css',
            'jsFile'  => 'header.js'
        ]);
    }
}
