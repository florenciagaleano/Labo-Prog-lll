
<?php
/*
Galeano Florencia ♥
Aplicación No 2 (Mostrar fecha y estación)
Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
año es. Utilizar una estructura selectiva múltiple.
*/

echo date("d F a");
echo "<br>";
echo date("d F a");
echo "<br>";
echo date("j m A");
echo "<br>";
echo date("D M G");
echo "<br>";
echo date("l n H");

switch(date("n")){
  case 12:
  case 1:
  case 2:
    echo "Estamos en verano!";
    break;
  case 3:
  case 4:
  case 5:
    echo "Estamos en otoño!";
    break;
  case 6:
  case 7:
  case 8:
    echo "Estamos en invierno!";
    break;
  default:
    echo "Estamos en primavera!";
    break;
}

?>