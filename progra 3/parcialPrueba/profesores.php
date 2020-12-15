<?php
include_once './archivos.php';
class Profesor
{
    public $nombre;
    public $legajo;
    

    public function __construct($nombre,$legajo)
    {
        $this->nombre = $nombre;
        $this->legajo = $legajo;
        
    }

    public static function Registro($nombre,$legajo)
     {
        $return=false;
        $profe = new Profesor($nombre,$legajo);
        $lista = File::TraerJson("profesores.json");
        if (Profesor::ProfesorExiste($profe))
        {
            $return = "Un profesor no puede tener el mismo legajo que otro.";
        }else
        {
            if (File::GuardarJSON("profesores.json",$profe))
            {
                $return=true;
            }
        }
        return $return;
     }

     public static function ProfesorExiste($profe)
     {
        $return = false;
        $lista = File::TraerJson("profesores.json");

        if ($lista==true)
        {
            foreach ($lista as $unprofe)
            {
                if ($unprofe->legajo == $profe->legajo)
                {
                    $return = true;
                }
            }
        }
        return $return;
     }

     public static function Verificar($legajo)
     {
        $return = false;
        $lista = File::TraerJson("profesores.json");

        if ($lista==true)
        {
            foreach ($lista as $unprofe)
            {
                if ($unprofe->legajo == $legajo)
                {
                    $return = true;
                }
            }
        }
        return $return;
     }

}





?>