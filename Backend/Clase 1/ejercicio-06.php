<?php
/*
Galeano Florencia ♥
Aplicación No 6 (Carga aleatoria)
Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
función rand). Mediante una estructura condicional, determinar si el promedio de los números
son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
resultado.
*/

$numeros = array();
$acumulador = 0;
for($i = 0; $i<5; $i++){
    $random = rand(1,100);
    array_push($numeros,$random);
}

if(array_sum($numeros)/5 > 6){
    echo "El prmedio es mayor a 6";
}else if(array_sum($numeros)/5 == 6){
    echo "El prmedio es igual a 6";
}else{
    echo "El prmedio es menor a 6";
}

?>