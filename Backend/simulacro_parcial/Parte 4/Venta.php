<?php
    require_once "AccesoDatos.php";
    require_once "Pizza.php";

    class Venta{
        public $mail;
        public $sabor;
        public $tipo;
        public $cantidad;
        public $foto;

        public function __construct($mail,$sabor,$tipo,$cantidad,$foto = null)
        {
            $this->mail =$mail;
            $this->sabor =$sabor;
            $this->tipo =$tipo;
            $this->cantidad =$cantidad;
            $this->foto = $foto;
        }

        //GUARDAR EN DB
        public function GuardarVenta(){
            $stringQuery = 'INSERT INTO venta (mail, sabor_pizza, tipo_pizza, cantidad_pizza, pedido, fecha) VALUES (:mail, :sabor_pizza, :tipo_pizza, :cantidad_pizza, :pedido, :fecha)';
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $query = $objetoAccesoDato->RetornarConsulta($stringQuery);
            $query->bindValue(':mail', $this->mail, PDO::PARAM_STR);
            $query->bindValue(':sabor_pizza', $this->sabor, PDO::PARAM_STR);
            $query->bindValue(':tipo_pizza', $this->tipo, PDO::PARAM_STR);
            $query->bindValue(':cantidad_pizza', $this->cantidad, PDO::PARAM_INT);
            $query->bindValue(':pedido', rand(1,1000), PDO::PARAM_INT);
            $query->bindValue(':fecha',(new DateTime('now'))->format('Y-m-d'), PDO::PARAM_STR);

            $query->execute();
        }

        public function Vender(){
            if(Pizza::existeYHayStock($this->sabor,$this->tipo,$this->cantidad)){
                Pizza::actualizarStock($this->sabor,$this->tipo,$this->cantidad);
                $this->GuardarVenta();
                $this->GuardarFoto();
                return true;
            }

            return false;
        }

        //SUBIR FOTOS
        private function CrearDestino(){
            mkdir("ImagenesDeLaVenta");
            $mail = explode('@',$this->mail);
            $destino = "ImagenesDeLaVenta/" . $this->tipo . $this->sabor . $mail[0] . date('Y-m-d') . ".jpg";
            return $destino;
        }

        public function GuardarFoto(){
            if (move_uploaded_file($this->foto, $this->CrearDestino())) {
                return true;
            }
            return false;
            
        }
        
        /////   CONSULTAS   /////
        public static function printCantidadVendidas(){//ANDA OK
            //select SUM(cantidad_pizza) from venta;
            $stringQuery = 'SELECT SUM(v.cantidad_pizza) AS Pizzas_Vendidas FROM venta AS v';
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $query = $objetoAccesoDato->RetornarConsulta($stringQuery);
            $query->execute();
            echo 'Pizzas Vendidas: '.$query->fetch(PDO::FETCH_ASSOC)['Pizzas_Vendidas'].' unidades';
        }

        public static function printVentasPorFecha($desde,$hasta){//CONSULTA OK
            $stringQuery = 'SELECT * FROM VENTA WHERE fecha > :desde AND fecha < :hasta';
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $query = $objetoAccesoDato->RetornarConsulta($stringQuery);
            $query->bindValue(':desde', $desde, PDO::PARAM_STR);
            $query->bindValue(':hasta', $hasta, PDO::PARAM_STR);
            $query->execute();

            while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                $pizzas []= $fila;
            }

            var_dump($pizzas);

        }

        public static function printVentasPorSabor($sabor){//CONSULTA OK
            var_dump($sabor);

            $stringQuery = 'SELECT * FROM venta WHERE sabor_pizza = :sabor ORDER BY fecha;';
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $query = $objetoAccesoDato->RetornarConsulta($stringQuery);
            $query->bindValue(':sabor', $sabor, PDO::PARAM_STR);
            //var_dump($sabor);

            $query->execute();
            //var_dump($sabor);

            while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                $pizzas []= $fila;
            }

            var_dump($pizzas);
        }

        public static function printVentasPorUsuario($mail){//CONSULTA OK

            var_dump($mail);

            $stringQuery = 'SELECT * FROM venta WHERE mail = :mail;';
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $query = $objetoAccesoDato->RetornarConsulta($stringQuery);
            $query->bindValue(':mail', $mail, PDO::PARAM_STR);
            //var_dump($sabor);

            $query->execute();
            //var_dump($sabor);

            while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                $pizzas []= $fila;
            }

            var_dump($pizzas);
        }

        //MODIFICAR VENTA
        public static function ModificarVenta($mail,$sabor,$tipo,$cantidad,$pedido)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE venta SET sabor_pizza=:sabor,tipo_pizza=:tipo,cantidad_pizza=:cantidad,mail=:mail WHERE pedido=:pedido");
            $consulta->bindValue(':sabor',$sabor, PDO::PARAM_STR);
            $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
            $consulta->bindValue(':cantidad',$cantidad, PDO::PARAM_INT);
            $consulta->bindValue(':pedido',(int)$pedido, PDO::PARAM_INT);
            $consulta->bindValue(':mail',$mail, PDO::PARAM_STR);
            $consulta->execute(); 
            //echo $consulta->rowCount();
            return $consulta->rowCount();
        }

        //ELIMINAR VENTA
        public static function EliminarVenta($pedido)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM venta WHERE pedido=:pedido");
            echo "hola";
            $consulta->bindValue(':pedido',(int)$pedido, PDO::PARAM_INT);
            echo "hola";
            $consulta->execute(); 
            echo "hola";
            //echo $consulta->rowCount();
            return $consulta->rowCount();
        }

        public static function RecuperarNombreFoto($pedido){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT tipo_pizza,sabor_pizza,mail FROM venta WHERE pedido=:pedido");
            $consulta->bindValue(':pedido',(int)$pedido, PDO::PARAM_INT);
            $consulta->execute(); 
            return $consulta->fetchObject('Venta');
        }

        public static function MoverFotoBorrada($nombre){
            mkdir("BACKUPVENTAS");
            $origen = "ImagenesDeLaVenta/" . $nombre;
            var_dump($origen);
            move_uploaded_file($origen,"BAKUPVENTAS/".$nombre);
        }

    }
?>