<?php   

$resultado=0;
$j;

for ($i=0; $resultado+$i<=1000 ; $i++) 
{ 
   $resultado+=$i;
   $j=$i;
}

echo ("La suma es $resultado ") ."<br />";
echo ("Los numeros son:  $j");

?>