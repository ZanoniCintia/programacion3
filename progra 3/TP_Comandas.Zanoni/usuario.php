<?php
use \Firebase\JWT\JWT;
require_once __DIR__ .'/vendor/autoload.php';

include_once './archivos.php';

class usuario
{

    public $puesto;
    public $tipoUser;
    public $clave;

    public function __construct($puesto,$tipoUser,$clave)
    {
        $this->puesto=$puesto;
        $this->tipoUser=$tipoUser;
        $this->clave=$clave;
    }

    public static function RegistrarUsuario($puesto,$tipoUser,$clave)
    {
        $return=false;
        $newUser = new usuario($puesto,$tipoUser,$clave);
        if($tipoUser == "socio" || $tipoUser == "empleado")
        {
            if (File::GuardarJSON("registros.json",$newUser))
            {   
                
                $return=true;
            }
        }else{

            echo "Tipo incorrecto : ingresar tipo socio o empleado";
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

    public static function Login($puesto,$clave)
    {
        $return=false;
        $response = File::TraerJSON("registros.json");
        

        if ($response!=NULL)
        {

            $key = "comanda";
            foreach ($response as $user)
            {    
                
                if(usuario::validarUsuario($puesto,$user->puesto,$clave,$user->clave))
                {             
                      
                      $payload = array(
                            "puesto" => $puesto,
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

    public static function validarUsuario($puesto, $puestoNew,$clave,$claveNew)
    {
        $return = false;
         if ($puesto==$puestoNew && $clave==$claveNew)
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

   
    
    public static function IsSocio($token)
    {
        $response=false;
        $users = JWT::decode($token,"comanda", array("HS256"));
            
        if($users->tipo == "socio")
        {
            $response = true;
        }    
        
    
        return $response;
    }

    public static function validarToken($token)
    {
        $response=false;
        $users = JWT::decode($token,"comanda", array("HS256"));
            
        if($users->tipo == "socio" || $users->tipo == "empleado")
        {
            $response = true;
        }    
        
    
        return $response;
    }



}






?>