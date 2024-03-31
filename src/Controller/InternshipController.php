<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Location;
use App\Entity\Skills;
use DI\Container;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

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
        //chercher quelle filtre est actif
        $params = $request->getQueryParams();
        $criteria = Criteria::create();
        $list = ["locations"=>'O', "companies"=>'O',"Starting_date"=>'D', "Duration"=>'B', "Max_places"=>'B', "Hourly_rate"=>'B', "Title"=>'C', "ID_Internship"=>'E'];

        foreach ($list as $item=>$value){
            if (array_key_exists($item, $params)){
                $mm = explode(';', $params[$item]);
                if ($value === 'B'){ //est un between
                    if ($mm[0] !== ''){$criteria->Where(Criteria::expr()->gte($item, (int) $mm[0]));}
                    if ($mm[1] !== ''){$criteria->andWhere(Criteria::expr()->lte($item, (int) $mm[1]));}
                }
                elseif ($value === 'D'){ //est un between
                    if ($mm[0] !== ''){$criteria->Where(Criteria::expr()->gte($item, date_create($mm[0])));}
                    if ($mm[1] !== ''){$criteria->andWhere(Criteria::expr()->lte($item, date_create($mm[1])));}
                }
                elseif ($value === 'O') {
                    $array = array();
                    $class = ['locations' => Location::class, 'companies' => Company::class][$item];
                    foreach ($mm as $v) {
                        array_push($array, Criteria::expr()->eq($item, $this->entityManager->find($class, $v)));
                    }
                    $criteria->andWhere(Criteria::expr()->orX(...$array));
                }
                elseif ($value === 'C'){
                    $criteria->andWhere(Criteria::expr()->contains($item, '%'.$params[$item].'%'));
                }
                elseif ($value === 'E'){
                    $criteria->andWhere(Criteria::expr()->eq($item, $params[$item]));
                }
            }
        }
        $internships = $this->entityManager->getRepository(Internship::class)->matching($criteria);
        if (array_key_exists("skills", $params)) {
            foreach ($internships as $internship) {
                $have = false;
                foreach (explode(';', $params['skills']) as $skillID) {
                    if ($internship->getSkills()->contains($this->entityManager->find(Skills::class, $skillID))) {$have = true;break;}
                }
                if (!$have){$internships->removeElement($internship);}
            }
        }
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
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Welcome/Welcome.html.twig', [
            'internships' => $runwayBubbles,
        ]);
    }

    public function InternshipApi(Request $request, Response $response, int $id)
    {


        $internship = $this->entityManager->getRepository(Internship::class)->findOneBy(['ID_Internship' => $id]);
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
        if ($internship->getAppliementWishlist() != null) {
            foreach ($internship->getAppliementWishlist() as $appliement) {
                if ($appliement->getStatus() == 2) {
                    $j++;
                }
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
            ];

            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Stage introuvable');
        }
    }

    public function InternshipFilterApi(Request $request, Response $response, string $arg)
    {
        $search = explode('=', $arg);
        $entity = null;
        if ($search[0] === 'Skills') {
            $entity = $this->entityManager->getRepository(Skills::class)->findOneBy(['Name' => $search[1]]);
            if ($entity != null){$data = ['id' => $entity->getIDSkills(), 'name' => $entity->getName(),];}
        }
        elseif ($search[0] === 'locations'){
            $entity = $this->entityManager->getRepository(Location::class)->findOneBy(['City' => $search[1]]);
            if ($entity != null){$data = ['id'=>$entity->getIDLocation(), 'name'=>$entity->getCity()];}
        }
        elseif ($search[0] === 'companies'){
            $entity = $this->entityManager->getRepository(Company::class)->findOneBy(['Name' => $search[1]]);
            if ($entity != null){$data = ['id'=>$entity->getIDCompany(), 'name'=>$entity->getName()];}
        }
        if ($entity != null) {
            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('entitee introuvable');
        }
    }
}