<?php
    require_once "AccesoDatos.php";
    require_once "Pizza.php";

    class Venta{
        public $mail;
        public $nombre;
        public $tipo;
        public $cantidad;
        public $foto;

        public function __construct($mail,$nombre,$tipo,$cantidad,$foto = null)
        {
            $this->mail =$mail;
            $this->nombre =$nombre;
            $this->tipo =$tipo;
            $this->cantidad =$cantidad;
            $this->foto = $foto;
        }

        public function GuardarVenta(){
            $stringQuery = 'INSERT INTO venta (mail, nombre_hamburguesa, tipo_hamburguesa, cantidad_hamburguesa, pedido, fecha) VALUES (:mail, :nombre_hamburguesa, :tipo_hamburguesa, :cantidad_hamburguesa, :pedido, :fecha)';
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $query = $objetoAccesoDato->RetornarConsulta($stringQuery);
            $query->bindValue(':mail', $this->mail, PDO::PARAM_STR);
            $query->bindValue(':nombre_hamburguesa', $this->nombre, PDO::PARAM_STR);
            $query->bindValue(':tipo_hamburguesa', $this->tipo, PDO::PARAM_STR);
            $query->bindValue(':cantidad_hamburguesa', $this->cantidad, PDO::PARAM_INT);
            $query->bindValue(':pedido', rand(1,1000), PDO::PARAM_INT);
            $query->bindValue(':fecha',(new DateTime('now'))->format('Y-m-d'), PDO::PARAM_STR);

            $query->execute();

        }

        public function Vender(){
            if(Hamburguesa::existeYHayStock($this->nombre,$this->tipo,$this->cantidad)){
                Hamburguesa::actualizarStock($this->nombre,$this->tipo,$this->cantidad);
                $this->GuardarVenta();
                if($this->foto != null){
                    $this->GuardarFoto();
                }
                return true;
            }

            return false;
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

        //CONSULTAS
    }
?>