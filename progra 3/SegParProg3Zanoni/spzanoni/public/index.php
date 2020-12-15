<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Config\Database;
use App\Controllers\AlumnoController;
use App\Middleware\JsonMiddleware;
use App\Middleware\AuthMiddleware;


require __DIR__ . '/../vendor/autoload.php';

$conn = new Database;

$app = AppFactory::create();
$app->addErrorMiddleware(true, false, false);
$app->setBasePath('/spzanoni/public');

// $app->post('/', function (Request $request, Response $response, $args) {
//     $response->getBody()->write("hola");
    
//     return $response;
// });
$app->group('/users', function (RouteCollectorProxy $group) {

    $group->get('[/]', AlumnoController::class . ":getAll");
    
    $group->post('/usuario', AlumnoController::class . ":addOneUsuario");//funciona
    
    $group->post('/login', AlumnoController::class . ":login");//funciona
    
    $group->post('/materia', AlumnoController::class . ":addOneMateria")->add(new AuthMiddleware('admin'));//funciona

    $group->post('/{legajo}', AlumnoController::class . ":modifica");//hacer punto 4

    $group->post('/inscripcion/{id}', AlumnoController::class . ":inscripcionMaterias");

    $group->get('/materias', AlumnoController::class . ":getAllMaterias");//hacer
    
    $group->get('/materias/{id}', AlumnoController::class . ":getMateriasById");//hacer

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
