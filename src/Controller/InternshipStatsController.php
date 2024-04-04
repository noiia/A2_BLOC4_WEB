<?php

namespace App\Controller;

use App\Entity\Internship;
use App\Entity\Skills;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
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
        $user = $request->getAttribute("user");
        $name[] = [
            'name' => $user->getName(),
            'surname' => $user->getSurname()
        ];
        $role = $user->getRole();

        return $this->twig->render($response, 'InternshipStats/InternshipStats.html.twig', [
            'names' => $name,
            'role' => $role
        ]);
    }

    public function InternshipStatsFilterApi(Request $request, Response $response, string $arg): ResponseInterface|int
    {
        $entity = $this->entityManager->getRepository(Skills::class)->findOneBy(['Name' => $arg]);
        if ($entity != null) {
            $data = ['id' => $entity->getIDSkills(), 'name' => $entity->getName(),];
            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Competence introuvable');
        }
    }

    public function InternshipStatsApi(Request $request, Response $response, string $arg): ResponseInterface
    {
        $search = explode(';', $arg);
        $internships = $this->entityManager->getRepository(Internship::class)->findAll();
        $allInternships = [];
        $locations = [];
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
                    'promotion' => $internship->getPromotion()->getName(),
                ];
                array_push($locations, $internship->getLocation());
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

        $this->InternshipStatsSvg($locations); //[Location, Location,..]

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function InternshipStatsSvg(array $locations): void
    {
        $GREEN = "#104E07";
        // debut svg
        $depToNbInternship = array_count_values(array_map(
            function ($element) {
                return $element->getDepartement();
            },
            $locations
        ));
        $total = array_sum($depToNbInternship);
        $svg = simplexml_load_file('../public/images/svg/Carte_vierge_departements_français.svg');
        foreach ($depToNbInternship as $dep => $nb) {
            $mapDep = $svg->xpath('//*[@id="dep' . $dep . '"]')[0];
            $mapDep['fill'] = $GREEN;
            $mapDep['fill-opacity'] = ($nb / $total) * 5; // 2% de stage = 100% d'opacity
        }
        $svg->asXML('../public/images/svg/Carte_remplie_departements_français_locations.svg');
        // fin svg
    }

}