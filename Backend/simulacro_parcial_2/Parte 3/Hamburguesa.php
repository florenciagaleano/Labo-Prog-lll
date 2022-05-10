<?php
include "manejador_archivos.php";

class Hamburguesa{
    public $id;
    public $nombre;
    public $precio;
    public $tipo;
    public $cantidad;
    //public $foto

    public function __construct($nombre, $precio, $tipo, $cantidad){

        $this->id = manejador_archivos::UltimoId("hamburguesas.json");
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->setTipo($tipo);
        $this->cantidad = $cantidad;
    }

    public function setTipo($tipo){
        if(strtolower($tipo) != "simple" && strtolower($tipo) != "doble"){
            $this->tipo = "simple";
        }else{
            $this->tipo = $tipo;
        }
    }

    public function GuardarHamburguesa(){
        $arrayHamburguesas = manejador_archivos::LeerJson("hamburguesas.json");
        array_push($arrayHamburguesas,$this);
        manejador_archivos::GuardarJSON($arrayHamburguesas,"hamburguesas.json");
    }

    public static function existe($nombre,$tipo){
        $arrayHamburguesas = Hamburguesa::LeerJsonHamburguesas("hamburguesas.json");
        $existe = false;
        foreach($arrayHamburguesas as $h){
            if($h->equals($nombre,$tipo)){
                return true;
            }
        }

        return false;
    }

    public function equals($nombre,$tipo){
        if($tipo == $this->tipo && $nombre == $this->nombre){
            return true;
        }

        return false;
    }

    public function actualizar(){
        $arrayHamburguesas = Hamburguesa::LeerJsonHamburguesas("hamburguesas.json");
        $existe = false;

        foreach($arrayHamburguesas as $burger){
            if($burger->equals($this->nombre,$this->tipo)){
                $burger->precio = $this->precio;
                $burger->cantidad = ((int) $burger->cantidad) + $this->cantidad;
                $existe = true;
                break;
            }
        }

        if(!$existe){
            $this->GuardarHamburguesa();
        }else{
            manejador_archivos::GuardarJSON($arrayHamburguesas,"hamburguesas.json");
        }
        return $existe;
        
    }

    public static function LeerJsonHamburguesas($archivo){
        if(file_exists($archivo)){
            $file = fopen($archivo, "r");

            $json = fread($file, filesize($archivo));
            $hamburguesas = json_decode($json, true);
            $arrayBurger = array();
            foreach($hamburguesas as $h){
                $burgerAux = new Hamburguesa($h["nombre"],$h["precio"],$h["tipo"],$h["cantidad"]);
                array_push($arrayBurger,$burgerAux);
            }
            fclose($file);
            return $arrayBurger;
        }else{
            return array();
        }
    }

    private function CrearDestino(){
        mkdir("ImagenesDeHamburguesas");
        $destino = "ImagenesDeHamburguesas/" . $this->tipo . $this->nombre . ".jpg";
        return $destino;
    }

    public function GuardarFoto($foto){
        if (move_uploaded_file($foto, $this->CrearDestino())) {
            return true;
        }
        return false;
        
    }

    public static function existeYHayStock($nombre,$tipo,$cantidad){
        $arrayHamburguesas = Hamburguesa::LeerJsonhamburguesas("hamburguesas.json");
        $existe = false;
        foreach($arrayHamburguesas as $hamburguesa){
            if($hamburguesa->equals($nombre,$tipo) && (int)$hamburguesa->cantidad >= (int)$cantidad){
                return true;
            }
        }

        return false;
    }

    public static function actualizarStock($nombre,$tipo,$cantidad){
        $arrayHamburguesas = Hamburguesa::LeerJsonHamburguesas("hamburguesas.json");

        foreach($arrayHamburguesas as $pizza){
            if($pizza->equals($nombre,$tipo)){

                $pizza->cantidad -= (int)$cantidad;
                break;
            }
        }

        manejador_archivos::GuardarJSON($arrayHamburguesas,"hamburguesas.json");
        
    }


}




?>