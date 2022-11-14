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

    public function TraerPorNombre($request, $response, $args)
    {
      
      $crypto_nombre = $args['nombre'];
      $parametros = $request->getParsedBody();
      //var_dump(isset($_GET['id']));
        $lista = Criptomoneda::obtenerCriptoPorNombre($crypto_nombre);

        $payload = json_encode(array("listaCriptomoneda" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
      $params = $request->getParsedBody();
      parse_str(file_get_contents("php://input"),$put_vars);
      
      $id = $args['id'];
      //var_dump($id);

      //usar form-urlencoded
      if (isset($id)) {
          $crypto_id = $id;
          //var_dump($crypto_id);
          $cripto = Criptomoneda::obtenerCriptoPorId($crypto_id);
          //var_dump($put_vars['nombre']);
          // Gets the new data
          $nombre = $put_vars['nombre'];
          $nacionalidad = $put_vars['nacionalidad'];
          $precio = $put_vars['precio'];
          
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
      $crypto_id = intval($args['id']);
      var_dump($args['id']);
      $cripto = Criptomoneda::obtenerCriptoPorId($crypto_id);
      if (Criptomoneda::EliminarCripto($crypto_id) > 0) {
        $payload = json_encode(array("mensaje" => "Cripto eliminada con exito"));
      } else {
        $payload = json_encode(array("mensaje" => "No se puede liminar la cripto"));
      }

      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
  }
}
