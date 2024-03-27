<?php

namespace App\Controller;

use UMA\DIC\Container;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

use App\Entity\Users;

class ProfileController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function Profile(Request $request, Response $response, array $args, Container $container): Response
    {
        $entityManager = $container->get(EntityManager::class);
        $users = $entityManager->getRepository(Users::class)->findAll();
        $myProfile = [];

        foreach ($users as $forUser) {
            $myProfile[] = [
                'ID_users' => $forUser->getIDUsers(),
                'Name' => $forUser->getName(),
                'Surname' => $forUser->getSurname(),
                'Birth_date' => $forUser->getBirthDate()->format('d-m-Y'),
                'Profile_Description' => $forUser->getProfileDescription(),
                'Email' => $forUser->getEmail(),
            ];
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'Profile/Profile.html.twig', [
            'users' => $myProfile,
        ]);
    }
}