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
}
