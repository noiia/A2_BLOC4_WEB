<?php

namespace App\Controller;

use App\Entity\Appliement_WishList;
use App\Entity\Company;
use App\Entity\Location;
use App\Entity\Promotion;
use App\Entity\Users;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

use App\Entity\Internship;

class InternshipManagementController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function InternshipManagement(Request $request, Response $response): Response
    {
        $user = $request->getAttribute("user");
        $internshipManags = $this->entityManager->getRepository(Appliement_WishList::class)->findAll();
        $data = [];
        if ($internshipManags) {
            foreach ($internshipManags as $forInternshipManag) {
                $data[] = [
                    'name' => $forInternshipManag->users->getName(),
                    'surname' => $forInternshipManag->users->getSurname(),
                    'id' => $forInternshipManag->getIDInternship(),
                    'job' => $forInternshipManag->internships->getTitle(),
                    'school_grade' => $forInternshipManag->internships->promotions->getName(),
                    'siret' => $forInternshipManag->internships->companies->getSIRET(),
                    'company' => $forInternshipManag->internships->companies->getName(),
                    'location' => $forInternshipManag->internships->locations->getCity(),
                    'begin_date' => $forInternshipManag->internships->getStartingDate(),
                    'duration' => $forInternshipManag->internships->getDuration(),
                    'week_hours' => $forInternshipManag->internships->getHourPerWeek(),
                    'salary' => $forInternshipManag->internships->getHourPerWeek() * $forInternshipManag->internships->getHourlyRate() * $forInternshipManag->internships->getDuration(),
                    'advantages' => $forInternshipManag->internships->getAdvantages(),
                    'description' => $forInternshipManag->internships->getDescription(),
                    'skills' => $forInternshipManag->internships->getSkillsAsString(),
                    'status' => $forInternshipManag->getStatus(),
                    'del' => $forInternshipManag->internships->getDel(),
                ];
            }
        }
        return $this->twig->render($response, 'InternshipManagement/InternshipManagement.html.twig', [
            'internshipManags' => $data,
        ]);
    }


    public function InternshipManagementApi(Request $request, Response $response, int $id)
    {

        $internshipM = $this->entityManager->getRepository(Internship::class)->findOneBy(['ID_Internship' => $id]);
        $i = 0;
        $Skills = [];
        foreach ($internshipM->getSkills() as $skill) {
            $i++;
            if ($i <= 3) {
                $Skills[] = $skill->getName();
            } else {
                break;
            }
        }
        $j = 0;
        if ($internshipM->getAppliementWishlist() != null) {
            foreach ($internshipM->getAppliementWishlist() as $appliement) {
                if ($appliement->getStatus() == 2) {
                    $j++;
                }
            }
        }
        if ($internshipM != null) {
            $data = [
                'id' => $internshipM->getIDInternship(),
                'job' => $internshipM->getTitle(),
                'school_grade' => $internshipM->promotions->getName(), // Utilisez les méthodes getters pour accéder aux propriétés
                'company' => $internshipM->companies->getName(),
                'location' => $internshipM->locations->getCity(),
                'begin_date' => $internshipM->getStartingDate(),
                'hour_payment' => $internshipM->getHourlyRate(),
                'week_payment' => $internshipM->getHourPerWeek() * $internshipM->getHourlyRate(),
                'duration' => $internshipM->getDuration() . ' semaines  ' . $internshipM->getHourPerWeek() . ' h/semaine',
                'taken_places' => $j,
                'max_places' => $internshipM->getMaxPlaces(),
                'advantages' => $internshipM->getAdvantages(),
                'description' => $internshipM->getDescription(),
                'siret' => $internshipM->companies->getSIRET(),
                'del' => $internshipM->getDel(),


            ];

            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Stage introuvable');
        }
    }


public function addInternshipManagement(Request $request, Response $response): Response
{
    $jsonTable = $request->getBody();

    $table = json_decode($jsonTable, true);

    $company = new Company();
    $internship = new Internship();
    $promotion = new Promotion();
    $location = new Location();

    $internship->setTitle($table['Title']);
    $internship->setIDInternship($table['ID_Internship']);
    $company->setName($table['Name']);
    $internship->setDescription($table['Description']);
    $promotion->setName($table['Name']);
    $internship->setHourPerWeek($table['Hour_Per_Week']);
    $location->setCity($table['City']);
    $internship->setStartingDate($table['Starting_Date']);
    $internship->setDuration($table['Duration']);

    $this->entityManager->persist($internship);
    $this->entityManager->flush();

    return $response->withStatus(200);
}

public function delInternshipManagement(Request $request, Response $response, int $id): Response
{
    $internship = $this->entityManager->getRepository(Internship::class)->findOneBy(['ID_Internship' => $id]);
    $internship->setDel(1);
    $this->entityManager->persist($internship);
    $this->entityManager->flush();
    $response->getBody()->write("Internship deleted successfully");

    return $response;
}
}