<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Usuario;

class AlumnoController {

    public function getAll (Request $request, Response $response, $args) {
        $rta = Usuario::get();

        // $response->getBody()->write("String");
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function getOne(Request $request, Response $response, $args)
    {
        $rta = Usuario::find($args['id']);;

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args)
    {
        $user = new Usuario;

        $user->usuario = "Pepe";
        $user->email = "pepe@gmail.com";
        $user->tipo = 3;
        $user->clave = '123456';

        $rta = $user->save();

        
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function updateOne(Request $request, Response $response, $args)
    {
        $user = Usuario::find(10);

        $user->usuario = "Pepe Grillo!!";

        $rta = $user->save();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function deleteOne(Request $request, Response $response, $args)
    {
        $user = Usuario::find(10);

        $rta = $user->delete();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

}