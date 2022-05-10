<?php

switch($_SERVER['REQUEST_METHOD']){
    case "GET":
        require_once "PizzaCarga.php";
        break;
    case "POST":
        if(isset($_POST['mail']) && isset($_POST['cantidad'])){
            require_once "AltaVenta.php";
        }else if(isset($_POST['sabor']) && isset($_POST['tipo']) && !isset($_POST['precio'])){
            require_once "PizzaConsultar.php";
        }else if(isset($_POST['precio'])){//alta de pizza por post
            require_once "PizzaCarga.php";
        }
        else{
            require_once "ConsultaVentas.php";
        }
        
        break;
    case "PUT":
        require_once "ModificarVenta.php";
        break;
    default;
        require_once "borrarVenta.php";
        break;
        

}

?>