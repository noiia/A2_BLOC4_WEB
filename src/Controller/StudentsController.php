<?php


namespace App\Controller;

use App\Entity\Location;
use App\Entity\Promotion;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

use App\Entity\Users;

class StudentsController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function Students(Request $request, Response $response): Response
    {
        $students = $this->entityManager->getRepository(Users::class)->findAll();
        $promotions = $this->entityManager->getRepository(Promotion::class)->findAll();
        $locations = $this->entityManager->getRepository(Location::class)->findAll();

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
                'Del' => $forStudent->isDel(),
            ];
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Students/Students.html.twig', [
            'students' => $runwayStudents,
            'promotions' => $promotions,
            'locations' => $locations,
        ]);
    }

    public function StudentsApi(Request $request, Response $response, int $id)
    {
        $student = $this->entityManager->getRepository(Users::class)->findOneBy(['ID_users' => $id]);
        $tempPromotion = "";
        foreach ($student->getPromotions() as $promotions) {
            $tempPromotion = $promotions->getName();
        }
        if ($student != null) {
            $data = [
                'ID_users' => $student->getIDUsers(),
                'Name' => $student->getName(),
                'Surname' => $student->getSurname(),
                'Birth_date' => $student->getBirthDate()->format('Y-m-d'),
                'Profile_Description' => $student->getProfileDescription(),
                'Email' => $student->getEmail(),
                'Role' => $student->getRole(),
                'Promotion' => $tempPromotion,
                'Del' => $student->isDel(),
            ];

            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Etudiant introuvable');
        }
    }


}