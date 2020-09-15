<?php

class Cliente
{
    private $_mail;
    private $_clave;

    public function __construct($mail,$clave)
    {
        $this->_mail=$mail;
        $this->_clave=$clave;
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
        return $this->_mail.'*'. $this->_clave ;
    }

    public static function mostrarCliente($cliente)
    {
        echo "Mail : ". $cliente->_mail ."\n";
        echo "Clave : ". $cliente->_clave."\n";
    }


}






?>