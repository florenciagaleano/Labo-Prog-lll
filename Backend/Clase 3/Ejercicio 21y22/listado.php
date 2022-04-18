<?php

/*Galeano Florencia
Aplicación No 21 ( Listado CSV y array de usuarios)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,vehículos,...etc),por ahora solo tenemos
usuarios).
En el caso de usuarios carga los datos del archivo usuarios.csv.
se deben cargar los datos en un array de usuarios.
Retorna los datos que contiene ese array en una lista*/

require_once "usuario.php";

$listado = $_GET['listado'];
switch($listado){
    case 'usuarios':
        Usuario::MostrarUsuariosLista(Usuario::LeerCSV("usuarios.csv"));
        break;
    default:
    echo 'hola';

        break;
}



?>