<?php
    require_once 'Pizza.php';

    if(isset($_POST['sabor']) && isset($_POST['precio']) && 
        isset($_POST['tipo']) && isset($_POST['cantidad'])){

        $sabor = $_POST['sabor'];
        $precio = $_POST['precio'];
        $tipo = $_POST['tipo'];
        $cantidad = $_POST['cantidad'];

        if(isset($_FILES['imagen'])){
            $myPizza = new Pizza($sabor, $precio, $tipo, $cantidad,$_FILES["imagen"]["tmp_name"]);
        }else{
            $myPizza = new Pizza($sabor, $precio, $tipo, $cantidad);
        }

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