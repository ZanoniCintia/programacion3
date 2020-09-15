<?php

$num=rand(20,60);
$formateado=new NumberFormatter('es', NumberFormatter::SPELLOUT);
echo ("El numero es : $num y se escribe:". $formateado->format($num));



?>