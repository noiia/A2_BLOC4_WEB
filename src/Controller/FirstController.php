<?php

namespace App\Controller;

use DI\Container;
use Doctrine\ORM\EntityManager;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Internship;
use App\Entity\Company;

use Slim\Views\Twig;
class FirstController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }
    public function Welcome(Request $request, Response $response, array $args, Container $container): Response
    {
        $entityManager = $container->get(EntityManager::class);
        echo $entityManager->getRepository(Internship::class)->findAll();
        $internships = [
            [
                'id' => '001',
                'job' => 'Dev pigeonRTX',
                'school_grade' => 'Bac+2',
                'company' => 'Sfr',
                'location' => 'Paris',
                'begin_date' => '23/05/2024',
                'duration' => '3 mois',
                'competence_1' => 'js',
                'competence_2' => 'python',
                'competence_3' => 'js',
            ],
        ];
        $bubbles = [
            [
                'id' => '001',
                'job' => 'Dev pigeonRTX',
                'school_grade' => 'Bac+2',
                'company' => 'Sfr',
                'location' => 'Paris',
                'begin_date' => '23/05/2024',
                'hour_payment' => 12,
                'month_payment' => 1350,
                'duration' => '3 mois',
                'advantages' => 'passe annuel pour des combats de coqs',
                'description' => 'blablablaaaaaaa',
            ],
        ];
        $skills = [];
        $skillArray = ['ae', 'aeee', 'adfsef', 'js'];
        $i = 0;
        foreach($skillArray as $forSkill)
        {
            $i++;
            if ($i <= 7) {
                $skills[] = ['competence' => $forSkill];
            } else {
                break;
            }
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Welcome/Welcome.html.twig',[
            'internships' => $internships,
            'bubbles' => $bubbles,
            'skills' => $skills,
        ]);
    }
    public function Entreprise(Request $request, Response $response, array $args): Response
    {
        $view = Twig::fromRequest($request);
        return $this->twig->render($response, 'Entreprises/Entreprises.html.twig');
    }
}