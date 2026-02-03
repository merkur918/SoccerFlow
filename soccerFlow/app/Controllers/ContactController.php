<?php

class ContactController extends Controller
{
    public function index(): void
    {
        $this->render('contact/contactanos', [
            'title'   => 'Contáctanos',
            'jsFile'  => 'contacto.js'
        ]);
    }
}
