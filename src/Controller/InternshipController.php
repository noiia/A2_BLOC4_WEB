<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Location;
use Cassandra\Date;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Expression;
use UMA\DIC\Container;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

use App\Entity\Internship;
use App\Entity\Skills;
use function DI\add;

class InternshipController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function Welcome(Request $request, Response $response, array $args, Container $container): Response
    {
        $entityManager = $container->get(EntityManager::class);

        //chercher quelle filtre est actif
        $params = $request->getQueryParams();
        $criteria = Criteria::create();
        $list = ["locations"=>'O', "companies"=>'O',"Starting_date"=>'D', "Duration"=>'B', "Max_places"=>'B', "Hourly_rate"=>'B', "Title"=>'C'];

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
                        array_push($array, Criteria::expr()->eq($item, $entityManager->find($class, $v)));
                    }
                    $criteria->andWhere(Criteria::expr()->orX(...$array));
                }
                elseif ($value === 'C'){
                    $criteria->andWhere(Criteria::expr()->contains($item, '%'.$params[$item].'%'));
                }
            }
        }
        $internships = $entityManager->getRepository(Internship::class)->matching($criteria);
        if (array_key_exists("skills", $params)) {
            foreach ($internships as $internship) {
                $have = false;
                foreach (explode(';', $params['skills']) as $skillID) {
                    if ($internship->getSkills()->contains($entityManager->find(Skills::class, $skillID))) {$have = true;break;}
                }
                if (!$have){$internships->removeElement($internship);}
            }
        }
        $runwayBubbles = [];
        if ($internships) {
            foreach ($internships as $forInternship) {
                $i = 0;
                $threeSkills = [];
                foreach ($forInternship->getSkills() as $skill) {
                    $i++;
                    if ($i <= 3) {$threeSkills[] = $skill->getName();}
                    else {break;}
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
    public function Entreprise(Request $request, Response $response, array $args): Response
    {
        $view = Twig::fromRequest($request);
        return $this->twig->render($response, 'Entreprises/Entreprises.html.twig');
    }
}