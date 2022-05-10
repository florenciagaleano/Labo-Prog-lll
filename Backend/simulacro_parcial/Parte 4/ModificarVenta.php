<?php
    require_once 'Venta.php';
    parse_str(file_get_contents("php://input"),$put_vars);
    var_dump($put_vars["pedido"]);


    if(isset($put_vars['pedido']) && isset($put_vars['mail']) && isset($put_vars['tipo']) && isset($put_vars['cantidad']) && isset($put_vars['sabor'])){
            if(Venta::ModificarVenta($put_vars['mail'],$put_vars['sabor'],$put_vars['tipo'],$put_vars['cantidad'],$put_vars['pedido']) > 0){
                echo "Modificacion exitosa";
            }else{
                echo "No se encontro el numero de pedido para modificar";
            }
        }else{
            echo "Fatlan datos";
        }
?>