<?php

class FigurasGeometricas
{

    private $_color;
    private $_perimetro;
    private $_superficie;

    public function __construct($color,$perimetro,$superficie)
    {
        $this->_color=$color;
        $this->_perimetro=$perimetro;
        $this->_superficie=$superficie;
    }

    public function get_color()
    {
        return $this->_color;
    }

    public function set_color($value)
    {
        $this->_color = $value;
    }

    public  function  __ToString()
    {
        
    }



}






?>