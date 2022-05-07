<?php

    require_once 'Pizza.php';

    if(isset($_POST['sabor']) && isset($_POST['tipo'])){
        $sabor = $_POST['sabor'];
        $tipo = $_POST['tipo'];
        
        if(Pizza::existe($sabor,$tipo)){
            echo "Si hay";
        }else{
            echo "No existe tipo o sabor";
        }
    }else{
        echo "falta datos";
    }
?>