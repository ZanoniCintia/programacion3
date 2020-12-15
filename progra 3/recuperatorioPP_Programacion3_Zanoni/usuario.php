<?php
use \Firebase\JWT\JWT;
require_once __DIR__ .'/vendor/autoload.php';
include_once './archivos.php';

class usuario
{

    public $mail;
    public $tipoUser;
    public $clave;

    public function __construct($mail,$tipoUser,$clave)
    {
        $this->mail=$mail;
        $this->tipoUser=$tipoUser;
        $this->clave=$clave;
    }

    public static function RegistrarUsuario($mail,$tipoUser,$clave)
    {
        $return=false;
        $newUser = new usuario($mail,$tipoUser,$clave);
        if($tipoUser == "admin" || $tipoUser == "user")
        {
            if (File::GuardarJSON("users.json",$newUser))
            {   
                
                $return=true;
            }
        }else{

            echo "Tipo incorrecto : ingresar tipo admin o user";
        }
       
        return $return;
    }

    public static function validarMail($mail, $mailNew)
    {
        $return = false;
         if ($mail==$mailNew)
         {
             
            $return = true;
         }
        return $return;
    }

    public static function Login($mail,$clave)
    {
        $return=false;
        $response = File::TraerJSON("users.json");
        

        if ($response!=NULL)
        {

            $key = "primerparcial";
            foreach ($response as $user)
            {    
                
                if(usuario::validarUsuario($mail,$user->mail,$clave,$user->clave))
                {             
                      
                      $payload = array(
                            "email" => $mail,
                            "tipo" =>  $user->tipoUser
                        );
                        $return=true;
                    break;
                }    
                    
            }
            
                $return = JWT::encode($payload, $key);
                
               
        }
        return $return;
    }

    public static function validarUsuario($mail, $mailNew,$clave,$claveNew)
    {
        $return = false;
         if ($mail==$mailNew && $clave==$claveNew)
         {
             
            $return = true;
         }
        return $return;
    }

    public static function validarTipo($tipo,$tipoUserNew)
    {
        $return = false;
         if ($tipo==$tipoUserNew )
         {
             
            $return = true;
         }
        return $return;
    }

   
    
    public static function IsAdmin($token)
    {
        $response=false;
        $users = JWT::decode($token,"primerparcial", array("HS256"));
            
        if($users->tipo == "admin")
        {
            $response = true;
        }    
        
    
        return $response;
    }

    public static function validarToken($token)
    {
        $response=false;
        $users = JWT::decode($token,"primerparcial", array("HS256"));
            
        if($users->tipo == "admin" || $users->tipo == "user")
        {
            $response = true;
        }    
        
    
        return $response;
    }



}






?>