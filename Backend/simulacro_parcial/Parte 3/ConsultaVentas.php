<?php
    require_once 'Venta.php';
    Venta::printCantidadVendidas();

    //hay q pasar las fechas con formato aaaa-mm-dd
    if(isset($_POST['desde']) && isset($_POST['hasta'])){
        Venta::printVentasPorFecha($_POST['desde'],$_POST['hasta']);
    }

    if(isset($_POST['usuarioMail'])){
        
    }

    if(isset($_POST['sabor'])){
        Venta::printVentasPorSabor($_POST['sabor']);
    }
?>