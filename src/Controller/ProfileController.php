<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

use App\Entity\Users;

class ProfileController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function Profil(Request $request, Response $response): Response
    {
        $userSession = $request->getAttribute("user");

        $myProfile[] = [
            'ID_users' => $userSession->getIDUsers(),
            'Name' => $userSession->getName(),
            'Surname' => $userSession->getSurname(),
            'Birth_date' => $userSession->getBirthDate()->format('d-m-Y'),
            'Profile_Description' => $userSession->getProfileDescription(),
            'Email' => $userSession->getEmail(),
        ];
        $role = $userSession->getRole();

        $view = Twig::fromRequest($request);
        return $view->render($response, 'Profile/Profile.html.twig', [
            'users' => $myProfile,
            'role' => $role,
        ]);
    }

    public function ProfilApi(Request $request, Response $response, int $id)
    {
        $User = $this->entityManager->getRepository(Users::class)->findOneBy(['ID_users' => $id]);
        if ($User != null) {
            $data = [
                'ID_users' => $User->getIDUsers(),
                'Name' => $User->getName(),
                'Surname' => $User->getSurname(),
                'Birth_date' => $User->getBirthDate(),
                'Profile_Description' => $User->getProfileDescription(),
                'Email' => $User->getEmail(),
            ];
            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Erreur d affichage du profil');
        }
    }
}