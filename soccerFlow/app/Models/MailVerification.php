<?php

class MailVerification {

     private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConexion();
    }

}
