<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
header('Content-Type: application/json');
use \Firebase\JWT\JWT;
require_once 'usuario.php';
require_once 'archivos.php';
require_once 'comandas.php';
require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addErrorMiddleware(true, false, false);

$app->setBasePath('/tp_comandas.zanoni');

$app->post('/registro[/]', function (Request $request, Response $response, $args) {
    if(usuario::RegistrarUsuario($_POST['puesto'],$_POST['tipo_usuario'],$_POST['clave'])){
        $response->getBody()->write("Registro valido");
    }else{
        $response->getBody()->write("Usuario ya registrado");
    }
    
    return $response;
});

$app->post('/login[/]', function (Request $request, Response $response, $args) {
    
    if(usuario::Login($_POST['puesto'],$_POST['clave'])){
        $res = new stdClass();
        $res->data=usuario::Login($_POST['puesto'],$_POST['clave']);
        echo json_encode($res);
        $response->getBody()->write("Bienvenido");
    }else{
        $response->getBody()->write("Usuario no registrado");
    }
    return $response;
});

$app->post('/comanda[/]', function (Request $request, Response $response, $args) {
    $headers = getallHeaders();
    $token=$headers['token'];
    if (usuario::validarToken($token))
        {
             Comanda::cargarComanda($_POST['cliente'],$_POST['mozo'],$_POST['tragos'],$_POST['cerveza'],$_POST['plato'],$_POST['codigo_mesa']);
             $response->getBody()->write("Comanda ingresada");
        }else
        {
            $response->getBody()->write("Error al ingresar comanda");
        }

    
    return $response;
});

$app->post('/estado[/]', function (Request $request, Response $response, $args) {
    $headers = getallHeaders();
    $token=$headers['token'];
    if (usuario::validarToken($token))
        {
             
             $response->getBody()->write("Estado cambiado");
        }else
        {
            $response->getBody()->write("Usuario no autorizado para cerrar la mesa");
        }

    
    return $response;
});

$app->get('/pendientes[/]', function (Request $request, Response $response, $args) {
    $headers = getallHeaders();
    $token=$headers['token'];
    if (usuario::validarToken($token))
        {
            $response->getBody()->write("Lista de pendientes : ");
            Comanda::mostrarPedidosPendientes();
             
        }
        return $response;
});

$app->run();