<?php

use \Firebase\JWT\JWT;
require_once __DIR__ .'/vendor/autoload.php';
include_once './archivos.php';
include_once './materias.php';
include_once './profesores.php';
include_once './user.php';
include_once './respuesta.php';
include_once './asignacion.php';

$path = $_SERVER['PATH_INFO'];
$metodo = $_SERVER['REQUEST_METHOD'];//retorna la peticion requerida(post , delete, put,get)
//$token= $_SERVER['HTTP_TOKEN'];
//$json= file_get_contents('php://input');
//$json= json_decode($json);
$respuesta = new Respuesta;
$respuesta->data='';


//die();

switch($metodo)
{
    case 'POST':
        switch($path)
        {
            case '/usuario':
                if (isset($_POST['mail']) && isset($_POST['clave'])&& $_POST['mail']!="" && $_POST['clave']!="")
                {
                    if (User::Registrar($_POST['mail'],$_POST['clave']))//($json->mail,$json->clave))
                    {
                        $respuesta->data = 'Registro valido';
                       
                    }
                }else
                {
                    $respuesta->data= 'Faltan datos';
                    
                   
                }
                echo json_encode($respuesta);
            break;
            case '/login':
                if (isset($_POST['mail']) && isset($_POST['clave']) && $_POST['mail']!="" && $_POST['clave']!="")
                {   
                    
                    $respuesta->data = User::Login($_POST['mail'],$_POST['clave']);
                   
                }
                else
                {
                    $respuesta->data = 'Faltan datos';
                    $respuesta->status = 'fail';
                }
                
                echo json_encode($respuesta);
            break;
            case '/materia':
               $header = getallheaders();
               $token = $header['token'];
                
                
                if (User::IsAdmin($token))
                {
                    if (isset($_POST['nombre']) && isset($_POST['cuatrimestre'])&& $_POST['nombre']!="" && $_POST['cuatrimestre']!="")
                    {
                        if (Materia::RegistroMateria($_POST['nombre'],$_POST['cuatrimestre']))
                        {
                            $respuesta->data = 'Registro valido';
                        }
                    }else
                    {
                        $respuesta->data = 'Faltan datos';
                        $respuesta->status = 'fail';
                    }
                }else
                {
                    $respuesta->data='El token no corresponde a un usuario.';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
            case '/profesor':
                $header = getallheaders();
                $token = $header['token'];
                if (User::IsAdmin($token))
                {
                    if (isset($_POST['nombre'])  && isset($_POST['legajo']) && $_POST['nombre']!="" && $_POST['legajo']!="" )
                    {
                        $respuesta->data = Profesor::Registro($_POST['nombre'], $_POST['legajo']);
                        
    
                    }else
                        {
                            $respuesta->data='Faltan datos';
                            $respuesta->status='fail';
                        }
                }else
                {
                    $respuesta->data='El token no corresponde a un usuario.';
                    $respuesta->status='fail';
                }
                
                
                echo json_encode($respuesta);
    
            break;
            case '/asignacion':
                $header = getallheaders();
                $token = $header['token'];
                if(User::IsAdmin($token))
                {
                    if (isset($_POST['legajo'])  && isset($_POST['id']) && isset($_POST['turno']) && $_POST['id']!="" && $_POST['legajo']!="" && $_POST['turno']!="")
                    {
                        $respuesta->data=Asignacion::Registro($_POST['legajo'],$_POST['id'],$_POST['turno']);
                    }else
                    {
                        $respuesta->data='Faltan datos';
                        $respuesta->status='fail';
                    }
                }else
                {
                    $respuesta->data='El token no corresponde a un usuario.';
                    $respuesta->status='fail';
                }
                
                echo json_encode($respuesta);
            break;
        }    
    break;


    case 'GET':
        switch($path)
        {   
            
            case '/materia':
                $header = getallheaders();
                $token = $header['token'];
                if (User::isAdmin($token))
                {
                    $respuesta->data= File::TraerJson('materias.json');
                }else 
                {
                    $respuesta->data='El token no corresponde a un usuario.';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
            case '/profesor':
                $header = getallheaders();
                $token = $header['token'];
                if (User::isAdmin($token))
                {
                    $respuesta->data= File::TraerJson('profesores.json');
                }
                else
                {
                    $respuesta->data='El token no corresponde a un usuario.';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
            case '/asignacion':
                $header = getallheaders();
                $token = $header['token'];
                if (User::isAdmin($token))
                {
                    $respuesta->data= Asignacion::MostrarMateriasAsignadas();
                    //$respuesta->data= Datos::TraerJson('materias-profesores.json');
                }
                else
                {
                    $respuesta->data='El token no corresponde a un usuario.';
                    $respuesta->status='fail';
                }
                echo json_encode($respuesta);
            break;
        }
    break;
}




/*      case '/token':
                $key = "parcial1";
                $payload = array(
                    "iss" => "http://example.org",
                    "aud" => "http://example.com",
                    "iat" => 1356999524,
                    "nbf" => 1357000000,
                    "mail" => "enano@pequeñomail",
                    "clave" => 53622728
                );
                
                
                $jwt = JWT::encode($payload, $key);
                //print_r($jwt);
                //$decoded = JWT::decode($jwt, $key, array('HS256'));
                var_dump($_SERVER['HTTP_TOKEN']);
                //print_r($decoded);

            break;*/ 





?>