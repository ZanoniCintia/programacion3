<?php

$a=rand(1,15);
$b=rand(2,17);
$c=rand(4,18);
$min=min($a,$b,$c);
$max=max($a,$b,$c);

echo "Los numeros son $a $b $c <br />";

if($a!=$min && $a!=$max)
{ 
    echo "El numero del medio es $a";
}else if($b!=$min && $b!=$max)
{
    echo "El numero del medio es $b";
}else if($c!=$min && $c!=$max)
{
    echo "El numero del medio es $c";
}else
{
    echo "No hay numero del medio";
}




?>