<?php
/**
 * METODOS PHP
 * GET: Obtener recursos
 * POST: Crear recursos
 * PUT: Modificar recursos
 * DELETE: Borrar recursos
 */
include_once './file.php';
include_once './auto.php';


$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];

switch ($path) {
    case '/auto':
        if ($method == 'POST') {
            $patente = $_POST['patente'] ?? '';
            $marca = $_POST['marca'] ?? '';
            $color = $_POST['color'] ?? '';
            $precio = $_POST['precio'] ?? 0;

            $auto = new Auto($patente, $marca, $color, $precio);
            
            //$auto->_marca = 'Fiat';
            echo "<br>";
            echo $auto;
        } else if ($method == 'GET') {
            $patente = $_GET['patente'] ?? '';
            $marca = $_GET['marca'] ?? '';
            $color = $_GET['color'] ?? '';
            $precio = $_GET['precio'] ?? 0;

            $auto = new Auto($patente, $marca, $color, $precio);

            // $auto->_marca = 'Fiat';
            echo "<br>";
            echo $auto;
        } else {
            echo "Metodo no permitido";
        }
    break;
    case 'user':
    break;

    default:
        echo 'Path erroneo';
        
}











 ?>