<?php

require_once './auto.php';
require_once './file.php';

$marca = $_GET['marca'];//metodo get trae el valor asignado en la key pasado por parametro [marca]
$color = $_GET['color'];
$fecha = $_GET['fecha'];
$precio = $_GET['precio'];

$auto = new Auto($marca,$color,$fecha,$precio);
//$archivo= ;
$auto->agregarImpuestos(100);

//var_dump($auto);

$metodo = $_SERVER['REQUEST_METHOD'];//retorna la peticion requerida(post , delete, put,get)
switch($metodo)
{
    case 'POST':
        Auto::mostrarAuto($auto);
        
        File::escribirArhivo("./archivos.txt",$auto);
        
    break;
    case 'GET':
        //echo $auto->__toString(). "<br />";
       print_r (Auto::leerAuto());
        
        echo "Entro al Get";
    break;

}



?>