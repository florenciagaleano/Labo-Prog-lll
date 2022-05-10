<?php

require_once 'Hamburguesa.php';

    if(isset($_POST['nombre']) && isset($_POST['precio']) && 
        isset($_POST['tipo']) && isset($_POST['cantidad'])){
        $nuevaHamburguesa = new Hamburguesa($_POST['nombre'],$_POST['precio'],$_POST['tipo'],$_POST['cantidad']);
        $nuevaHamburguesa->actualizar();
        if(isset($_FILES['imagen'])){
            $nuevaHamburguesa->GuardarFoto($_FILES["imagen"]["tmp_name"]);
        }
    }



?>