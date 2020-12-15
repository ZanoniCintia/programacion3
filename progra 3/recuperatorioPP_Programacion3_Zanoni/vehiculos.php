<?php
require_once __DIR__ .'/vendor/autoload.php';
use \Firebase\JWT\JWT;
include_once './archivos.php';
include_once './usuario.php';


class vehiculo
{
    public $patente;
    public $marca;
    public $modelo;
    public $precio;

    public function __construct($patente,$marca,$modelo,$precio)
    {
        $this->patente=$patente;
        $this->marca=$marca;
        $this->modelo=$modelo;
        $this->precio=$precio;
    }

    public static function ingresarAuto($patente,$marca,$modelo,$precio)
    {
    
        if(!vehiculo::validarPatente($patente))
        {  
                
            $new = new vehiculo($patente,$marca,$modelo,$precio);
            File::guardarJSON("vehiculos.json",$new);
            echo "Auto registrado";
        
        }else
        {
            echo "Patente ya ingresada";
        }
    
    }

    public static function validarPatente($patente)
    {   
        $autos = File::TraerJSON("vehiculos.json");
        $retorno=false;
        if($autos != null)
        {
            foreach ($autos as $nuevoAuto) 
            {
                if($nuevoAuto->patente == $patente)
                {
                    $retorno = true;
                break;
                }
            }
        }
         return $retorno;
    }

    public static function verificarExistencia($ocurrencia)
    {
        $autos = File::TraerJSON("vehiculos.json");
        $existe=false;
        foreach ($autos as $vehiculo) 
        {
            if($vehiculo->patente==$ocurrencia || $vehiculo->modelo==$ocurrencia || $vehiculo->marca == $ocurrencia)
            {
                $res=new stdClass();
                $res->patente=$vehiculo->patente;
                $res->marca=$vehiculo->marca;
                $res->modelo=$vehiculo->modelo;

                echo json_encode($res);
                $existe = true;
            }
        }
        if(!$existe){
            echo "NO Existe  ".$ocurrencia;
        }
    }

    public static function ingresarServicio($id,$tipoServicio,$precio,$demora)
    {
        $res=new stdClass();
        $res->id=$id;
        $res->tipoServicio=$tipoServicio;
        $res->precio=$precio;
        $res->demora=$demora;

        echo json_encode($res);
            
        
        File::guardarJSON("tiposServicios.json",$res);

    }

    public static function Asignarturno($patente,$fecha,$tipoServicio)
    {   
        
        if(vehiculo::validarPatente($patente))
        {
            $turno= file::TraerJSON("./turnos.json");
            $noHayCupo=false;
                     
            if($turno!=null)
            {
                
                foreach ($turno as $auxTurnos)
                {
                    if($auxTurnos->fecha==$fecha)
                    {
                        echo "No hay cupo";
                        $noHayCupo=true;
                    break;
                    }
                }
                if(!$noHayCupo)
                {
                    $res=new stdClass();
                    $res->fecha=$fecha;
                    $res->datos=vehiculo::retornaAuto($patente);
                    $res->servicio=vehiculo::retornaServicio($tipoServicio);

                    echo json_encode($res);
                    File::guardarJSON("turnos.json",$res);   
        
        
                }
            }else{
                $res=new stdClass();
                $res->fecha=$fecha;
                $res->datos=vehiculo::retornaAuto($patente);
                $res->servicio=vehiculo::retornaServicio($tipoServicio);

                echo json_encode($res);
                File::guardarJSON("turnos.json",$res);   
            }
        }else {

            echo "Patente no existe";
        }
    }


    
    public static function retornaAuto($patente)
    {   
        $autos = File::TraerJSON("vehiculos.json");
        
        if($autos != null)
        {
            foreach ($autos as $nuevoAuto) 
            {
                if($nuevoAuto->patente == $patente)
                {
                    return $nuevoAuto;
               
                }
            }
        }
         
    }

    public static function retornaServicio($tipo)
    {   
        $servicio = File::TraerJSON("tiposServicios.json");
        
        if($servicio != null)
        {
            foreach ($servicio as $nuevoServicio) 
            {
                if($nuevoServicio->tipoServicio == $tipo)
                {
                    return $nuevoServicio;
               
                }
            }
        }
         
    }


    public static function statsService($tipoService)
    {
        $services = file::TraerJSON("./turnos.json");
        $retorno=false;
        
        if($services != null)
        {
            foreach ($services as $service) 
            {   
                if($service->servicio->tipoServicio == $tipoService)
                {
                    echo json_encode($service);
                    $retorno= true;
                }
               
            }
            if(!$retorno)
            {
                echo json_encode($services);
            }
        }

    }

}