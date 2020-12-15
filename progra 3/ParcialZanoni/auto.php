<?php


require_once __DIR__ .'/vendor/autoload.php';
use \Firebase\JWT\JWT;
include_once './archivos.php';
include_once './usuario.php';
include_once './estacionamiento.php';
date_default_timezone_set("America/Argentina/Buenos_Aires"); 

class auto
{
    public $patente;
    public $fechaIngreso;
    public $tipoDeIngreso;
    public $email;

    public function __construct($patente,$fechaIngreso,$tipoDeIngreso,$email)
    {
        $this->patente=$patente;
        $this->fechaIngreso=$fechaIngreso;
        $this->tipoDeIngreso=$tipoDeIngreso;
        $this->email=$email;
    }

    public static function ingresarAuto($patente,$tipoEstadia,$token)
    {
        $retorno = false;
        $response = File::TraerJSON("users.json");
        $auto= JWT::decode($token,"primerparcial",array('HS256'));
        $fechaIngreso=date('d-m-Y H:i:s');
        //var_dump($auto);
        if($response != false)
        {
            foreach ($response as $user) 
            {
                if(usuario::validarTipo("users",$user->tipoUser))
                {  
                    
                    $new = new auto($patente,$fechaIngreso,$tipoEstadia,$auto->email);
                    $response= File::guardarJSON("autos.json",$new);
                    
                    $retorno=true;
                break;
                }else
                {
                    echo "Tipo de usuario no autorizado";
                }
            break;
            }
        }
        
        return $retorno;
        
    }

    public static function retiroAuto($patente)
    {
        $response = File::TraerJSON("autos.json");
      
        foreach ( $response as $autoActual) 
        {   
            
                if($autoActual->patente == $patente)
                {   
                    //var_dump(auto::CalcularPrecio($autoActual->tipoDeIngreso));
                      // var_dump($autoActual->tipoDeIngreso );
                        
                        $retiro= new stdClass();
                        $retiro->fechaIngreso=$autoActual->fechaIngreso;
                        $retiro->fecha_egreso=date('d-m-Y H:i:s');
                        $retiro->tipoDeIngreso= $autoActual->tipoDeIngreso;
                        $retiro->monto=auto::CalcularPrecio($autoActual->tipoDeIngreso);
                        $retiro->patente=$patente;
                        File::guardarJSON("retiro.json",$retiro);
                        echo json_encode($retiro);
   
                break;
                }
            
        }


    }


    public static function CalcularPrecio($tipoEstadia)//terminar y q calcule precio final
    {
        
        $precio= File::TraerJSON("precios.json");
        
        
           switch($tipoEstadia)
           {
                case "hora":
                    $resultado=$precio[0]->hora;
                    return $resultado;
                break;
                case "estadia":
                    $resultado=$precio[0]->estadia;
                    return $resultado;
                break;
                case "mensual":
                    $resultado=$precio[0]->mensual;
                    return $resultado;
                break;
                
           }
            
        
        
       
    }

    public static function ordenarYMostrar(){
        $array = File::traerJSON('./autos.json');
        $aux = array(); 

        for ($i=0; $i < count($array)-1; $i++) { 
            
            for ($a=$i+1; $a < count($array); $a++) { 
                
                if($array[$i]->tipoDeIngreso > $array[$a]->tipoDeIngreso){
                    
                    $aux = $array[$i];
                    $array[$i] = $array[$a];
                    $array[$a] = $aux;
                   
                }
            }
        }

        echo json_encode($array);
    }


    public static function showClientByPatent($patente)
    {
        $listaCl = File::traerJSON('./autos.json');
      
        for ($i=0; $i <  count($listaCl); $i++) { 
            
            if($listaCl[$i]->patente == $patente){
                echo json_encode($listaCl[$i]);
            break;
            }
        } 
    }

    public static function FechasPrecioFinal($fechaINgreso, $fechaEgreso)
    {
        
        $listaAutos= file::TraerJSON("./autos.json");
        $contador=0;
        foreach ($listaAutos as $auto) {
            if($auto->fechaIngreso >= $fechaINgreso && $auto->fechaIngreso <= $fechaEgreso)
            {
                $contador+=auto::CalcularPrecio($auto->tipoDeIngreso);
            }
        }
        echo $contador;


       /* $diff = $fechaINgreso->diff($fechaEgreso);
        // will output 2 days
        echo $diff->days . ' days ';*/
    }
  

    
}





?>