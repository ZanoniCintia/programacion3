<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Config\Database;
use App\Controllers\AlumnoController;
use App\Middlewares\JsonMiddleware;
use App\Middlewares\AuthMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$conn = new Database;

$app = AppFactory::create();
$app->setBasePath('/prog3/esqueleton/public');


$app->group('/users', function (RouteCollectorProxy $group) {

    $group->get('[/]', AlumnoController::class . ":getAll");
    
    $group->post('[/]', AlumnoController::class . ":addOne");
    
    $group->get('/{id}', AlumnoController::class . ":getOne");

    $group->put('/{id}', AlumnoController::class . ":updateOne");

    $group->delete('/{id}', AlumnoController::class . ":deleteOne");

})->add(new AuthMiddleware)->add(new JsonMiddleware);



// ->add(function (Request $request, RequestHandler $handler) {
//     $response = $handler->handle($request);
//     // $existingContent = (string) $response->getBody();

//     // $response = new Response();
//     $response = $response->withHeader('Content-type', 'application/json');

//     return $response;
// });

$app->run();
