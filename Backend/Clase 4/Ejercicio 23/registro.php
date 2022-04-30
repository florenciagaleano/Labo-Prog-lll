<?php

/*Galeano Florencia
Recibe los datos del usuario(nombre, clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder hacer el alta,
guardando los datos en usuarios.csv.
retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario*/

require_once "usuario.php";

$nombre = $_POST['nombre'];
$clave = $_POST['clave'];
$mail = $_POST['mail'];
$archivo = $_FILES["archivo"]["name"];

if($_SERVER["REQUEST_METHOD"] != "POST"){
    echo "peticion no valida";
    exit;
}

$user = new Usuario($nombre,$clave,$mail,$archivo);

$myArray = Usuario::LeerJSON("usuarios.json");
array_push($myArray, $user);
Usuario::GuardarJSON($myArray);

//$destino = "fotos".__DIR__. $_FILES["archivo"]["name"];
mkdir("fotos");
$destino = "fotos/" . $_FILES["archivo"]["name"];

if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)) {
    echo "<br/>El archivo ". basename( $_FILES["archivo"]["name"]). " ha sido subido exitosamente.";
} else {
    echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
}


?>