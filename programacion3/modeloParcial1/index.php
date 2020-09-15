<?php

require_once './cliente.php';
require_once './archivos.php';
require_once './profesor.php';
require_once './materias.php';


$mail;
$clave;
$cliente;
$arrayMateria=array();
$id;


$path = $_SERVER['PATH_INFO'];
$metodo = $_SERVER['REQUEST_METHOD'];//retorna la peticion requerida(post , delete, put,get)

switch($path)
{
    case '/cliente':
        switch($metodo)
        {
            case 'POST':
                $mail = $_GET['mail'];
                $clave = $_GET['clave'];
                $cliente= new cliente($mail,$clave);
                File::escribirArhivo("./users.txt",$cliente);
                echo Cliente::mostrarCliente($cliente);
            break;
            case 'GET':
                echo "hola";
            break;
        }
    break;
    case '/materias':
        switch($metodo)
        {
            case 'POST':
                $nombre = $_GET['nombre'];
                $cuatrimestre = $_GET['cuatrimestre'];
                $id = Materias::incrementarId($arrayMateria);

                $materia = new Materias($nombre,$cuatrimestre,$id);
                
                array_push($arrayMateria,$materia);
                File::escribirArhivo("./materias.txt",$materia);
                echo Materias::mostrarMateria($materia);
            break;
            case 'GET':
                echo "entro";
            break;
        }

        
        
 

}




?>