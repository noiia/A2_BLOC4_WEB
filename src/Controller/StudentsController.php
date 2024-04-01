<?php


namespace App\Controller;

use App\Entity\Location;
use App\Entity\Promotion;
use UMA\DIC\Container;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

use App\Entity\Users;

class StudentsController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function Students(Request $request, Response $response, array $args, Container $container): Response
    {
        $entityManager = $container->get(EntityManager::class);
        $students = $entityManager->getRepository(Users::class)->findAll();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
        $locations = $entityManager->getRepository(Location::class)->findAll();

        $runwayStudents = [];
        foreach ($students as $forStudent) {
            $runwayStudents[] = [
                'ID_users' => $forStudent->getIDUsers(),
                'Name' => $forStudent->getName(),
                'Surname' => $forStudent->getSurname(),
                'Birth_date' => $forStudent->getBirthDate()->format('d-m-Y'),
                'Profile_Description' => $forStudent->getProfileDescription(),
                'Email' => $forStudent->getEmail(),
                'Role' => $forStudent->getRole(),
            ];
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Students/Students.html.twig', [
            'students' => $runwayStudents,
            'promotions' => $promotions,
            'locations' => $locations,
        ]);
    }
}