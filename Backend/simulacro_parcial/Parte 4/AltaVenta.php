<?php
    require_once "Venta.php";

    if(isset($_POST['sabor']) && isset($_POST['mail']) && 
        isset($_POST['tipo']) && isset($_POST['cantidad'])){

            if(isset($_FILES['imagen'])){
                $venta = new Venta($_POST['mail'],$_POST['sabor'],$_POST['tipo'],$_POST['cantidad'],$_FILES["imagen"]["tmp_name"]);
                
            }else{
                $venta = new Venta($_POST['mail'],$_POST['sabor'],$_POST['tipo'],$_POST['cantidad']);
            }
            if($venta->Vender()){
                echo "Venta exitosa";
            }else{
                echo "Parece que la pizza no existe o no hay suficiente stock";
            }
        }

        


?>