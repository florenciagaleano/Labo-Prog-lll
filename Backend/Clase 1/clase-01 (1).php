<h1>App 2</h1>

<?php

/*Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
año es. Utilizar una estructura selectiva múltiple.*/ 
/*GALEANO FLORENCIA */

echo (date('l') . '<br>');
echo (date(DATE_RFC2822) . '<br>');
echo (date('l jS \of F Y h:i:s A') . '<br>');

$mes = date('m');
switch($mes){
    case 1:
    case 2:
    case 3:
        echo 'VERANO' . '<br>';
        break;
    case 4:
    case 5:
        echo 'OTOÑO' . '<br>';
        break;
    case 6:
    case 7:
    case 8:

    case 9:
        echo ('INVIERNO' . '<br>');
        break;
    default:
        echo 'PRIMAVERA <br>';
        break;

}

?>