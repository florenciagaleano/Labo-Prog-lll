
<?php
/*
Galeano Florencia ♥
Aplicación No 1 (Sumar números)
Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no
supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
se sumaron.
*/


$acumulador = 0;
$contador = 0;

do{
  $contador++;
    echo($contador . '<br>');
    $acumulador += $contador;
}while($acumulador <= 1000);

echo("se sumaron {$contador}");

?>