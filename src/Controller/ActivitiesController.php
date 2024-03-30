<?php

namespace App\Controller;

use App\Entity\Appliement_WishList;
use App\Entity\Internship;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RKA\Session;
use Slim\Views\Twig;

class ActivitiesController
{
    private $twig;
    private EntityManager $entityManager;
    private Session $session;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function Activities(Request $request, Response $response): Response
    {
        $user = $request->getAttribute("user");
        $activities = $this->entityManager->getRepository(Internship::class)->findAll();
        $data = [];
        $sixSkills = [];
        if ($activities) {
            foreach ($activities as $forActivities) {
                $i = 0;
                $threeSkills = [];
                foreach ($forActivities->getSkills() as $skill) {
                    $i++;
                    if ($i <= 3) {
                        $threeSkills[] = $skill->getName();
                    } else {
                        break;
                    }
                }
                $data[] =
                    [
                        'id' => $forActivities->getIDInternship(),
                        'job' => $forActivities->getTitle(),
                        'school_grade' => $forActivities->promotions->getName(),
                        'company' => $forActivities->companies->getName(),
                        'location' => $forActivities->locations->getCity(),
                        'begin_date' => $forActivities->getStartingDate(),
                        'duration' => $forActivities->getDuration() . ' semaines',
                        'competence_1' => $threeSkills[0], 
                        'competence_2' => $threeSkills[1], 
                        'competence_3' => $threeSkills[2], 
                    ];
            }
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Activities/Activities.html.twig', [
            'internships' => $data,
        ]);
    }

public function ActivitiesApi(Request $request, Response $response, int $id)
    {


        $internship = $this->entityManager->getRepository(Internship::class)->findOneBy(['ID_Internship' => $id]);
        $i = 0;
        $Skills = [];
        foreach ($internship->getSkills() as $skill) {
            $i++;
            if ($i <= 3) {
                $Skills[] = $skill->getName();
            } else {
                break;
            }
        }
        $j = 0;
        if ($internship != null) {
            $data = [
                'id' => $internship->getIDInternship(),
                'job' => $internship->getTitle(),
                'school_grade' => $internship->promotions->getName(), // Utilisez les méthodes getters pour accéder aux propriétés
                'company' => $internship->companies->getName(),
                'location' => $internship->locations->getCity(),
                'begin_date' => $internship->getStartingDate(),
                'duration' => $internship->getDuration() . ' semaines  ' . $internship->getHourPerWeek() . ' h/semaine',
                'skills' => $Skills,
            ];

            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Stage introuvable');
        }
    }
}