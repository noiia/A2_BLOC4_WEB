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
                $runwayBubbles[] =
                    [
                        'id' => $forCompany->getIDCompany(),
                        'company' => $forCompany->getName(),
                        'siret' => $forCompany->getSIRET(),
                        //'location' => $forCompany->locations->getCity(),
                        'creation_date' => $forCompany->getCreationDate(),
                        'staff' => $forCompany->getStaff(),
                        'type' => $forCompany->getType(),
                        'description' => $forCompany->getCompanyDescription(),
                    ];
            }
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Company/Company.html.twig', [
            'companies' => $runwayBubbles,
        ]);
    }
}