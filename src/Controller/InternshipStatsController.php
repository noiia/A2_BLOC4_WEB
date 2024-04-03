<?php

namespace App\Controller;

use App\Entity\Internship;
use App\Entity\Skills;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class InternshipStatsController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function InternshipStats(Request $request, Response $response): Response
    {
        /*
        // debut svg
        $depToNbInternship = array_count_values(array_map(
            function ($element) {
                return $element->locations->getDepartement();
            },
            $this->entityManager->getRepository(Internship::class)->findAll()
        ));
        $total = array_sum($depToNbInternship);
        $svg = simplexml_load_file('../public/images/svg/Carte_vierge_départements_français.svg');
        foreach ($depToNbInternship as $dep => $nb) {
            $mapDep = $svg->xpath('//*[@id="dep' . $dep . '"]')[0];
            $mapDep['fill'] = "#104E07";
            $mapDep['fill-opacity'] = ($nb / $total) * 5; //2% de stage = 100% opaque
        }
        $svg->asXML('../public/images/svg/Carte_remplie_départements_français.svg');

        // fin svg
        */

        return $this->twig->render($response, 'InternshipStats/InternshipStats.html.twig');
    }

    public function InternshipStatsApi(Request $request, Response $response, string $arg)
    {
        $search = explode(';', $arg);
        $internships = $this->entityManager->getRepository(Internship::class)->findAll();
        $allInternships = [];
        //les skills
        $skillArray = [];
        if ($search === ['*']) {
            $skillArray = $this->entityManager->getRepository(Skills::class)->findAll();
            $allInternships = array_fill_keys(array_map(function ($element) {
                return $element->getName();
            }, $skillArray), array());
        } else {
            foreach ($search as $f) {
                $skill = $this->entityManager->getRepository(Skills::class)->find((int)$f);
                $allInternships[$skill->getName()] = array();
                array_push($skillArray, $skill);
            }
        }
        //les stages en fonctions des skills
        foreach ($internships as $internship) {
            $skill = $internship->getSkills()->get(0);
            if (array_search($skill, $skillArray) !== false) {
                $internshipDetail = [
                    'id' => $internship->getIDInternship(),
                    'duree' => $internship->getDuration(),
                    'promotion' => $internship->getPromotion(),
                ];
                array_push($allInternships[$skill->getName()], $internshipDetail);
            }
        }
        /*
        //les stages en fonctions des skills
        foreach ($internships as $internship) {
            foreach ($skillArray as $skill) {
                if ($internship->getSkills()->contains($skill)) {
                    $internshipDetail = [
                        'id' => $internship->getIDInternship(),
                    ];
                    array_push($allInternships[$skill->getName()], $internshipDetail);
                }
            }
        }
         */
        $data = [
            'total' => count($internships),
            'stages' => $allInternships,
        ];

        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}