<?php

switch($_SERVER['REQUEST_METHOD']){
    case "GET":
        
    case "POST":
         if(isset($_POST['precio'])){
            require_once "HamburguesaCarga.php";
         }else{
             
         }
        break;

}



?>