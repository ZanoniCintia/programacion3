<?php

class Auto 
{

    private $_color;
    private $_precio;
    private $_marca;
    private $_fecha;

    //constructor con sobrecarga, se agregan var con valores 
   public function __construct($marca,$color,$fecha=null,$precio=null)
   {    
        $this->_marca=$marca;
        $this->_color=$color;
        $this->_fecha=$fecha;
        $this->_precio=$precio;
        
   }  
 

   public function agregarImpuestos($impuestos)
   {
        if(is_numeric($impuestos))
        {
            $this->_precio += $impuestos;
            return true;
        }
        return false;
   }

   //funcion 
   public function get_color()
   {
       return $this->_color;
   }


    //metodo magico para el get
    public function __get( $name)
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
        return $this->_marca.'*'. $this->_color .'*'.$this->_fecha . '*'.$this->_precio;
    }

    public static function mostrarAuto($auto)
    {   

        echo "Marca : ". $auto->_marca ."<br />";
        echo "Color : ". $auto->_color."<br />";
        echo "Fecha : ". $auto->_fecha ."<br />";
        echo "Precio : ". $auto->_precio ."<br />";
    }

    public static function leerAuto()
    {
        return File::leerArchivo('./archivos.txt');
    
    }

}





?>