<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Comanda;
use App\Models\Usuario;
use App\Models\Encuesta;

use DateTime;
//date_default_timezone_set('America/Argentina/Buenos_Aires');
use stdClass;

class EncuestaController {

    public function addOneEncuesta(Request $request, Response $response, $args)//uso
    {
        $encuesta = new Encuesta();
        
        $encuesta->mesa = $request->getParsedBody()['mesa'];
        $encuesta->restaurante = $request->getParsedBody()['restaurante'];
        $encuesta->mozo = $request->getParsedBody()['mozo'];
        $encuesta->cocinero = $request->getParsedBody()['cocinero'];
        $encuesta->mensaje = $request->getParsedBody()['mensaje'];

        $rta = $encuesta->save();
        
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function getAllEncuesta (Request $request, Response $response, $args) {
        $rta = Encuesta::get();
        // $response->getBody()->write("String");
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

}
