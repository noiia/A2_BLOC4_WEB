<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RKA\Session;
use Slim\Views\Twig;

class LoginController
{
    private Twig $twig;
    private Session $session;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->session = new Session();
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function Login(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'Login/Login.html.twig');
    }

    public function testLogins(Request $request, Response $response): Response
    {
        $json = $request->getParsedBody();
        $jsonData = json_decode($json['json'], true);

        $username = $jsonData['username'];
        $password = $jsonData['password'];

        $hashedPassword = hash('sha512', $password);

        $user = $this->entityManager->getRepository(Users::class)->findOneBy(['Login' => $username]);
        if ($user != null) {

            if ((string)$hashedPassword === (string)$user->getPassword()) {
                $this->session->set('user', $user);
                $response->getBody()->write(json_encode(['success' => true]));
                return $response->withHeader('content-type', 'application-json')->withStatus(200);
            } else {
                $response->getBody()->write("Identifiant incorrects");
                return $response->withHeader('content-type', 'application-json')->withStatus(401);
            }
        } else {
            $response->getBody()->write("Identifiant incorrects");
            return $response->withHeader('content-type', 'application-json')->withStatus(401);
        }

    }
}