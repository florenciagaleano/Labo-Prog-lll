<?php

require_once "Auto.php";
/*
Galeano Florencia ♥
Aplicación No 17 (Auto)
Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);
En testAuto.php:

● Crear dos objetos “Auto” de la misma marca y distinto color.
● Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
● Crear un objeto “Auto” utilizando la sobrecarga restante.
● Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500
al atributo precio.
● Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el
resultado obtenido.
● Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o
no.
● Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3,
5)
*/

$auto1 = new Auto("Fiat","Rojo");
$auto2 = new Auto("Fiat","Gris");
$auto3 = new Auto("Ford","Negro",1500);
$auto4 = new Auto("Ford","Negro",300000);
$auto5 = new Auto("Honda","Rosa",5000000,5/5/2023);

$auto3->AgregarImpuestos(1500);
$auto4->AgregarImpuestos(1500);
$auto5->AgregarImpuestos(1500);

echo Auto::Add($auto1,$auto2);
echo '</br>';
if($auto1->Equals($auto5)){
    echo "Auto 1 y Auto 5 son iguales";
}else{
    echo "Auto 1 y Auto 5 no son iguales";
}


?>

