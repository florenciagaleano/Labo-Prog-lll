<?php

    require_once "producto.php";

    $arrayProductos = Producto::LeerJson("productos.json");
    $existe = false;

    $codigoDeBarras=$_POST['codigo'];
    $nombre=$_POST['nombre'];
    $tipo=$_POST['tipo'];
    $stock=$_POST['stock'];
    $precio=$_POST['precio'];
    $nuevoProducto=new Producto($codigoDeBarras,$nombre,$tipo,$stock,$precio);
    if($nuevoProducto->existe($arrayProductos)){
        echo "Actualizado";
    }else{
        array_push($arrayProductos,$nuevoProducto);
        echo "Ingresado!";
    }

    Producto::GuardarJSON($arrayProductos);


?>