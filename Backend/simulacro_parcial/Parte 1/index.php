<?php

switch($_SERVER['REQUEST_METHOD']){
    case "GET":
        require_once "PizzaCarga.php";
        break;
    case "POST":
        require_once "PizzaConsultar.php";
        break;

}

?>