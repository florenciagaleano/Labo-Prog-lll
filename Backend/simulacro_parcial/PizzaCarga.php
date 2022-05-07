<?php
    require_once 'Pizza.php';

    if(isset($_GET['sabor']) && isset($_GET['precio']) && 
        isset($_GET['tipo']) && isset($_GET['cantidad'])){

        $sabor = $_GET['sabor'];
        $precio = $_GET['precio'];
        $tipo = $_GET['tipo'];
        $cantidad = $_GET['cantidad'];

        $myPizza = new Pizza($sabor, $precio, $tipo, $cantidad);
        if($myPizza->actualizar()){
            echo "Se actualizaron las pizzas";
        }else{
            echo "Se agrego la pizza";
        }
        /*$myPizza->GuardarPizza();
        echo "Pizza guardada!";*/
        
    }else{
        echo 'Falta al menos un dato';
    }


?>