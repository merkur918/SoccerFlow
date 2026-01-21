<?php

class AuthController extends Controller {

   public function register()
{
    $this->render('auth/register',[
        'title'=>'Registro'
    ]);
}

public function login(){
    $this->render('auth/login',[
        'title' =>'login'
    ]);
}
}