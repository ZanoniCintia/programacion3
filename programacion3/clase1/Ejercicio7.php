<?php

$array=array();


for ($i=1; count($array) <= 9; $i++) 
{ 
    if($i%2!=0)
    {
        $array[$i]=$i;
    }
    echo $array[$i] . "<br />";
}

//print_r( $array);



?>