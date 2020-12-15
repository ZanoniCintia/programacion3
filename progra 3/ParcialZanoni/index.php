<?php


require_once __DIR__ .'/vendor/autoload.php';
use \Firebase\JWT\JWT;
include_once './archivos.php';
include_once './usuario.php';
include_once './respuesta.php';
include_once './estacionamiento.php';
include_once './auto.php';

$path = $_SERVER['PATH_INFO'];
$pathINdex=explode('/',$path);
$metodo = $_SERVER['REQUEST_METHOD'];

$respuesta = new Respuesta;
$respuesta->data='';


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
                    echo'Faltan datos';
                    
                   
                }
               //echo json_encode($respuesta);
            break;
            case 'login':
                if (isset($_POST['email']) && isset($_POST['password'])  && $_POST['email']!="" && $_POST['password']!="")
                {   
                     
                     echo usuario::Login($_POST['email'],$_POST['password']);
                   // echo "Acceso valido";
                          
                }
                else
                {
                    echo 'Faltan datos';
                    
                }
                
                //echo json_encode($respuesta);
            break;
            case 'precio':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {
                    estacionamiento::cargarPrecio($_POST['precio_hora'],$_POST['precio_mensual'],$_POST['precio_estadia']);
                    echo "Precio cargado";
                }else
                {
                    echo "Token invalido";
                }
                //echo json_encode($respuesta);
            break;
            case 'ingreso':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {   
                    
                    auto::ingresarAuto($_POST['patente'] ,$_POST['tipo'],$token);
                    echo "Ingreso registrado";
                }    
                //echo json_encode($respuesta);
            break;
           
        }    
    break;


    case 'GET':
        switch($pathINdex[1])
        {   
            
            case 'retiro':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {   
                    echo auto::retiroAuto(basename($path));
                }
                
            break;
            case 'ingreso':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {   
                    auto::ordenarYMostrar();
                    
                }
               
            break;
            case 'ingreso':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {   
                    auto::showClientByPatent($_GET['patente']);
                    
                }
            break;
            case 'importes':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {   
                  echo auto::CalcularPrecio(basename($path));

                } else{
                    echo "Usuario no autorizado";
                }
            break;
            case 'importe':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {   
                  echo auto::FechasPrecioFinal($_GET['fecha_ingreso'],$_GET['fecha_egreso']);
                }
            break;
        }
    break;
}

?>

