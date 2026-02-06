<?php

class NewsController extends Controller
{
    public function index(): void
    {
        $this->render('news/index', [
            'title'  => 'Noticias',
            'jsFile' => 'news.js'
        ]);
    }
}
