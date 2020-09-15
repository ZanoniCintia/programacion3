<?php

$operador;
$op1=rand(1,15);
$op2=rand(1,15);
$resultado;

switch($operador=rand(1,4))
{
    case $operador = 1:
        echo "Suma <br />";
        $resultado = $op1 + $op2;
        echo " $op1 + $op2 = $resultado";
    break;
    case $operador = 2:
        echo "Resta <br />";
        $resultado = $op1 - $op2;
        echo " $op1 - $op2 = $resultado";
    break;
    case $operador = 3:
        echo "Multiplicacion <br />";
        $resultado = $op1 * $op2;
        echo " $op1 * $op2 = $resultado";
    break;
    case $operador = 4:
        echo "Division <br />";
        $resultado = $op1 / $op2;
        echo " $op1 / $op2 = $resultado";
    break;
   
}


?>