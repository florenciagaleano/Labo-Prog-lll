<?php
require_once './models/Criptomoneda.php';
require_once './interfaces/IApiUsable.php';

class CriptomonedaController extends Criptomoneda
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
      //var_dump(isset($_GET['id']));

        $lista = Criptomoneda::obtenerTodos();
      
        $payload = json_encode(array("listaCriptomoneda" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerPorNacionalidad($request, $response, $args)
    {
      
      $crypto_id = $args['nacionalidad'];
      $parametros = $request->getParsedBody();
      //var_dump(isset($_GET['id']));
        $lista = Criptomoneda::obtenerCriptosPorNacionalidad($crypto_id);

        $payload = json_encode(array("listaCriptomoneda" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerPorId($request, $response, $args)
    {
      
      $crypto_id = $args['id'];
      $parametros = $request->getParsedBody();
      //var_dump(isset($_GET['id']));
        $lista = Criptomoneda::obtenerCriptoPorId($crypto_id);

        $payload = json_encode(array("listaCriptomoneda" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    
    public function ModificarUno($request, $response, $args)
    {

      $params = $request->getParsedBody();
      
      $id = $args['id'];
      var_dump($id);


      if (isset($id)) {
          $crypto_id = $id;
          var_dump($crypto_id);
          $cripto = Criptomoneda::obtenerCriptoPorId($crypto_id);
          
          // Gets the new data
          $nombre = $params['nombre'];
          $nacionalidad = $params['nacionalidad'];
          $precio = $params['precio'];
          
          $nombre != null ? $cripto->nombre = $nombre : $cripto->nombre = $cripto->nombre;
          $nacionalidad != null ? $cripto->nacionalidad = $nacionalidad : $cripto->nacionalidad = $cripto->nacionalidad;
          $precio != null ? $cripto->precio = $precio : $cripto->precio = $cripto->precio;

          if (Criptomoneda::ModificarCripto($nombre,$precio,$nacionalidad,$id) > 0) {

            $payload = json_encode(array("mensaje" => "Cripto modificada con exito"));
          }else{
            $payload = json_encode(array("mensaje" => "No se pudo realizar la modificacion."));
          }
      }else{
          $payload = json_encode(array("error" => "Ingrese id de criptomoneda"));
      }
      
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
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
