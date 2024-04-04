<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Rate;
use App\Entity\Users;
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
        $user = $request->getAttribute("user");
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
        $name[] = [
            'name' => $user->getName(),
            'surname' => $user->getSurname()
        ];
        $role = $user->getRole();
        return $this->twig->render($response, 'Company/Company.html.twig', [
            'companies' => $runwayBubbles,
            'names' => $name,
            'role' => $role,
        ]);
    }

    public function CompanyApi(Request $request, Response $response, int $id)
    {
        $company = $this->entityManager->getRepository(Company::class)->findOneBy(['ID_company' => $id]);


        $m = 0;
        $Sectors = [];
        foreach ($company->getSector() as $sector) {
            $m++;
            if ($m <= 6) {
                $Sectors[] = $sector->getName();
            } else {
                break;
            }
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
                    'skill'=>array_slice(array_map(function ($element){
                        return $element->getName();
                    },$internship->getSkills()->toArray()), 0,3)
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
        $idCompany = $jsonData['companyId'];

        $userSession = $request->getAttribute("user");
        $user = $this->entityManager->getRepository(Users::class)->findOneBy(['ID_users' => $userSession->getIDUsers()]);
        $company = $this->entityManager->getRepository(Company::class)->findOneBy(['ID_company' => $idCompany]);

        $entity = new Rate();
        $entity->setNote($rate);
        $entity->setDescription($comment);
        $entity->setDel(0);
        $entity->setUsers($user);
        $entity->setCompanies($company);
        $this->entityManager->persist($entity);

        $this->entityManager->flush();

        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('content-type', 'application-json')->withStatus(200);
    }

    public function CompanyManagement(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'CompanyManagement/CompanyManagement.html.twig');
    }

    public function miniCompanyManagementApi(Request $request, Response $response): Response
    {
        $Company = $this->entityManager->getRepository(Company::class)->findBy(['Del' => 0]);

        $companies = [];
        foreach ($Company as $forCompanies) {
            $companies[] = ['id' => $forCompanies->getIDCompany(), 'name' => $forCompanies->getName()];
        }
        $payload = json_encode($companies);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function CompanyManagementApi(Request $request, Response $response, int $id)
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

        $imagePath = "";
        if ($company->getCompanyLogoPath() != null) {
            $imagePath = $company->getCompanyLogoPath();
        }
        if ($company != null) {
            $data = [
                'id' => $company->getIDCompany(),
                'company' => $company->getName(),
                'SIRET' => $company->getSIRET(),
                'description' => $company->getCompanyDescription(),
                'sector' => $Sectors,
                'staff' => $company->getStaff(),
                'birthdate' => $company->getCreationDate(),
                'type' => $company->getType(),
                'logo_path' => $imagePath,
                'website' => $company->getCompanyWebsiteLink(),
                'email' => $company->getMail(),
            ];

            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Entreprise introuvable');
        }
    }

    function addCompany(Request $request, Response $response)
    {
        $jsonTable = $request->getBody();
        $table = json_decode($jsonTable, true);
        var_dump($table);
        if ($this->entityManager->getRepository(Company::class)->findOneBy(["SIRET" => $table["SIRET"]]) == null) {
            $company = new Company();
        } else {
            $company = $this->entityManager->getRepository(Company::class)->findOneBy(["ID_company" => $table["SIRET"]]);
        }

        $company->setName($table['name']);
        $company->setSIRET($table['SIRET']);
        $date = date_create($table['Date'], new DateTimeZone('UTC'));
        $company->setCreationDate($date);
        $company->setStaff($table['staff']);
        $company->setType($table['type']);
        $company->setMail($table['Email']);
        $company->setCompanyWebsiteLink($table['Website']);
        $company->setCompanyDescription($table['Description']);
        $company->setCompanyLogoPath("");
        $company->setDel(0);

        $location = $this->entityManager->getRepository(Location::class)->findOneBy(["ID_location" => $table['id_location']]);
        $company->setLocations($location);


        $this->entityManager->persist($company);
        $this->entityManager->flush();
        return $response->withStatus(200);

    }


    function delCompany(Request $request, Response $response, int $id)
    {
        $company = $this->entityManager->getRepository(Company::class)->findOneBy(['ID_company' => $id]);
        $company->setDel(1);
        $this->entityManager->persist($company);
        $this->entityManager->flush();
        $response->getBody()->write("Company deleted successfully");
        return $response;
    }

    function uploadPicture(Request $request, Response $response): Response
    {
        $file = $_FILES['file'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];

        $upload_directory = $_SERVER['DOCUMENT_ROOT'] . '/images/profilesPictures/';

        if (move_uploaded_file($file_tmp, $upload_directory . $file_name)) {
            $response->getBody()->write('Fichier téléchargé avec succès.');
            return $response->withStatus(200);
        } else {
            $response->getBody()->write('Une erreur est survenue lors du téléchargement du fichier.');
            return $response;
        }
    }
}