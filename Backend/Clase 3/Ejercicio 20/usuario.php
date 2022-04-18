<?php

/*Aplicación No 20 (Registro CSV)
Archivo: registro.php
método:POST
Recibe los datos del usuario(nombre, clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder hacer el alta,
guardando los datos en usuarios.csv.
retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario*/

class Usuario
{
	public $nombre;
	public $clave;
	public $mail;

	public function __construct($name,$pass,$email)
	{
		$this->nombre=$name;
		$this->clave=$pass;
		$this->mail=$email;
	}

}


?>