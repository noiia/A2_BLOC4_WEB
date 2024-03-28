<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Rate;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class CompanyController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function Company(Request $request, Response $response): Response
    {
        $companies = $this->entityManager->getRepository(Company::class)->findAll();

        $runwayBubbles = [];
        $sixSkills = [];
        if ($companies) {
            foreach ($companies as $forCompany) {
                $threeSectors = [];
                $i = 0;
                if ($forCompany->getSector() != ("" || null)) {
                    foreach ($forCompany->getSector() as $sector) {
                        $i++;
                        if ($i <= 3) {
                            $threeSectors[] = $sector->getName();
                        } else {
                            break;
                        }
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

    public function CompanyApi(Request $request, Response $response, int $id)
    {
        $company = $this->entityManager->getRepository(Company::class)->findOneBy(['ID_company' => $id]);


        $m = 0;
        $Sectors = [];
        $second = null;
        foreach ($company->getSector() as $sector) {
            if ($m <= 6) {
                $m++;
                if ($m % 2 != 0) {
                    $second = $sector->getName();
                } else if ($m % 2 == 0 && $second != null) {
                    $Sectors[] = [$sector->getName(), $second];
                    $second = null;
                }
            } else {
                break;
            }
        }
        if ($second != null) {
            $Sectors[] = [$second];
        }
        $Internships = [];
        $i = 0;
        foreach ($company->getInternship() as $internship) {
            $i++;
            $Internships[] =
                [
                    'title' => $internship->getTitle(),
                    'location' => $internship->locations->getCity(),
                    'starting_date' => $internship->getStartingDate(),
                    'duration' => $internship->getDuration(),
                ];
        }

        $j = 0;
        $medium = 0;
        $Comments = [];
        if ($company->getRates() != null) {
            foreach ($company->getRates() as $rate) {
                $medium += $rate->getNote();
                $j++;
                $Comments[] =
                    [
                        'user' => $rate->users->getName(),
                        'note' => $rate->getNote(),
                        'description' => $rate->getDescription(),
                    ];
            }
        }
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
        $imagePath = "";
        if ($company->getCompanyLogoPath() != null) {
            $imagePath = $company->getCompanyLogoPath();
        }
        $finalRate = $medium / $j;
        if ($company != null) {
            $data = [
                'id' => $company->getIDCompany(),
                'company' => $company->getName(),
                'location' => $company->locations->getCity(),
                'zip_code' => $company->locations->getZipCode(),
                'medium_rate' => number_format((float)$finalRate, 1, '.', ''),
                'number_former_intern' => $j,
                'description' => $company->getCompanyDescription(),
                'sector' => $Sectors,
                'internship' => $Internships,
                'comment' => $Comments,
                'number_of_internship' => $i,
                'logo_path' => $imagePath,
                'skill' => $Skills,
            ];

            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Entreprise introuvable');
        }
    }

    public function addComment(Request $request, Response $response)
    {
        $json = $request->getParsedBody();
        $jsonData = json_decode($json['json'], true);

        $rate = $jsonData['rate'];
        $comment = $jsonData['comment'];

        $entity = new Rate();
        $entity->setNote($rate);
        $entity->setDescription($comment);
        $entity->setDel(0);
        //$entity->setUsers()
        $this->entityManager->persist($entity);

        $this->entityManager->flush();

        return $response;
    }
}