<?php
require __DIR__ . '/vendor/autoload.php';
//include './claseSql/Usuario.php';
use \Firebase\JWT\JWT;
use ClaseSql\Usuario;//asi se puede usar el namespace y al instanciar solo poner new Usuario
 
$usuario= new Usuario; // o tambien \ClaseSql\Usuario; asi se llama el namespace


$usuario->nombre='Cintia <br>';

echo $usuario->nombre;

$usuario='root';
$contrasena="";

try 
{
    $conn = new PDO('mysql:host=localhost;dbname=utn', $usuario, $contrasena);
    $query = $conn->query("select * FROM  productos");
    echo "Cantidad de filas" ." ". $query->rowCount().'<br>' ; // cuenta cuantos elementos tiene la tabla

    while($fila=$query->fetch(PDO::FETCH_OBJ)){
        echo $fila->pNombre.'<br>';

    }














    //$producto= $query->fetchAll();
//var_dump($producto);

/*foreach ($producto as $key => $value) {

echo $value['pNombre'].'<br>';
    }*/
} catch (\Throwable $th) 
{
    echo $th;
}


?>