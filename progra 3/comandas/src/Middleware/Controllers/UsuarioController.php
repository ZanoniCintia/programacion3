<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Comanda;
use App\Models\Empleado;
use App\Models\Usuario;
use App\Models\Encuesta;

use DateTime;
//date_default_timezone_set('America/Argentina/Buenos_Aires');
use stdClass;

class AlumnoController {


    public function addOneUsuario(Request $request, Response $response, $args)//uso
    {
        $user = new Usuario;
        $fecha = date('Y-m-d');
        $hora = date('H:m:s');
        if(!$user->nombre == $request->getParsedBody()['nombre']
        && !$user->apellido == $request->getParsedBody()['apellido']){
        
            $user->nombre = $request->getParsedBody()['nombre'];
            $user->apellido = $request->getParsedBody()['apellido'];
            $user->puesto = $request->getParsedBody()['puesto'];
            $user->clave = $request->getParsedBody()['clave'];
            $user->fecha = $fecha;
            $user->hora = $hora;
            $rta = $user->save();
            $response->getBody()->write(json_encode($rta));
        }else{
            echo "Usuario ya registrado";
        }
               
        return $response;
    }

    public function login(Request $request, Response $response, $args)//uso
    {
        
        $body = $request->getParsedBody();
        $apellido = $body['apellido'];
        $clave = $body['clave'];

        $usuarioEncontrado = json_decode(Usuario::whereRaw('apellido = ? AND clave = ?',array($apellido,$clave))->get());
        $key = 'comanda';
       if($usuarioEncontrado){
            $empleado=new Empleado();
            $payload = array(
                "nombre" => $usuarioEncontrado[0]->nombre,
                "apellido" => $usuarioEncontrado[0]->apellido,
                "puesto" => $usuarioEncontrado[0]->puesto,
                "codigo" => $usuarioEncontrado[0]->codigo,
                "fecha" => $usuarioEncontrado[0]->fecha,
                "hora" => $usuarioEncontrado[0]->hora
            );
                
                //$empleado->puesto=$usuarioEncontrado[0]->puesto;
                $empleado->login=$usuarioEncontrado[0]->hora;
                $empleado->save();

            
                $play=JWT::encode($payload,$key);
                $rta= new stdClass;
                $rta->data=$play;
                $response->getBody()->write(json_encode($rta));
           
            }else{
                echo "Usuario no registrado";
            }
      
      

         return $response->withHeader('Content-type', 'application/json');;
    }
   


    

   
    public function getEmpleadosLogueados(Request $request, Response $response, $args)
    {
        $rta = Empleado::get();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
  

    

   

   

    

}