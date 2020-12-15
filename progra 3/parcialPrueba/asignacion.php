<?php
include_once './profesores.php';
include_once './materias.php';
include_once './archivos.php';

class Asignacion
{
    public $legajo;
    public $id;
    public $turno;

    public function __construct($legajo,$id,$turno)
    {
        $this->legajo=$legajo;
        $this->id=$id;
        $this->turno=$turno;
    }

    public static function Registro($legajo, $id,$turno)
     {
        $return=false;
        $asig = new Asignacion($legajo, $id, $turno);
        $lista = File::TraerJson("materias-profesores.json");
        $unlegajo = Profesor::Verificar($legajo);
        $idMateria = Materia::Verificar($id);
        if (Asignacion::AsignacionExiste($asig) && $unlegajo!=false && $idMateria!=false)
        {
            $return = "No se puede asignar el mismo legajo en el mismo turno y materia.";
        }else
        {
            if (File::GuardarJSON("materias-profesores.json",$asig))
            {
                $return=true;
            }
        }
        return $return;
     }

     public static function AsignacionExiste($asig)
     {
        $return = false;
        $lista = File::TraerJson("materias-profesores.json");

        if ($lista==true)
        {
            foreach ($lista as $unaasignacion)
            {
                if ($unaasignacion->legajo == $asig->legajo && $unaasignacion->id == $asig->id && $unaasignacion->turno == $asig->turno)
                {
                    $return = true;
                }
            }
        }
        return $return;
     }

     public static function MostrarMateriasAsignadas()
     {
         $return = false;
         $materias = File::TraerJson("materias-profesores.json");
         $profesores = File::TraerJson("profesores.json");
         if ($materias==true && $profesores==true)
         {
            foreach ($materias as $materia)
            {
                foreach ($profesores as $profe)
                {
                    if ($profe->legajo == $materia->legajo)
                    {
                        $return= "Profesor: {$profe->nombre} dicta la materia con id: {$materia->id}." . $return;
                        //$return=true;
                    }
                }
            }
         }
         return $return;
     }
     
}

?>