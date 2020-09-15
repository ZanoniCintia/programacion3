<?php

$array=array();
$promedio=0;


for ($i=0; $i < 5; $i++) 
{ 
    $array[$i]= rand(1,10);
    $promedio+=$array[$i];
}
var_dump($array);
echo "<br /> El promedio es" .$promedio/5;
?>