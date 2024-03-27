<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Doctrine\ORM\EntityManager;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$container = require_once __DIR__ . '/../bootstrap.php';

$app = \DI\Bridge\Slim\Bridge::create($container);
$twig = Twig::create(__DIR__ . "/../templates", ['cache' => false]);
$container->set('view', $twig);
$app->add(TwigMiddleware::create($app, $twig));

$app->add(new \RKA\SessionMiddleware(['name' => 'MySessionName']));
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$route = require_once __DIR__ . "/../app/routes.php";
$route($app);

$app->run();
