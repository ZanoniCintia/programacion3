
<?php
require_once __DIR__ .'/vendor/autoload.php';
use \Firebase\JWT\JWT;
header('Content-Type: application/json');
include_once './archivos.php';
include_once './usuario.php';
include_once './vehiculos.php';
$path = $_SERVER['PATH_INFO'];
$pathINdex=explode('/',$path);
$metodo = $_SERVER['REQUEST_METHOD'];




switch($metodo)
{
    case 'POST':
        switch($pathINdex[1])
        {
            case 'registro':
                if (isset($_POST['email']) && isset($_POST['tipo']) && isset($_POST['password'])&& $_POST['email']!="" && $_POST['tipo'] && $_POST['password']!="")
                {
                    if (usuario::RegistrarUsuario($_POST['email'],$_POST['tipo'],$_POST['password']))
                    {
                        echo 'Registro valido';
                       
                    }
                }else
                {
                    echo 'Faltan datos';
   
                }
                
            break;
            case 'login':
                if (isset($_POST['email']) && isset($_POST['password'])  && $_POST['email']!="" && $_POST['password']!="")
                {   
                   $res = new stdClass();
                   $res->data=usuario::Login($_POST['email'],$_POST['password']);
                   echo json_encode($res);
                   
                }
                else
                {
                   echo 'Faltan datos';
                    
                }
                
                
            break;
            case 'vehiculo':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::validarToken($token))
                {
                   echo vehiculo::ingresarAuto($_POST['patente'],$_POST['marca'],$_POST['modelo'],$_POST['precio']);
                }else
                {
                    echo "Token invalido";
                }
                
            break;
            case 'servicio':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::validarToken($token))
                {   
                    
                   vehiculo::ingresarServicio($_POST['id'],$_POST['tipo'],$_POST['precio'],$_POST['demora']);
                }    
               
            break;
            case 'stats':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {   
                    vehiculo::statsService($_POST['tipo_servicio']);
                  
                }else{
                    echo "Usuario no es admin";
                }  
               
            break;
           
        }    
    break;


    case 'GET':
        switch($pathINdex[1])
        {   
            
            case 'patente':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::validarToken($token))
                {   
                    vehiculo::verificarExistencia(basename($path));
                }
                
            break;
            case 'turno':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::validarToken($token))
                {   
                   vehiculo::Asignarturno($_GET['patente'],$_GET['fecha'],$_GET['servicio']);
                }
                
            break;
         
        }
    break;
}



?>