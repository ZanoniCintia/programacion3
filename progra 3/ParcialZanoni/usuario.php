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
        if($tipoUser == "admin" || $tipoUser == "users")
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
                
                if(usuario::validarUsuario($mail,$user->mail,$clave,$user->clave))//$mail==$user->mail && $clave== $user->clave)  
                {             
                      // var_dump($user);
                      $payload = array(
                            "email" => $mail,
                            "tipo" =>  $user->tipoUser
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

    public static function validarUsuario($mail, $mailNew, /*$tipoUser,$tipoUserNew,*/$clave,$claveNew)
    {
        $return = false;
         if ($mail==$mailNew /*&& $tipoUser==$tipoUserNew */&& $clave==$claveNew)
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
       try
       {
           $users = JWT::decode($token,"primerparcial", array("HS256"));
           
           
       }catch(Exception $ex)
       {
           $response = false;
       }
       
       $lista = File::TraerJson('users.json');
       
       if($users)
       {
           
           $response=true;
       }
       return $response;
    }
    



}






?>