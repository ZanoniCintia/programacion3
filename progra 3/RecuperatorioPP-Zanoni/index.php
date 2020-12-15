
<?php
require_once __DIR__ .'/vendor/autoload.php';
use \Firebase\JWT\JWT;
include_once './archivos.php';
include_once './usuario.php';


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
                     
                    usuario::Login($_POST['email'],$_POST['password']);
                    echo "Acceso valido";
                          
                }
                else
                {
                   echo 'Faltan datos';
                    
                }
                
                
            break;
            case 'precio':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {
                   
                }else
                {
                    echo "Token invalido";
                }
                
            break;
            case 'ingreso':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {   
                    
                   
                }    
               
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
                   
                }
                
            break;
            case 'ingreso':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {   
                    
                    
                }
               
            break;
            case 'ingreso':
                $header = getallheaders();
                $token = $header['token'];
                if (usuario::IsAdmin($token))
                {   
                   
                    
                }
            break;
         
        }
    break;
}



?>