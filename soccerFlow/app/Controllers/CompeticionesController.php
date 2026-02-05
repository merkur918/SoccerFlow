<?php

class CompeticionesController extends Controller
{
    public function index(): void
    {
        $this->render('competitions/index', [
            'title'  => 'Competiciones',
            'jsFile' => 'competiciones.js'
        ]);
    }
}
