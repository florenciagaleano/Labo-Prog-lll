<?php
    require_once 'Venta.php';
    parse_str(file_get_contents("php://input"),$put_vars);


    if(isset($put_vars['pedido'])){
            //Venta::MoverFotoBorrada(Venta::RecuperarNombreFoto($pedido));
            if(Venta::EliminarVenta($put_vars['pedido']) > 0){
                echo "Eliminacion exitosa";
            }else{
                echo "No se encontro el numero de pedido para eliminar";
            }
        }else{
            echo "Falta nro de pedido";
        }
?>