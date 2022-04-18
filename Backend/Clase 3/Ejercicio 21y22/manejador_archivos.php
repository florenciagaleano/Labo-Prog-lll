<?php

require "usuario.php";
/*Aplicación No 20 (Registro CSV)
Archivo: registro.php
método:POST
Recibe los datos del usuario(nombre, clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder hacer el alta,
guardando los datos en usuarios.csv.
retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario*/

class ManejadorArchivos
{


    public static function GuardarUsuario($usuario){
        $miArchivo = fopen("usuarios.csv","a");
        if(file_exists("usuarios.csv")){
            fwrite($miArchivo,ManejadorArchivos::ConvertToCSV($usuario));
            fclose($miArchivo);
            return true;
        }

        return false;
    }

    public static function ConvertToCSV($usuario){
        return "$usuario->nombre,$usuario->clave,$usuario->mail,$usuario->id,$usuario->fechaRegistro\n";
    }

    public static function LeerCSV($archivo){
        $file = fopen($archivo, "r");
        $archivoDevolver=null;
        while(!feof($file)){
            $archivoDevolver = fgets($file);
        }

        fclose($file);
    }

}


?>