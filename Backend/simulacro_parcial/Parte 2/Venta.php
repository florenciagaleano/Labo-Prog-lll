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
        

    }
?>