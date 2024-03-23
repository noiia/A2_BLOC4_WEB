<?php

namespace App\Controller;
use App\Entity\Company;
use UMA\DIC\Container;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
class CompanyController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function Company(Request $request, Response $response, array $args, Container $container): Response
    {
        $entityManager = $container->get(EntityManager::class);
        $companies = $entityManager->getRepository(Company::class)->findAll();

        $runwayBubbles = [];
        $sixSkills= [];
        if ($companies) {
            foreach ($companies as $forCompany) {
                $threeSectors = [];
                $i = 0;
               foreach ($forCompany->getSector() as $sector) {
                    $i++;
                    if ($i <= 3) {
                        $threeSectors[] = $sector->getName();
                    } else {
                        break;
                    }
               }
               $mediumStars = 0;
               $i = 0;
               foreach ($forCompany->getRates() as $rate) {
                   $i++;
                   $mediumStars += $rate->getNote();
               }
                $finalRate = $mediumStars / $i;
                $runwayBubbles[] =
                    [
                        'id' => $forCompany->getIDCompany(),
                        'company' => $forCompany->getName(),
                        'number_of_stages' => $forCompany->getCreationDate(),
                        'rate' => number_format((float)$finalRate, 1, '.', ''),
                        'sector_1' => $threeSectors[0],
                        'sector_2' => $threeSectors[1],
                        'sector_3' => $threeSectors[2],
                        'imagePath' => $forCompany->getCompanyLogoPath(),
                    ];
            }
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Company/Company.html.twig', [
            'companies' => $runwayBubbles,
        ]);
    }
}