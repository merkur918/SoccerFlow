<?php
class User { 
    private PDO $db; 
    public int $id; 
    public string $name; 
    public string $email; 
    public string $password; 
    public string $rol; 
    public ?string $email_verified_at; 
    public string $created_at; 

    public function __construct(PDO $db) { 
        $this->db = $db; 
        }
}
