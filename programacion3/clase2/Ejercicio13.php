<?php



function RecibePalabraYmax($palabra,$max)
{

    if(strlen($palabra)<$max && ($palabra="Recuperatorio" || $palabra="Parcial" || $palabra="Programacion"))
    {

        return 1;
  
    }else
    {
        return 0;
    }

}

echo RecibePalabraYmax("Recuperatorio", 4);
echo RecibePalabraYmax("Hola",3);
echo RecibePalabraYmax("Parcial",20);

//strcmp no funciono!!!

?>