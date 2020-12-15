<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Config\Database;
use App\Controllers\AlumnoController;
use App\Controllers\PedidoController;
use App\Controllers\EncuestaController;
use App\Middleware\JsonMiddleware;
use App\Middleware\AuthMiddleware;
require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addErrorMiddleware(true, false, false);

//final

$conn = new Database;

$app = AppFactory::create();
$app->addErrorMiddleware(true, false, false);
$app->setBasePath('/comandas/public');


$app->group('/users', function (RouteCollectorProxy $group) {

    
    $group->post('/usuario', AlumnoController::class . ":addOneUsuario");
    
    $group->post('/login', AlumnoController::class . ":login");
    
    $group->post('/comanda', PedidoController::class  . ":addOneComanda" );
    $group->post('/detalle', PedidoController::class  . ":addDetalleComanda" );

    $group->get('/pendientes/{codigo}', PedidoController::class . ":getPendientes");
    

    $group->post('/modificaProducto/{ProdID}', PedidoController::class . ":updateProductoPedido");
    
    $group->post('/estadoPedido/{idComanda}', PedidoController::class . ":updateEstadoPedido");
     
    $group->post('/cierreMesa/{idComanda}', PedidoController::class . ":cierreDeMesa")->add(new AuthMiddleware("socio"));
    
    $group->get('/pedidos', PedidoController::class . ":getAllComandas");

    $group->get('/appCliente/{codigoMesa}', PedidoController::class . ":appCliente");

    $group->post('/encuesta', EncuestaController::class . ":addOneEncuesta");

    $group->get('/mostrarEncuestas', EncuestaController::class . ":getAllEncuesta");

    $group->get('/mostrarEmpleadosActivos', AlumnoController::class . ":getEmpleadosLogueados");

    

});

//->add(new AuthMiddleware)->add(new JsonMiddleware)

// ->add(function (Request $request, RequestHandler $handler) {
//     $response = $handler->handle($request);
//     // $existingContent = (string) $response->getBody();

//     // $response = new Response();
//     $response = $response->withHeader('Content-type', 'application/json');

//     return $response;
// });
$app->addBodyParsingMiddleware();
$app->run();

