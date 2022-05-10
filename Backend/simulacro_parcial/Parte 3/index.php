<?php

switch($_SERVER['REQUEST_METHOD']){
    case "GET":
        require_once "PizzaCarga.php";
        break;
    case "POST":
        if(isset($_POST['mail'])){
            require_once "AltaVenta.php";
        }else if(isset($_POST['sabor']) && isset($_POST['tipo'])){
            require_once "PizzaConsultar.php";
        }
        else{
            require_once "ConsultaVentas.php";
        }
        
        break;
        

}

?>