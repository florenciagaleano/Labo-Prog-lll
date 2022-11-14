<?php

class Criptomoneda
{
    public $id;
    public $nombre;
    public $precio;
    public $nacionalidad;


    public function crearCripto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO criptomoneda (nombre, precio, nacionalidad) VALUES (:nombre, :precio, :nacionalidad)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, precio, nacionalidad FROM criptomoneda");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Criptomoneda');
    }

    public static function obtenerCriptosPorNacionalidad($nacionalidad){//CONSULTA OK
        //var_dump($nacionalidad);

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM criptomoneda WHERE nacionalidad = :nacionalidad");
        $consulta->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_STR);
        //var_dump($nacionalidad);

        $consulta->execute();
        //var_dump($nacionalidad);

        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $criptos []= $fila;
        }

        return $criptos;
    }

    public static function obtenerCriptoPorId($id){//CONSULTA OK
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, precio, nacionalidad FROM criptomoneda WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Criptomoneda');
    }

    private function CrearDestino(){
        mkdir("Criptomonedas");
        $destino = "Criptomonedas/" . $this->nombre . ".jpg";
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

    public static function ModificarCripto($nombre,$precio,$nacionalidad,$id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta =$objAccesoDatos->RetornarConsulta("UPDATE criptomoneda SET nombre=:nombre,precio=:precio,nacionalidad=:nacionalidad WHERE id=:id");
        $consulta->bindValue(':nombre',$nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio',$precio, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad',$nacionalidad, PDO::PARAM_INT);
        $consulta->bindValue(':id',(int)$id, PDO::PARAM_INT);
        $consulta->execute(); 
        //echo $consulta->rowCount();
        return $consulta->rowCount();
    }

}

?>