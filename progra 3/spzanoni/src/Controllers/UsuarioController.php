<?php

namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use \Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Materia;
use App\Models\Usuario;
use App\Models\Alumno;
use App\Models\Profesor;
use stdClass;

class AlumnoController {

     public function addOneUsuario(Request $request, Response $response, $args)
    {
        $user = new Usuario;
        $user->nombre= $request->getParsedBody()['nombre'];
        $user->email = $request->getParsedBody()['email'];
        $user->tipo = $request->getParsedBody()['tipo'];
        $user->clave = $request->getParsedBody()['clave'];
        $rta = $user->save();
        
        if($user->email != $request->getParsedBody()['email']){

        
            
            if ($user->tipo=="alumno"){
                $alumno = new Alumno;
                $alumno->nombre= $user->nombre;
                $alumno->aEmail= $user->email;
                $alumno->alegajo= $user->legajo;
                $alumno->save();
                
            }
        }else{
            echo "usuario ya registrado";
        }
            $rta = $user->save();
       
        $response->getBody()->write(json_encode($rta));
        return $response;
    }   



    public function getAll (Request $request, Response $response, $args) {
        $rta = Usuario::get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function getAllMaterias (Request $request, Response $response, $args) {
        $headers = getallHeaders();
        $token=$headers['token'];
        $decoded = JWT::decode($token,"usuario", array('HS256'));
        
        if($decoded->tipo="profesor" && $decoded->tipo="admin" && $decoded->tipo="alumno"){
            $rta = Materia::get();
            $response->getBody()->write(json_encode($rta));
        }
        
        return $response;
    }

    public function MateriasporNota(Request $request, Response $response, $args)
    {         
        
        $inscripcion =Alumno::select('aMateria', 'nota')->get();

        $response->getBody()->write(json_encode($inscripcion));
        return $response;
    }

    public function getMateriasById (Request $request, Response $response, $args)
    {
        $headers = getallHeaders();
        $token=$headers['token'];
        $decoded = JWT::decode($token,"usuario", array('HS256'));

        if($decoded->tipo == "admin" && $decoded->tipo == "profesor")
        {
            $id = $args['idMateria'];//trae de la url, si es por body request
            $materia= Materia::find($id);
            
            $alumno= Alumno::Where('nombre')->where('aMateria',$materia->nombre)->get();
            
            $response->getBody()->write(json_encode($alumno));
            
        }else{
            echo "usuario no autorizado";
        }
        
        return $response;
    }


    public function getOne(Request $request, Response $response, $args)
    {
        $rta = Usuario::find($args['lagajo']);;

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public static function validarMail($str)
    {   
        $return=false;
         if (filter_var($str,FILTER_VALIDATE_EMAIL))
         {             
            $return = true;
         }
        return $return;
    }

    public static function usuarioExistente($user){
        $retorno=false;
        $aux= json_decode(Usuario::where("email",'=',$user->email))->get();
        if($aux != null){
            
            $retorno= true;
        }
        return $retorno;
    }

   
    
    public function addOneMateria(Request $request, Response $response, $args)
    {
        $materia = new Materia;

        $materia->nombre = $request->getParsedBody()['materia'];
        $materia->cuatrimestre = $request->getParsedBody()['cuatrimestre'];
        $materia->cupo = $request->getParsedBody()['cupos'];

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
        $req = $request->getParsedBody();
        $decoded = JWT::decode($token,"usuario", array('HS256'));
        $materia = Materia::find($args['idMateria']);
        
        if($decoded->tipo == "alumno"){
            if( $materia->cupo >=0)
            {   
                
                $alumno = new Alumno;
                $alumno->aLegajo= $decoded->legajo;
                $alumno->aEmail= $decoded->email;
                $alumno->aMateria = $materia->nombre;
                $alumno->aMateria = $materia;
                $materia->cupo--;
                $materia->save();
                $rta = $alumno->save();
                
            }else
            {
                echo "NO hay cupo";
            }
        }else{
            echo "Solo para tipo alumno";
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
        
        if($decoded->legajo == $usuario->legajo && $decoded->tipo == "profesor" || $decoded->tipo == "admin")
        {   
            
            $usuario->email=$request->getParsedBody()['email'];
            
            $usuario->save();
            
        }else if($decoded->legajo == $usuario->legajo && $decoded->tipo == "profesor" || $decoded->tipo == "admin")
        {   
            
            $profesor= Profesor::find($args['legajo']);
            $profesor->pEmail=$request->getParsedBody()['email'];
            $materias = implode("-",$req["materias"]);
            echo json_encode($materias);
            $profesor->pMateria = $materias;
            $profesor->save();
        }
        $response->getBody()->write(json_encode($usuario));
        return $response->withHeader('Content-type', 'application/json');;


    }

    public function asignarNota(Request $request, Response $response, $args)//terminar
    {
        
        $materia=$args['idMateria'];
        $req = $request->getParsedBody();
        $alumno=Alumno::where('aLegajo',$req['idAlumno'])->get();
        $headers = getallHeaders();
        $token=$headers['token'];
        $decoded = JWT::decode($token,"usuario", array('HS256'));

        
            $alumno->aMateria=$materia;
            $alumno->nota=$request->getParsedBody()['nota'];
            
            $alumno->save();
        

    }

}

