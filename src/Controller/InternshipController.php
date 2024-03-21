<?php

namespace App\Controller;

use UMA\DIC\Container;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

use App\Entity\Internship;
use App\Entity\Skills;

class InternshipController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function Welcome(Request $request, Response $response, array $args, Container $container): Response
    {
        $entityManager = $container->get(EntityManager::class);
        $internships = $entityManager->getRepository(Internship::class)->findAll();

        $runwayBubbles = [];
        $sixSkills= [];
        if ($internships) {
            foreach ($internships as $forInternship) {
                $i = 0;
                $threeSkills = [];
                foreach ($forInternship->getSkills() as $skill) {
                    $i++;
                    if ($i <= 3) {
                        $threeSkills[] = $skill->getName();
                    } else {
                        break;
                    }
                }
                $runwayBubbles[] =
                [
                    'id' => $forInternship->getIDInternship(),
                    'job' => $forInternship->getTitle(),
                    'school_grade' => $forInternship->promotions->getName(),
                    'company' => $forInternship->companies->getName(),
                    'location' => $forInternship->locations->getCity(),
                    'begin_date' => $forInternship->getStartingDate(),
                    'duration' => $forInternship->getDuration() . ' semaines',
                    'competence_1' => $threeSkills[0],
                    'competence_2' => $threeSkills[1],
                    'competence_3' => $threeSkills[2],
                ];
            }
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Welcome/Welcome.html.twig', [
            'internships' => $runwayBubbles,
        ]);
    }
    public function Entreprise(Request $request, Response $response, array $args): Response
    {
        $view = Twig::fromRequest($request);
        return $this->twig->render($response, 'Entreprises/Entreprises.html.twig');
    }
}