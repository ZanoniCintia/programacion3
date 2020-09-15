<?php
class File
{ 
    
public $archivo;
public static function escribirArhivo($archivo,$datos)
{
    $file = fopen($archivo,'a');//recibe nombre del archivo a abrir y modo de apertura devuelve entero
    $rta= fwrite($file,$datos . PHP_EOL);
    fclose($file) . "<br />";

}


public static function leerArchivo($archivo)
{
    $file = fopen($archivo,'r');

    $array = array();

    while (!feof($file))
    {
        $rta= fgets($file);
        $explode=explode("*",$rta);
        //var_dump($explode);
        if (count($explode)  > 1) 
        {
            array_push($array, $explode);
        }
    }
    
    fclose($file);
    return $array;
}







}


?>