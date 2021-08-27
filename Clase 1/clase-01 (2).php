<h1>App 3</h1>

<?php

    /*(Obtener el valor del medio)*/ 
    /*GALEANO FLORENCIA */
    $a = 0;
    $b = 10;
    $c = 10;

    if($c < $b && $a < $c || $c < $a && $b < $c)
    {
        echo $c;

    } else if($a < $b && $c < $a || $a < $c && $b < $a)
    {
        echo $a;
    }
    else if($b < $c && $a < $b || $b < $a && $c < $b)
    {
        echo $b;
    }
    else
    {
        echo "No hay valor en el medio";
    }

?>