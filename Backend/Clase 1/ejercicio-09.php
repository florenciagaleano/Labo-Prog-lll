<?php
/*
Galeano Florencia ♥
Aplicación No 9 (Arrays asociativos)
Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’. Crear, cargar y mostrar tres
lapiceras.
*/

$v[1]=90; $v[30]=7; $v['e']=99; $v['hola']= 'mundo';


$lapicera = array(
	"color" => "azul",
	"marca" => "bic",
	"trazo" => "grueso",
	"precio" => 60,
);

foreach($lapicera as $elemento => $valor){

	echo "$elemento: $valor ";
	echo "<br/>";
}

echo "<br/>";

/////////////////////////////////////////////
$lapicera = array(
	"color" => "rojo",
	"marca" => "bic2",
	"trazo" => "fino",
	"precio" => 100,
);

foreach($lapicera as $elemento => $valor){

	echo "$elemento: $valor ";
	echo "<br/>";
}

echo "<br/>";

/////////////////////////////////////////////
$lapicera = array(
	"color" => "rosa",
	"marca" => "bic3",
	"trazo" => "fino",
	"precio" => 120,
);

foreach($lapicera as $elemento => $valor){

	echo "$elemento: $valor ";
	echo "<br/>";
}

echo "<br/>";

?>