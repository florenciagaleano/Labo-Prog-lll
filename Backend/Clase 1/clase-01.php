<h1>App 1</h1>

<?php

$acumulador = 0;
$contador = 1;

do{
    echo($acumulador . '<br>');
    $acumulador += $contador;
    echo($contador++ . '<br>');
}while($acumulador <= 1000);



?>