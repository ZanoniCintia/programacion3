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


$app->group('/users', function (RouteCollectorProxy $group) {

    
    
    $group->post('/users', AlumnoController::class . ":addOneUsuario");//1
    
    $group->post('/login', AlumnoController::class . ":login");//2
    
    $group->post('/materia', AlumnoController::class . ":addOneMateria")->add(new AuthMiddleware('admin'));//3

    $group->post('/inscripcion/{idMateria}', AlumnoController::class . ":inscripcionMaterias");//4

    $group->put('/notas/{idMateria}', AlumnoController::class . ":asignarNota")->add(new AuthMiddleware('profesor'));;//5 

    $group->get('/inscripcion/{idMateria}', AlumnoController::class . ":getMateriasById");//6
    
    $group->get('/materia', AlumnoController::class . ":getAllMaterias");//7
    
    $group->get('/notas/{idMateria}', AlumnoController::class . ":MateriasporNota");//8 no anda bien

})->add(new JsonMiddleware);


$app->addBodyParsingMiddleware();
$app->run();
