<?php

/*
Galeano Florencia ♥
Aplicación No 12 (Invertir palabra)
Realizar el desarrollo de una función que reciba un Array de caracteres y que invierta el orden
de las letras del Array.
Ejemplo: Se recibe la palabra “HOLA” y luego queda “ALOH”.
*/
$array = array('H','O','L','A');


function DarVueltaArray($array)
{
    $array2;
    $j = 0;
    //$array2 = array_reverse($array);
    for($i = count($array) -1; $i >= 0; $i--){
        $array2[$j] = $array[$i];
        $j++;
    }

    return $array2;
}
$arrayMostrar = DarVueltaArray($array);

foreach($arrayMostrar as $key=>$item){
    echo($item);
}

?>

