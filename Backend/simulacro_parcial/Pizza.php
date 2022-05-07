<?php
    require_once "manejador_archivos.php";

    class Pizza{
        public $id;
        public $sabor;
        public $precio;
        public $tipo;
        public $cantidad;
    
        public function __construct($sabor, $precio, $tipo, $cantidad){

            $this->id = manejador_archivos::UltimoId("pizzas.json");
            $this->sabor = $sabor;
            $this->precio = $precio;
            $this->setTipo($tipo);
            $this->cantidad = $cantidad;
        }

        public function setTipo($tipo){
            if(strtolower($tipo) != "molde" && strtolower($tipo) != "piedra"){
                $this->tipo = "molde";
            }else{
                $this->tipo = $tipo;
            }
        }
    
        public function GuardarPizza(){
            $arrayPizzas = manejador_archivos::LeerJson("pizzas.json");
            array_push($arrayPizzas,$this);
            manejador_archivos::GuardarJSON($arrayPizzas,"pizzas.json");
        }

        public static function existe($sabor,$tipo){
            $arrayPizzas = Pizza::LeerJsonPizzas("pizzas.json");
            $existe = false;
            foreach($arrayPizzas as $pizza){
                if($pizza->equals($sabor,$tipo)){
                    return true;
                }
            }

            return false;
        }

        public function equals($sabor,$tipo){
            if($tipo == $this->tipo && $sabor == $this->sabor){
                return true;
            }

            return false;
        }

        //Sí el sabor y tipo ya existen , se actualiza el precio y se suma al stock existente.
        public function actualizar(){
            $arrayPizzas = Pizza::LeerJsonPizzas("pizzas.json");
            $existe = false;

            foreach($arrayPizzas as $pizza){
                if($pizza->equals($this->sabor,$this->tipo)){
                    $pizza->precio = $this->precio;
                    $pizza->cantidad = ((int) $pizza->cantidad) + $this->cantidad;
                    $existe = true;
                    break;
                }
            }

            if(!$existe){
                $this->GuardarPizza();
            }else{
                manejador_archivos::GuardarJSON($arrayPizzas,"pizzas.json");
            }
            return $existe;
            
        }

        public static function LeerJsonPizzas($archivo){
            if(file_exists($archivo)){
                $file = fopen($archivo, "r");
    
                $json = fread($file, filesize($archivo));
                $pizzas = json_decode($json, true);
                $arrayPizzas = array();
                foreach($pizzas as $p){
                    $pizzaAux = new Pizza($p["sabor"],$p["precio"],$p["tipo"],$p["cantidad"]);
                    array_push($arrayPizzas,$pizzaAux);
                }
                fclose($file);
                return $arrayPizzas;
            }else{
                return array();
            }
        }

    }
?>