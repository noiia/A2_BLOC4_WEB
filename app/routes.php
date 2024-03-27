<?php

declare(strict_types=1);

//use \src\Application\Actions\User\ListUsersAction;
//use \src\Application\Actions\User\ViewUserAction;
use App\Controller\InternshipController;
use App\Entity\Appliement_WishList;
use App\Entity\Internship;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/../src/Controller/InternshipController.php";

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Twig($loader);
$container = require_once __DIR__ . '/../bootstrap.php';

return function (App $app) {
    global $twig;
    global $container;

    $app->get('/Stage', function (Request $request, Response $response) use ($twig, $container){
        $controller = new InternshipController($twig);
        $welcomeResponse = $controller->Welcome($request, $response,[], $container);
        return $welcomeResponse;
    });

    $app->get('/Stage/{i}', function (Request $request, Response $response, array $args) use ($container) {

        $entityManager = $container->get(EntityManager::class);
        $internship = $entityManager->getRepository(Internship::class)->findOneBy(['ID_Internship' => $args['i']]);
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
        if ($internship->getAppliementWishlist() != null){
            foreach ($internship->getAppliementWishlist() as $appliement) {
                if ($appliement->getStatus() == 2){
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
            ];

            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Stage introuvable');
        }
    });

    $app->get('/Stage/Filtre/{search}', function (Request $request, Response $response, array $args) use ($container){
        $entityManager = $container->get(EntityManager::class);
        $search = explode('=', $args['search']);
        $entity = null;
        if ($search[0] === 'Skills') {
            $entity = $entityManager->getRepository(\App\Entity\Skills::class)->findOneBy(['Name' => $search[1]]);
            if ($entity != null){$data = ['id' => $entity->getIDSkills(), 'name' => $entity->getName(),];}
        }
        elseif ($search[0] === 'locations'){
            $entity = $entityManager->getRepository(\App\Entity\Location::class)->findOneBy(['City' => $search[1]]);
            if ($entity != null){$data = ['id'=>$entity->getIDLocation(), 'name'=>$entity->getCity()];}
        }
        elseif ($search[0] === 'companies'){
            $entity = $entityManager->getRepository(\App\Entity\Company::class)->findOneBy(['Name' => $search[1]]);
            if ($entity != null){$data = ['id'=>$entity->getIDCompany(), 'name'=>$entity->getName()];}
        }
        if ($entity != null) {
            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('entitee introuvable');
        }

    });

    /*$app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });*/



};
