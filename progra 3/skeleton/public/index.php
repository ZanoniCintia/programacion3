<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Config\Database;
use App\Models\Alumno;
use App\Controllers\AlumnoController;

require __DIR__. '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('/php/Skeleton/public');

new Database();


$app->group('/alumnos', function(RouteCollectorProxy $group)
{
    $group->get('[/]', AlumnoController::class . ":getAll");
    $group->post('[/]', AlumnoController::class . ":addOne");
    $group->get('/{id}', AlumnoController::class . ":getOne");
    $group->put('/{id}', AlumnoController::class . ":updateOne");
    $group->delete('/{id}', AlumnoController::class . ":deleteOne");

});

$app->run();