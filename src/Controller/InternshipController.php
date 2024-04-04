<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Workflow;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Entity\Internship;

class InternshipController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function Welcome(Request $request, Response $response): Response
    {
        $user = $request->getAttribute("user");
        $internships = $this->entityManager->getRepository(Internship::class)->findAll();

        $runwayBubbles = [];
        $sixSkills = [];
        if ($internships) {
            foreach ($internships as $forInternship) {
                $i = 0;
                $threeSkills = [];
                foreach ($forInternship->getSkills() as $skill) {
                    $i++;
                    if ($i <= 3) {
                        $threeSkills[] = $skill->getName();
                    } else {
                        break;
                    }
                }
                $runwayBubbles[] =
                    [
                        'id' => $forInternship->getIDInternship(),
                        'job' => $forInternship->getTitle(),
                        'school_grade' => $forInternship->promotions->getName(),
                        'company' => $forInternship->companies->getName(),
                        'location' => $forInternship->locations->getCity(),
                        'begin_date' => $forInternship->getStartingDate(),
                        'duration' => $forInternship->getDuration() . ' semaines',
                        'competence_1' => $threeSkills[0],
                        'competence_2' => $threeSkills[1],
                        'competence_3' => $threeSkills[2],
                    ];
            }
        }
        $name[] = [
            'name' => $user->getName(),
            'surname' => $user->getSurname()
        ];
        $role = $user->getRole();

        return $this->twig->render($response, 'Welcome/Welcome.html.twig', [
            'internships' => $runwayBubbles,
            'names' => $name,
            'role' => $role
        ]);
    }

    public function InternshipApi(Request $request, Response $response, int $id)
    {
        $userSession = $request->getAttribute("user");

        $internship = $this->entityManager->getRepository(Internship::class)->findOneBy(['ID_Internship' => $id]);
        $user = $this->entityManager->getRepository(Users::class)->findOneBy(['ID_users' => $userSession->getIDUsers()]);
        $workflow = $this->entityManager->getRepository(Workflow::class)->findBy(['internship' => $id]);

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
        $j = 0;
        if ($workflow !== null) {
            foreach ($workflow as $appliement) {
                if ($appliement->getStatus() == 2) {
                    $j++;
                }
            }
        }

        $isAWish = false;
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('u', 'wish')
            ->from('App\Entity\Users', 'u')
            ->join('u.wishlist', 'wish')
            ->where('u.ID_users = :ID_users')
            ->andWhere('wish.ID_Internship = :wishlistId') // Utilisez la propriété de l'entité Wishlist
            ->setParameter('ID_users', $user->getIDUsers())
            ->setParameter('wishlistId', $id);
        if ($qb->getQuery() != null) {
            $result = $qb->getQuery()->getResult();
            if ($result != null) {
                $isAWish = true;
            }
        }

        if ($internship != null) {
            $data = [
                'id' => $internship->getIDInternship(),
                'job' => $internship->getTitle(),
                'school_grade' => $internship->promotions->getName(), // Utilisez les méthodes getters pour accéder aux propriétés
                'company' => $internship->companies->getName(),
                'location' => $internship->locations->getCity(),
                'begin_date' => $internship->getStartingDate(),
                'hour_payment' => $internship->getHourlyRate(),
                'week_payment' => $internship->getHourPerWeek() * $internship->getHourlyRate(),
                'duration' => $internship->getDuration() . ' semaines  ' . $internship->getHourPerWeek() . ' h/semaine',
                'taken_places' => $j,
                'max_places' => $internship->getMaxPlaces(),
                'advantages' => $internship->getAdvantages(),
                'description' => $internship->getDescription(),
                'skills' => $Skills,
                'logo_path' => $internship->companies->getCompanyLogoPath(),
                'isAWish' => $isAWish,
            ];

            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Stage introuvable');
        }
    }

    public function test(Request $request, Response $response, int $id)
    {
        return $response;
    }
}