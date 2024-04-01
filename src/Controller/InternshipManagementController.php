<?php

namespace App\Controller;

use App\Entity\Appliement_InternshipManagement;
use App\Entity\Appliement_WishList;
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
        $internshipManag = $this->entityManager->getRepository(Appliement_WishList::class)->findAll();
        $data = [];
        if ($internshipManag) {
            foreach ($internshipManag as $forInternshipManag) {
                $data[] = [
                    'id' => $forInternshipManag->getIDInternship(),
                    'job' => $forInternshipManag->internships->getTitle(),
                    'school_grade' => $forInternshipManag->internships->promotions->getName(),
                    'siret' => $forInternshipManag->internships->companies->getSIRET(),
                    'company' => $forInternshipManag->internships->companies->getName(),
                    'location' => $forInternshipManag->internships->locations->getCity(),
                    'begin_date' => $forInternshipManag->internships->getStartingDate(),
                    'duration' => $forInternshipManag->internships->getDuration() . ' semaines  ' . $forInternshipManag->internships->getHourPerWeek() . ' h/semaine',
                    'advantages' => $forInternshipManag->internships->getAdvantages(),
                    'description' => $forInternshipManag->internships->getDescription(),
                ];
            }
        }
        return $this->twig->render($response, 'InternshipManagement/InternshipManagement.html.twig', [
            'internships' => $data,
        ]);
    }
}
