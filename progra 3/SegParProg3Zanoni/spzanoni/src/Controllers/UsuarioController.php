<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Materia;
use App\Models\Usuario;
use App\Models\Alumno;
use App\Models\Profesor;
use stdClass;

class AlumnoController {

    public function getAll (Request $request, Response $response, $args) {
        $rta = Usuario::get();
        // $response->getBody()->write("String");
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function getAllMaterias (Request $request, Response $response, $args) {
        $headers = getallHeaders();
        $token=$headers['token'];
        $decoded = JWT::decode($token,"usuario", array('HS256'));
        
        if($decoded->tipo == "admin")
        {
            $materias= Materia::get();
            $response->getBody()->write(json_encode($materias));
            

        }else if($decoded->tipo == "profesor")
        {   
            
            $profesor= Profesor::where('pLegajo',$decoded->legajo)->get();
            $response->getBody()->write(json_encode($profesor[0]->pMateria));

        }else if ($decoded->tipo == "alumno")
        {
            $alumno= Alumno::Where('aLegajo',$decoded->legajo)->get();
            $response->getBody()->write(json_encode($alumno[0]->aMateria));
        }
        
        return $response;
    }

    public function getMateriasById (Request $request, Response $response, $args)
    {
        $headers = getallHeaders();
        $token=$headers['token'];
        $decoded = JWT::decode($token,"usuario", array('HS256'));

        if($decoded->tipo == "admin")
        {
            $id = $args['id'];//trae de la url, si es por body request
            $materia= Materia::find($id);
            
            $alumno= Alumno::select('aEmail')->where('aMateria',$materia->nombre)->get();
            
            $response->getBody()->write(json_encode($alumno));
            

        }else if($decoded->tipo == "profesor")
        {   
            //terminar no entiendo la consigna
            $id = $args['id'];//args trae de la url, si es por body request
            $materia= Materia::find($id);
            
            $profesor= Profesor::where('pMateria',$materia->nombre)->get();
            
            $response->getBody()->write(json_encode($profesor));
        }
        return $response;
    }


    public function getOne(Request $request, Response $response, $args)
    {
        $rta = Usuario::find($args['lagajo']);;

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
  

    public function addOneUsuario(Request $request, Response $response, $args)
    {
        $user = new Usuario;

        $user->email = $request->getParsedBody()['email'];
        $user->tipo = $request->getParsedBody()['tipo'];
        $user->clave = $request->getParsedBody()['clave'];
        $rta = $user->save();
        if($user->tipo=="profesor"){
            $profesor=new Profesor;
            $profesor->pEmail = $user->email;
            $profesor->pLegajo= $user->legajo;
            $profesor->save();
        }else if ($user->tipo=="alumno"){
            $alumno = new Alumno;
            $alumno->aEmail= $user->email;
            $alumno->alegajo= $user->legajo;
            $alumno->save();
        }
        

        
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function addOneMateria(Request $request, Response $response, $args)
    {
        $materia = new Materia;

        $materia->nombre = $request->getParsedBody()['nombre'];
        $materia->cuatrimestre = $request->getParsedBody()['cuatrimestre'];
        $materia->cupo = $request->getParsedBody()['cupo'];

        $rta = $materia->save();

        
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function updateOneUsuario(Request $request, Response $response, $args)
    {
        $user = Usuario::find(10);

        $user->tipo = $request->getParsedBody()['tipo'];

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

    public function login(Request $request, Response $response, $args)
    {
        
        $body = $request->getParsedBody();
        $email = $body['email'];
        $clave = $body['clave'];

        $usuarioEncontrado = json_decode(Usuario::whereRaw('email = ? AND clave = ?',array($email,$clave))->get());
        $key = 'usuario';
        if($usuarioEncontrado){
            $payload = array(
                "email" => $usuarioEncontrado[0]->email,
                "clave" => $usuarioEncontrado[0]->clave,
                "tipo" => $usuarioEncontrado[0]->tipo,
                "legajo" => $usuarioEncontrado[0]->legajo);
            
                $play=JWT::encode($payload,$key);
                $rta= new stdClass;
                $rta->data=$play;
                $response->getBody()->write(json_encode($rta));
           

        }else{
            echo "Usuario no registrado";
        }
      

         return $response->withHeader('Content-type', 'application/json');;
    }

    public function inscripcionMaterias(Request $request, Response $response, $args)
    {
        
        $headers = getallHeaders();
        $token=$headers['token'];
        $decoded = JWT::decode($token,"usuario", array('HS256'));
        $materia = Materia::find($args['id']);
        
        if($materia->cupo >=0)
        {   
            
            $alumno = new Alumno;
            $alumno->aLegajo= $decoded->legajo;
            $alumno->aEmail= $decoded->email;
            $alumno->aMateria = $materia->nombre;
            $materia->cupo--;
            $materia->save();
            $rta = $alumno->save();
            
        }else
        {
            echo "NO hay cupo";
        }
        
        $response->getBody()->write(json_encode($rta));
        return $response;


    }

    public function modifica(Request $request, Response $response, $args)
    {
        $usuario=Usuario::find($args['legajo']);
        $req = $request->getParsedBody();
        $headers = getallHeaders();
        $token=$headers['token'];
        $decoded = JWT::decode($token,"usuario", array('HS256'));
        
        if($decoded->legajo == $usuario->legajo && $decoded->tipo == "alumno" || $decoded->tipo == "admin")
        {   
            
            $usuario->email=$request->getParsedBody()['email'];
            
            $usuario->save();
            
        }else if($decoded->legajo == $usuario->legajo && $decoded->tipo == "profesor" || $decoded->tipo == "admin")
        {   
            //$profesor= new Profesor;
            $profesor= Profesor::find($args['legajo']);
            $profesor->pEmail=$request->getParsedBody()['email'];
            $materias = implode("-",$req["materias"]);
            echo json_encode($materias);
            //$profesor->pLegajo = $usuario->legajo;
            $profesor->pMateria = $materias;
            $profesor->save();
        }
        $response->getBody()->write(json_encode($usuario));
        return $response->withHeader('Content-type', 'application/json');;


    }

}

