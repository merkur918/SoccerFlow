<?php
<<<<<<< HEAD

=======
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
>>>>>>> 5b302a0cae97c1a67f7b129f365dd65bf4f96679
