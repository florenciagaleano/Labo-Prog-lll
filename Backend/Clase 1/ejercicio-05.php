<?php
/*
Galeano Florencia ♥
Aplicación No 5 (Números en letras)
Realizar un programa que en base al valor numérico de una variable $num, pueda mostrarse
por pantalla, el nombre del número que tenga dentro escrito con palabras, para los números
entre el 20 y el 60.
Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.
*/

$num = "20";

$resultadoUnidades;
$numStr = strval($num);

switch ($numStr[0]) 
{
    case '2':
        $resultado = "Veinte";
        break;
    case '3':
        $resultado = "Treinta";
        break;
    case '4':
        $resultado = "Cuarenta";
        break;
    case '5':
        $resultado = "Cincuenta";
        break;
    case '6':
        $resultado = "Sesenta";
        break;
}

switch ($numStr[1]) {
        case '1':
            $resultadoUnidades = "y Uno";
            break;
        case '2':
            $resultadoUnidades = "y Dos";
            break;
        case '3':
            $resultadoUnidades = "y Tres";
            break;
        case '4':
            $resultadoUnidades = "y Cuatro";
            break;
        case '5':
            $resultadoUnidades = "y Cinco";
            break;
        case '6':
            $resultadoUnidades = "y Seis";
            break;
        case '7':
            $resultadoUnidades = "y Siete";
            break;
        case '8':
            $resultadoUnidades = "y Ocho";
            break;
        case '9':
            $resultadoUnidades = "y Nueve";
            break;
        default:
        "";
        break;
    }
    if($num == 20)
    {
        $resultado = "Veinte";
    }else if($num == 60){
      $resultado = "Sesenta";
    }
    else if($num < 60 && $num > 20)
    {
        $resultado = $resultado .$resultadoUnidades;
    }else{
      $resultado = "valor fuera de rango";
    }


echo "El resultado es: ", $resultado;

?>