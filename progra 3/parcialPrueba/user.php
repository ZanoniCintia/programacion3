<?php
use \Firebase\JWT\JWT;
require_once __DIR__ .'/vendor/autoload.php';
include_once './archivos.php';
class User
{
    public $mail;
    public $clave;

    public function __construct($mail,$clave)
    {
        $this->mail=$mail;
        $this->clave=$clave;
    }

    public static function Registrar($mail,$clave)
    {
        $return=false;
        $newUser = new User($mail,$clave);
        if (File::GuardarJSON("users.json",$newUser))
        {
            $return=true;
        }
        return $return;
    }


    public static function Login($mail,$clave)
    {
        $return=false;
        $response = File::TraerJSON("users.json");

        if ($response!=false)
        {
            $key = "pro3-parcial";
            foreach ($response as $user)
            {
                if (User::validar($mail,$clave , $user->mail, $user->clave))
                    {
                        $payload = array(
                            "email" => $mail,
                            "clave" => base64_encode($clave),
                        );
                        $return=true;
                    break;
                    }
            }
            if ($return)
            {
                $return = JWT::encode($payload, $key);
                
            }    
        }
        return $return;
    }


    public static function validar($mail,$clave, $mailNew, $passNew)
    {
        $return = false;
         if ($passNew == $clave && $mail==$mailNew)
         {
             
            $return = true;
         }
        return $return;
    }

    public static function IsAdmin($token)
    {
       $response=false;
       try
       {
           $users = JWT::decode($token,"pro3-parcial", array("HS256"));
           
       }catch(Exception $ex)
       {
           $response = false;
       }
       
      // $lista = File::TraerJson('users.json');
       
       if($users)
       {
           
           $response=true;
       }
       return $response;
    }

}





?>