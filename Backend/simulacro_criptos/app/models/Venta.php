<?php

require_once "Criptomoneda.php";

class Venta
{
    public $id;
    public $cliente;
    public $id_cripto;
    public $cantidad;
    public $fecha;


    public function crearVenta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO venta (fecha, id_cripto, cliente, cantidad) VALUES (:fecha, :id_cripto, :cliente, :cantidad)");
        $consulta->bindValue(':id_cripto', $this->id_cripto, PDO::PARAM_INT);
        var_dump($this->fecha);
        $consulta->bindValue(':fecha',$this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':cliente', $this->id_cripto, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT fecha, id_cripto, cantidad FROM venta");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }

    private function CrearDestino(){
        //var_dump($this->id_cripto);
        $cripto = Criptomoneda::obtenerCriptoPorId($this->id_cripto);
        mkdir("FotosCripto");
        $destino = "FotosCripto/" . $cripto->nombre . $this->cliente . $this->fecha . ".jpg";
        return $destino;
    }

    public function GuardarFoto($foto){
        $mover =  move_uploaded_file($foto, $this->CrearDestino());
        //var_dump($mover);
        if ($mover) {
            return true;
        }
        return false;
        
    }

}

?>