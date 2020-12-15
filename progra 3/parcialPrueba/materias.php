<?php

require_once __DIR__ .'/vendor/autoload.php';
include_once './archivos.php';
class Materia
{
    public $nombre;
    public $cuatrimestre;
    public $id;

    public function __construct($nombre,$cuatrimestre,$id)
    {
        $this->nombre=$nombre;
        $this->cuatrimestre=$cuatrimestre;
        $this->id=$id;
    }

    public static function RegistroMateria($nombre,$cuatrimestre)
     {
        $return=false;
        $newMateria = new Materia($nombre,$cuatrimestre,Materia::incrementarId());//strtotime("now")
        if (File::GuardarJSON("materias.json",$newMateria))
        {
            $return=true;
        }
        return $return;
     }

     public static function MateriaExistente($materia)
     {
        $return = false;
        $lista = File::TraerJson("materias.json");

        if ($lista==true)
        {
            foreach ($lista as $unamateria)
            {
                if ($unamateria->id == $materia->id)
                {
                    $return = true;
                }
            }
        }
        return $return;
     }

     public static function Verificar($id)
     {
        $return = false;
        $lista = File::TraerJson("materias.json");

        if ($lista==true)
        {
            foreach ($lista as $materia)
            {
                if ($materia->id == $id)
                {
                    $return = true;
                }
            }
        }
        return $return;
    }

    public static function asignarId()
    {
      $array=File::TraerJSON(' ./materias.json');
      $posicion= count($array)+1;

      for ($i=0; $i < count($array) ; $i++) 
      { 
          if ($array[$i]->id != $i+1) 
          {
             $posicion= $i +1;
          break;
          }
      }
      return $posicion;
    }

    public static function incrementarId()
    {   
        $array=array();
        $array =File::TraerJSON("./materias.json");
        return count($array)+1;
    }

   

}




?>