<?php

class Venta
{
    public $id;
    public $cliente;
    public $id_cripto;


    public function crearVenta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO venta (fecha, id_cripto, cliente) VALUES (:fecha, :id_cripto, :cliente)");
        $consulta->bindValue(':id_cripto', $this->id_cripto, PDO::PARAM_INT);
        $consulta->bindValue(':fecha',(new DateTime('now'))->format('Y-m-d'), PDO::PARAM_STR);
        $consulta->bindValue(':cliente', $this->id_cripto, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT fecha, id_cripto FROM venta");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
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
        //var_dump($nacionalidad);

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM criptomoneda WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        //var_dump($nacionalidad);

        $consulta->execute();
        //var_dump($nacionalidad);

        while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $criptos []= $fila;
        }

        return $criptos;
    }

}

?>