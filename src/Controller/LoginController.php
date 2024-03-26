<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UMA\DIC\Container;

class LoginController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function Login(Request $request, Response $response, array $args, Container $container): Response
    {
        $entityManager = $container->get(EntityManager::class);

        $view = Twig::fromRequest($request);
        return $view->render($response, 'Login/Login.html.twig');
    }
    public function testLogins(Request $request, Response $response, Container $container): Response
    {
        $entityManager = $container->get(EntityManager::class);
        $json = $request->getParsedBody();
        $jsonData = json_decode($json['json'], true);

        $username = $jsonData['username'];
        $password = $jsonData['password'];

        //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $login = $entityManager->getRepository(Users::class)->findOneBy(['Login' => $username]);
        if ($login != null){
            if ($password == $login->getPassword())
            {
                $response->getBody()->write("Auth réussie");
                return $response->withHeader('content-type', 'application-json')->withStatus(200);
            }
            else {
                $response->getBody()->write("erreur mot de passe");
                return $response->withHeader('content-type', 'application-json')->withStatus(401);
            }
        } else {
            $response->getBody()->write("erreur username");
            return $response->withHeader('content-type', 'application-json')->withStatus(401);
        }

    }
}