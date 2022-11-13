<?php


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;


class MWPermisos
{
    public static function VerificarAdministrador(Request $request, RequestHandler $handler) {
        $jwtHeader = $request->getHeaderLine('Authorization');
        $response = new Response();
        try {
            $user = AutentificadorJWT::ObtenerData($jwtHeader);

            if (strtoupper($user->tipo) == 'ADMIN') {                
                $response = $handler->handle($request);
                $response = $response->withStatus( 200 );
            } else {                
                throw new Exception("El usuario no es administrador.");
            }
        } catch (Exception $e) {         
            $payload = json_encode(array('Error: ' => $e->getMessage()));
            $response->getBody()->write($payload);
            $response = $response->withStatus( 401 );
        }
        return $response->withHeader('Content-Type', 'application/json');;
    }



}
?>