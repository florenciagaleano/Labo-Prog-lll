
<?php

class Garage{
    private string $_razonSocial;
    private float $_hora;
    private $_autos;

    public function __construct($razonSocial, $precio = 0)
    {
        $this->_razonSocial=$razonSocial;
        $this->_hora = $precio;
    }

    function MostrarGarage(){
        echo $this->_razonSocial;
        echo $this->_hora;
        foreach($this->_autos as $auto){
            Auto::MostrarAuto($auto);
        }
    }

    function Equals($auto){
        return in_array($auto,$this->_autos,true);
    }

    function Add($auto){
        if(!$this->Equals($auto)){
            array_push($auto);
        }
        return null;
    }

    /**Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Remove($autoUno); */

    function Remove($auto){
        foreach($this->_autos as $key=> $autoF){
            if($autoF->Equals($auto)){
                $this->_autos[$key] = null;
            }
        }
    }
}

?>