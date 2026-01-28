<?php

class MailVerification {

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    /**
     * Se crea token de  verificacion
     * -Devuelve el token en CLARO(para enviarlo por email)
     * -Guarda en BD  el HASH  del token y la expiracion del mismo
     */

    public function createTokenForUser(int $email, int $ttlSeconds):string{

        //Token en claro que va al email

        $token = bin2hex(random_bytes(32));

        //El token con has que se guarda en la bd

        $tokenHash = hash('sha256',$token);

        //Expiracion

        $expiresAt = date('Y-m-d H:i:s',time() + $ttlSeconds);

        //Invalidar token si no ha sido usado

        /**
         * Cambia la expiracion al tiempo actual si el id del usuario coincide y verified_at sigue nulo
         */

        $sqlInvalidar = "UPDATE email_verifications SET expires_at = NOW() WHERE email = :email AND verified_at IS NULL";

        $stmt = $this->db->prepare($sqlInvalidar);
        $stmt->execute(['email'=>$email]);

        //Insertar un token nuevo

        $sql = "INSERT INTO email_verifications (email,token,expires_at,verified_at) VALUES (:user_id, :token, :expires_at,NULL)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':email'=>$email,
            ':token'=>$tokenHash,
            ':expires_at'=>$expiresAt
        ]);

        return $token;


    }


    /**
     * Verifica el email usando el token en claro recibido por URL
     * Devuelve true si verifica correctamente
     */

    public function verificarPorToken(string $token):bool{

        $token =trim($token);
        if($token === ''){
            return false;
        }

        $tokenHash = hash('sha256',$token);
    }
    

}
