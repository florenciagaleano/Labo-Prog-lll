<?php
/*
Galeano Florencia ♥
Aplicación No 10 (Arrays de Arrays)
Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
Arrays de Arrays.
*/


$lapiceraUno = array(
	"color" => "azul",
	"marca" => "bic",
	"trazo" => "grueso",
	"precio" => 60,
);

$lapiceraDos = array(
	"color" => "rojo",
	"marca" => "bic2",
	"trazo" => "fino",
	"precio" => 100,
);

$lapiceraTres = array(
	"color" => "rosa",
	"marca" => "bic3",
	"trazo" => "fino",
	"precio" => 120,
);

$matriz = array($lapiceraUno,$lapiceraDos,$lapiceraTres);

foreach ($matriz as $key => $value) {
	if(is_array($value)){
		foreach ($value as $elemento => $valor){
			echo "$elemento: $valor ";
			echo "</br>";
		}

		echo '</br>';
	}
}

?>