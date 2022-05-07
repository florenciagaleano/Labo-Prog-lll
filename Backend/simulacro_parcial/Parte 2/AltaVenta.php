<?php
    require_once "Venta.php";

    if(isset($_POST['sabor']) && isset($_POST['mail']) && 
        isset($_POST['tipo']) && isset($_POST['cantidad'])){

            $venta = new Venta($_POST['mail'],$_POST['sabor'],$_POST['tipo'],$_POST['cantidad']);
            if($venta->Vender()){
                echo "Venta exitosa";
            }else{
                echo "Parece que la pizza no existe o no hay suficiente stock";
            }
        }

        


?>