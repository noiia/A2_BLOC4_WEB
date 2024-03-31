<?php

namespace App\Controller;

use App\Entity\Internship;
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
            $mapDep['fill'] = "#ffff00";
            $mapDep['fill-opacity'] = ($nb / $total) * 5;
        }
        $svg->asXML('../public/images/svg/Carte_remplie_départements_français.svg');

        // fin svg
        return $this->twig->render($response, 'InternshipStats/InternshipStats.html.twig');
    }
}