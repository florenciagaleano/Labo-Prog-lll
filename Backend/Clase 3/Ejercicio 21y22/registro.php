<?php

/*Recibe los datos del usuario(nombre, clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder hacer el alta,
guardando los datos en usuarios.csv.
retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario*/

require_once "manejador_archivos.php";
require_once "usuario.php";

$nombre = $_POST['nombre'];
$clave = $_POST['clave'];
$mail = $_POST['mail'];
$user = new Usuario($nombre,$clave,$mail);
var_dump($user);
/*if(ManejadorArchivos::GuardarUsuario($user)){
    echo "Ok";
}else{
    echo "Error";
}*/

//GUARDAR JSON
Usuario::GuardarJSON($user);


?>