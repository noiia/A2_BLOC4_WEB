<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Location;
use App\Entity\Sector;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CompanyStatsController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function CompanyStats(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'CompanyStats/CompanyStats.html.twig');
    }


    public function CompanyStatsFilterApi(Request $request, Response $response, string $arg): ResponseInterface|int
    {
        $search = explode('=', $arg);
        $entity = null;
        if ($search[0] === 'city') {
            $entity = $this->entityManager->getRepository(Location::class)->findOneBy(['City' => $search[1]]);
            $data = ['id' => $entity->getIDLocation(), 'name' => $entity->getCity()];
        } else if ($search[1] === 'sector') {
            $entity = $this->entityManager->getRepository(Sector::class)->findOneBy(['Name' => $search[1]]);
            $data = ['id' => $entity->getIDCompany(), 'name' => $entity->getName()];
        }
        if ($entity != null) {
            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Competence introuvable');
        }
    }

    public function CompanyStatsApi(Request $request, Response $response, string $arg): ResponseInterface
    {
        $idSearch = explode('=', $arg)[0];
        $companies = $this->entityManager->getRepository(Company::class)->findAll();
        $data = ['total' => count($companies)];
        if ($idSearch === 'sector' || $idSearch === '*') {
            //envoye vers svg
            $locations = [];
            $sectorArray = [];
            if ($idSearch === '*') {
                $sectorArray = $this->entityManager->getRepository(Sector::class)->findAll();
            } else {
                $search = explode(';', explode('=', $arg)[1]);
                foreach ($search as $f) {
                    $sect = $this->entityManager->getRepository(Sector::class)->find((int)$f);
                    array_push($sectorArray, $sect);
                }
            }
            foreach ($companies as $company) {
                $sector = $company->getSector()->get(0);
                if (array_search($sector, $sectorArray) !== false) {
                    array_push($locations, $company->getLocation());
                }
            }
            $this->CompanyStatsSvg($locations);
        }
        if ($idSearch === 'city' || $idSearch === '*') {
            $cityToInternship = [];
            $locations = [];
            $locationArray = [];
            if ($idSearch === '*') {
                $locationArray = $this->entityManager->getRepository(Location::class)->findAll();
                $cityToInternship = array_fill_keys(array_map(function ($element) {
                    return $element->getCity();
                }, $locationArray), 0);
            } else {
                $search = explode(';', explode('=', $arg)[1]);
                foreach ($search as $f) {
                    $location = $this->entityManager->getRepository(Location::class)->find((int)$f);
                    $cityToInternship[$location->getCity()] = 0;
                    array_push($locationArray, $location);
                }
            }
            //les entreprises en fonction des villes
            foreach ($companies as $company) {
                $location = $company->getLocation();
                if (array_search($location, $locationArray) !== false) {
                    $cityToInternship[$location->getCity()] += 1;
                }
            }
            $data = array_merge($data, ['city' => $cityToInternship]);
        }
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function CompanyStatsSvg(array $locations): void
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
        $svg->asXML('../public/images/svg/Carte_remplie_departements_français_sectors.svg');
        // fin svg
    }

}