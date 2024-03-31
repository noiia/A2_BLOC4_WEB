<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Internship;
use App\Entity\Location;
use App\Entity\Rate;
use App\Entity\Sector;
use App\Entity\Skills;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
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
        $params = $request->getQueryParams();
        $criteria = Criteria::create();
        $list = ["locations"=>'O', "Name"=>'C', "ID_company"=>'E'];

        foreach ($list as $item=>$value){
            if (array_key_exists($item, $params)){
                $mm = explode(';', $params[$item]);
                if ($value === 'O') {
                    $array = array();
                    $class = ['locations' => Location::class][$item];
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

        $companies = $this->entityManager->getRepository(Company::class)->matching($criteria);
        //nb d'etudiants recu
        if (array_key_exists("sector", $params)) {
            foreach ($companies as $company) {
                $have = false;
                foreach (explode(';', $params['skills']) as $skillID) {
                    if ($company->getSkills()->contains($this->entityManager->find(Skills::class, $skillID))) {$have = true;break;}
                }
                if (!$have){$companies->removeElement($company);}
            }
        }
        if (array_key_exists("rates", $params)){
            foreach ($companies as $company){
                $avg = array_map(function ($element){return $element->getNote();}, $company->getRates()->toArray());
                if (array_sum($avg)/count($avg) <= $params['rates']){$companies->removeElement($company);}
            }
        }
        if (array_key_exists("users", $params)){
            $mm = explode(';', $params['users']);
            if ($mm[0] === ''){$mm[0] = 0;}
            else {$mm[0] = (int)$mm[0];}
            if ($mm[1] === ''){$mm[1] = INF;}
            else {$mm[1] = (int)$mm[1];}
            var_dump($mm);
            foreach ($companies as $company){
                //compte le nb de students ayant ete dans l'entreprise
                $nbStudents = array_sum($company->getInternship()->map(function ($element){//tous les stages dans l'entreprise
                    return array_sum($element->getAppliementWishlist()->map(function ($element){//tous les postulants des stags
                        if ($element->getStatus() === 2 || $element->getStatus() === 4){return 1;}//ceux qui sont ou ont ete dans le stage
                        else {return 0;}
                    })->toArray());//met en array pour faire la somme
                })->toArray());//met en array pour faire la somme
                if ($nbStudents < $mm[0] || $nbStudents > $mm[1]){$companies->removeElement($company);}
            }
        }

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
        $n = 0;
        $p = 0;
        foreach ($company->getInternship() as $internship) {
            $p++;
            $Internships[] =
                [
                    'id'=>$internship->getIDInternship(),
                    'title' => $internship->getTitle(),
                    'location' => $internship->locations->getCity(),
                    'starting_date' => $internship->getStartingDate(),
                    'duration' => $internship->getDuration(),
                ];
            foreach ($internship->getAppliementWishlist() as $apply){if ($apply->getStatus() === 2 || $apply->getStatus() === 4){$n++;}}
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
                'number_former_intern' => $n,
                'description' => $company->getCompanyDescription(),
                'sector' => $Sectors,
                'internship' => $Internships,
                'comment' => $Comments,
                'number_of_internship' => $p,
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

    public function CompanyFilterApi(Request $request, Response $response, string $arg)
{
    $search = explode('=', $arg);
    $entity = null;
    if ($search[0] === 'locations'){
        $entity = $this->entityManager->getRepository(Location::class)->findOneBy(['City' => $search[1]]);
        if ($entity != null){$data = ['id'=>$entity->getIDLocation(), 'name'=>$entity->getCity()];}
    }
    elseif ($search[0] === 'sector'){
        $entity = $this->entityManager->getRepository(Sector::class)->findOneBy(['Name' => $search[1]]);
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