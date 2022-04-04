<?php

class Auto{
    private string $_color;
    private float $_precio;
    private string $_marca;
    private DateTime $_fecha;

    public function __construct($marca,$color,$precio = 0,$fecha = null){
        $this->color = $color;
        $this->precio = $precio;
        $this->marca = $marca;
        $this->fecha = $fecha;
    }

    public function AgregarImpuestos($precioAgregar) {
        $this->precio += $precioAgregar;
    }

    static function MostrarAuto($auto){
        echo $auto->color;
        echo $auto->precio;
        echo $auto->marca;
        echo $auto->fecha;
    }

    function Equals($auto2){
        if($this->marca == $auto2->marca){
            return true;
        }
        return false;
    }

    public static function Add($auto1,$auto2){
        if($auto1->Equals($auto2) && $auto1->color == $auto2->color){
            return $auto1->precio + $auto2->precio;
        }

        return 0;
    }
}

?>