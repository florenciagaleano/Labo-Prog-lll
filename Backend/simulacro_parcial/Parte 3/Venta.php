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
            //esto rompe
            //return $objetoAccesoDato->ReturnLastIDInserted();
        }

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

        public function Vender(){
            if(Pizza::existeYHayStock($this->sabor,$this->tipo,$this->cantidad)){
                Pizza::actualizarStock($this->sabor,$this->tipo,$this->cantidad);
                $this->GuardarVenta();
                $this->GuardarFoto();
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

        public static function printVentasPorFecha($desde,$hasta){//NO FUNCIONA
            $stringQuery = 'SELECT * FROM VENTA WHERE fecha > :desde AND fecha < :hasta';
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $query = $objetoAccesoDato->RetornarConsulta($stringQuery);
            $query->bindValue(':desde', $desde, PDO::PARAM_STR);
            $query->bindValue(':hasta', $hasta, PDO::PARAM_STR);
            $query->execute();

            var_dump($query->fetch(PDO::FETCH_CLASS));

        }

        public static function printVentasPorSabor($sabor){//NO FUNCIONA
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select sabor_pizza from venta");
			$consulta->execute();			
			$pizzas = $consulta->fetchAll(PDO::FETCH_CLASS, "Venta");
            var_dump($pizzas);
        }


    }
?>