<?php

class Materias
{
    private $_nombre;
    private $_cuatrimestre;
    private $_id;

    public function __construct($nombre,$cuatrimestre,$id)
    {
        $this->_nombre=$nombre;
        $this->cuatrimestre=$cuatrimestre;
        $this->_id=$id;
    }

    public function __get($name)
    {
        if(property_exists($this, $name)) 
        {
            return $this->$name;
        }
    }

    public function __set($name, $value)
    {
        $this->$name= $value;
    }

    public function __toString()
    {
        return $this->_nombre.'*'. $this->_cuatrimestre .'*'. $this->_id ;
    }

    public static function mostrarMateria($materia)
    {
        echo "Nombre : ". $materia->_nombre ."\n";
        echo "Cuatrimestre : ". $materia->_cuatrimestre."\n";
        echo "Id : " . $materia->_id."\n";
    }

    public static function incrementarId($materia)
    {
        return count($materia)+1;
    }


}






?>