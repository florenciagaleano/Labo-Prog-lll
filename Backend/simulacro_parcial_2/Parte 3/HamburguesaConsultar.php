<?php

    require_once 'Hamburguesa.php';

    //var_dump(isset($_POST['nombre']));
    if(isset($_POST['nombre']) && isset($_POST['tipo'])){
        $nombre = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        
        if(Hamburguesa::existe($nombre,$tipo)){
            echo "Si hay";
        }else{
            echo "No existe tipo o nombre";
        }
    }else{
        echo "falta datos";
    }
?>