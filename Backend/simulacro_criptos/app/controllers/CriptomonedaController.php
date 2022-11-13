<?php
require_once './models/Criptomoneda.php';
require_once './interfaces/IApiUsable.php';

class CriptomonedaController extends Criptomoneda implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        if($parametros['nombre'] != null && $parametros['nacionalidad'] != null 
          && $parametros['precio'] != null && isset($_FILES['imagen'])){
          $nombre = $parametros['nombre'];
          $nacionalidad = $parametros['nacionalidad'];
          $precio = $parametros['precio'];
  
          $cripto = new Criptomoneda();
          $cripto->nombre = $nombre;
          $cripto->nacionalidad = $nacionalidad;
          $cripto->precio = $precio;
          $cripto->crearCripto();
  
         $cripto->GuardarFoto($_FILES["imagen"]["tmp_name"]);

          $payload = json_encode(array("mensaje" => "Cripto creada con exito"));
    
        }else{
          $payload = json_encode(array("mensaje" => "Faltan campos. No se pudo crear la cripto."));

        }


        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      //var_dump($parametros['nacionalidad']);
      if($parametros['nacionalidad'] != null){
        $lista = Criptomoneda::obtenerCriptosPorNacionalidad($parametros['nacionalidad']);
      }else if($parametros['id'] != null){
        $lista = Criptomoneda::obtenerCriptoPorId($parametros['id']);
      }
      else{
        $lista = Criptomoneda::obtenerTodos();
      }
        $payload = json_encode(array("listaCriptomoneda" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }


    ///////////////////////////////////////////////////////
    public function TraerUno($request, $response, $args)
    {
        return null;
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        Criptomoneda::modificarCriptomoneda($nombre);

        $payload = json_encode(array("mensaje" => "Producto modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $ProductoId = $parametros['ProductoId'];
        Producto::borrarProducto($ProductoId);

        $payload = json_encode(array("mensaje" => "Producto borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
