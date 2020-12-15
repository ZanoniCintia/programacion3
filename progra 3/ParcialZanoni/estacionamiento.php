<?php
use \Firebase\JWT\JWT;
require_once __DIR__ .'/vendor/autoload.php';
include_once './archivos.php';
include_once './usuario.php';
include_once './respuesta.php';

class estacionamiento
{   
    public $hora;
    public $estadia;
    public $mensual;

    public function __construct($hora,$estadia,$mensual)
    {
        $this->hora=$hora;
        $this->estadia=$estadia;
        $this->mensual=$mensual;
    }

    public static function validar($tipo,$tipoUserNew)
    {
        $return = false;
         if ($tipo==$tipoUserNew )
         {
             
            $return = true;
         }
        return $return;
    }

    public static function cargarPrecio($hora,$estadia,$mensual)
    {
        $retorno = false;
        $respuesta = new Respuesta;
        $respuesta->data='';
        $response = File::TraerJSON("users.json");
        $precio= new estacionamiento($hora,$estadia,$mensual);
        
        if($response != false)
        {
            foreach ($response as $user) 
            {
                if(usuario::validarTipo("admin", $user->tipoUser))
                {   
                    

                    $response= File::guardarJSON("precios.json",$precio);
                    
                    $retorno=true;
                break;
                }
            
            }
        }else {
            echo "Tipo de usuario no autorizado";
        
        }
        //print_r( File::TraerJSON("precios.json"));
        return $retorno;
    }

    
}





?>