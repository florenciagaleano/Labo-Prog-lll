<?php

/*Recibe los datos del usuario(clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder verificar si es un usuario registrado,
Retorna un :
“Verificado” si el usuario existe y coincide la clave también.
“Error en los datos” si esta mal la clave.
“Usuario no registrado si no coincide el mail“
Hacer los métodos necesarios en la clase usuario*/

require_once "usuario.php";

$nombre = $_POST['nombre'];
$clave = $_POST['clave'];
$mail = $_POST['mail'];
$user = new Usuario($nombre,$clave,$mail);
var_dump($user);
Usuario::Login($nombre,$clave,$mail);


?>