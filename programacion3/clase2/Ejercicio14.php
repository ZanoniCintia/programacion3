<?php

function esPar($numero)
{
    if($numero %2==0)
    {
        return true;
    }else{

        return false;
    }
  
}

function esImpar($numero)
{
    return !esPar($numero);
}


echo esPar(4);
echo esPar(3);
echo esImpar(3);
echo esImpar(4);
//preguntar porq no sale cero si es false

?>