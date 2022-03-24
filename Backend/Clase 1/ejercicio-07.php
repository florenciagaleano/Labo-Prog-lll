<?php
/*
Galeano Florencia ♥
Aplicación No 7 (Mostrar impares)
Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números utilizando
las estructuras while y foreach.
*/

$impares = array();

for($i = 0; $i < 10*2; $i++){
    if(($i+1) % 2 == 0){
        array_push($impares,$i);
    }
}

foreach($impares as $impar){
    echo $impar;
    echo '<br/>';
}

?>