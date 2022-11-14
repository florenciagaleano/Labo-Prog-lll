<?php
require_once './models/Venta.php';
require_once './interfaces/IApiUsable.php';

class VentaController extends Venta implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $cripto_id = $parametros['cripto_id'];
        $cantidad = $parametros['cantidad'];
        $nombre_cliente = $parametros['nombre_cliente'];
        $fecha = (new DateTime('now'))->format('Y-m-d');

        if($cripto_id != null && $cantidad != null && $nombre_cliente != null && isset($_FILES['imagen'])){

        $venta = new Venta();
        $venta->id_cripto = $cripto_id;
        $venta->cantidad = $cantidad;
        $venta->cliente = $nombre_cliente;
        $venta->fecha = $fecha;
        $venta->crearVenta();
        $venta->GuardarFoto($_FILES["imagen"]["tmp_name"]);


        $payload = json_encode(array("mensaje" => "Venta creada con exito"));
      }else{
        $payload = json_encode(array("mensaje" => "Faltan campos. No se pudo crear la venta."));

      }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        return null;
    }

    public function TraerTodos($request, $response, $args)
    {
      //var_dump(isset($_GET["alemanas_junio"]));
      if(isset($_GET["alemanas_junio"])){
        $lista = Venta::obtenerAlemanasJunio();
      }else{
        $lista = Venta::obtenerTodos();
      }
        $payload = json_encode(array("listaVenta" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerVentasAlemanasJunio($request, $response, $args)
    {
        $lista = Venta::obtenerAlemanasJunio();
        $payload = json_encode(array("listaVenta" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        Venta::modificarPedido($nombre);

        $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $PedidoId = $parametros['PedidoId'];
        Pedido::borrarPedido($PedidoId);

        $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
