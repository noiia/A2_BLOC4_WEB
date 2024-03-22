<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Doctrine\ORM\EntityManager;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$app = AppFactory::create();
$twig = Twig::create(__DIR__ . "/../templates", ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$route = require_once __DIR__ . "/../app/routes.php";
$route($app);

$app->run();
