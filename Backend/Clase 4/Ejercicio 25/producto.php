<?php
    class Producto{
        public $id;
        public $codigoDeBarras;
        public $nombre;
        public $tipo;
        public $stock;
        public $precio;
        
        public function __construct($codigoDeBarras,$nombre,$tipo,$stock,$precio){
            $this->id=rand(1,10000);
            $this->codigoDeBarras = $codigoDeBarras;
            $this->nombre = $nombre;
            $this->tipo = $tipo;
            $this->stock = $stock;
            $this->precio = $precio;
        }

        public function existe($arrayProductos){
            $existe = false;
            foreach($arrayProductos as $p){
                if($p['codigoDeBarras'] == $this->codigoDeBarras){
                    $existe=true;
                    $this->stock++;
                    break;
                }
            }

            return $existe;
        }

        public static function GuardarJSON($arrayProductos){
            $success = false;
            $filename = "productos.json";
            $file = fopen($filename, "w");
            if ($file) {
                $json = json_encode($arrayProductos, JSON_PRETTY_PRINT);
                fwrite($file, $json);
                $success = true;
            }
    
        }

        public static function LeerJson($archivo="productos.json"){
            if(file_exists($archivo)){
                $file = fopen($archivo, "r");
    
                $json = fread($file, filesize($archivo));
                $users = json_decode($json, true);
                return $users;
            }else{
                return array();
            }
        }

    }

?>