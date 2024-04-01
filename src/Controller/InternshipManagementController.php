<?php

namespace App\Controller;

use App\Entity\Appliement_InternshipManagement;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

use App\Entity\Internship;

class InternshipManagementController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function InternshipManagement(Request $request, Response $response): Response
    {
        $user = $request->getAttribute("user");
        $internshipManag = $this->entityManager->getRepository(Internship::class)->findAll();
        if ($internshipManag != null) {
            foreach ($internshipManag as $forInternshipManag) {
                $data[] = [
                    'id' => $forInternshipManag->getIDInternship(),
                    'job' => $forInternshipManag->getTitle(),
                    'school_grade' => $forInternshipManag->promotions->getName(), // Utilisez les méthodes getters pour accéder aux propriétés
                    'company' => $forInternshipManag->companies->getName(),
                    'location' => $forInternshipManag->locations->getCity(),
                    'begin_date' => $forInternshipManag->getStartingDate(),
                    'duration' => $forInternshipManag->getDuration() . ' semaines  ' . $forInternshipManag->getHourPerWeek() . ' h/semaine',
                    'advantages' => $forInternshipManag->getAdvantages(),
                    'description' => $forInternshipManag->getDescription(),
                ];
            }
            return $this->twig->render($response, 'InternshipManagement/InternshipManagement.html.twig', [
                'internships' => $data,
            ]);
        } else {
            return $this->twig->render($response, 'InternshipManagement/InternshipManagement.html.twig');
        }
    }}
