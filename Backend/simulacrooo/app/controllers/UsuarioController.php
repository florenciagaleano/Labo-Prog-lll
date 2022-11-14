<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';
require_once './middlewares/AutentificadorJWT.php';

class UsuarioController extends Usuario implements IApiUsable
{
    public function Login($request, $response, $args) {
      $parametros = $request->getParsedBody();
      $mail =  $parametros['mail'];
      $clave =  $parametros['clave'];

      if (isset($mail) && isset($clave)) {
        $usuario = Usuario::obtenerUsuarioPorMail($mail);

        if (!empty($usuario) && ($mail == $usuario->mail) && ($clave == $usuario->clave)) {

          $jwt = AutentificadorJWT::CrearToken($usuario);

          $message = [
            'Autorizacion' => $jwt,
            'Status' => 'Login success',
            'Tipo' => $usuario->tipo
          ];

        } else {
          $message = [
            'Autorizacion' => 'Denegate',
            'Status' => 'Login failed'
          ];
        }
      }

      $payload = json_encode($message);

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        if($parametros['mail'] != null && $parametros['clave'] != null && $parametros['tipo'] != null){
          $mail = $parametros['mail'];
          $clave = $parametros['clave'];
          $tipo = $parametros['tipo'];
  
          // Creamos el usuario
          $usr = new Usuario();
          $usr->mail = $mail;
          $usr->clave = $clave;
          $usr->tipo = $tipo;
          $usr->crearUsuario();
  
          $payload = json_encode(array("mensaje" => "Usuario creado con exito"));
  
  
        }else{
          $payload = json_encode(array("mensaje" => "Faltan campos. No se pudo crear el usuario."));

        }
        
        $response->getBody()->write($payload);


        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $usr = $args['usuario'];
        $usuario = Usuario::obtenerUsuario($usr);
        $payload = json_encode($usuario);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        Usuario::modificarUsuario($nombre);

        $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuarioId = $parametros['usuarioId'];
        Usuario::borrarUsuario($usuarioId);

        $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
