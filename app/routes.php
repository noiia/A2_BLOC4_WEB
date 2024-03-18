<?php

declare(strict_types=1);

//use \src\Application\Actions\User\ListUsersAction;
//use \src\Application\Actions\User\ViewUserAction;
use App\Controller\FirstController;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/../src/Controller/FirstController.php";

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Twig($loader);
$container = require_once __DIR__ . '/../bootstrap.php';

return function (App $app) {
    global $twig;
    global $container;
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/Stage', function (Request $request, Response $response) use ($twig, $container){
        $controller = new FirstController($twig);
        $welcomeResponse = $controller->Welcome($request, $response,[], $container);
        return $welcomeResponse;
    });
    /*$app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });*/
};
