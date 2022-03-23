
<?php
/*
Galeano Florencia ♥
Aplicación No 3 (Obtener el valor del medio)
Dadas tres variables numéricas de tipo entero $a, $b y $c realizar una aplicación que muestre
el contenido de aquella variable que contenga el valor que se encuentre en el medio de las tres
variables. De no existir dicho valor, mostrar un mensaje que indique lo sucedido.
Ejemplo 1: $a = 6; $b = 9; $c = 8; => se muestra 8.
Ejemplo 2: $a = 5; $b = 1; $c = 5; => se muestra un mensaje “No hay valor del medio”
*/

$a = 1;
$b = 0;
$c = 3;

if(($a > $b && $b > $c) || ($c > $b && $b > $a)){
  echo $b;
}else if(($b > $a && $a > $c) || ($c > $a && $a > $b)){
  echo $a;
}else if(($b > $c && $c > $a) || ($a > $c && $c > $b)){
  echo $c;
}else{
  echo "No hay un numero que este en el medio";
}


?>