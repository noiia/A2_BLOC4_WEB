<?php

declare(strict_types=1);

//use \src\Application\Actions\User\ListUsersAction;
//use \src\Application\Actions\User\ViewUserAction;
use App\Controller\CompanyController;
use App\Controller\InternshipController;
use App\Controller\ProfileController;
use App\Controller\StudentsController;
use App\Entity\Appliement_WishList;
use App\Entity\Internship;

use App\Entity\Users;
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
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/Stage', function (Request $request, Response $response) use ($twig, $container) {
        $controller = new InternshipController($twig);
        $welcomeResponse = $controller->Welcome($request, $response, [], $container);
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
            ];

            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Stage introuvable');
        }
    });
    $app->get('/Entreprise', function (Request $request, Response $response, array $args) use ($twig, $container) {
        $controller = new CompanyController($twig);
        $companyResponse = $controller->Company($request, $response, [], $container);
        return $companyResponse;
    });
    //----------- DEBUT PROFIL --------------//
    $app->get('/Profil', function (Request $request, Response $response) use ($twig, $container) {
        $controller = new ProfileController($twig);
        $profileResponse = $controller->Profile($request, $response, [], $container);
        return $profileResponse;
    });

    $app->get('/Profil/{i}', function (Request $request, Response $response, array $args) use ($container) {

        $entityManager = $container->get(EntityManager::class);
        $User = $entityManager->getRepository(Users::class)->findOneBy(['ID_users' => $args['i']]);
        if ($User != null) {
            $data = [
                'ID_users' => $User->getIDUsers(),
                'Name' => $User->getName(),
                'Surname' => $User->getSurname(),
                'Birth_date' => $User->getBirthDate(),
                'Profile_Description' => $User->getProfileDescription(),
                'Email' => $User->getEmail(),
            ];
            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Erreur d affichage du profil');
        }

    });
    /*$app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });*/


    /* -------------------------- DEBUT STUDENTS MANAGEMENT -------------------- */
    $app->get('/Etudiants', function (Request $request, Response $response) use ($twig, $container) {
        $controller = new StudentsController($twig);
        $studentResponse = $controller->Students($request, $response, [], $container);
        return $studentResponse;
    });

    $app->get('/Etudiants/{i}', function (Request $request, Response $response, array $args) use ($container) {

        $entityManager = $container->get(EntityManager::class);
        $student = $entityManager->getRepository(Users::class)->findOneBy(['ID_users' => $args['i']]);
        $tempPromotion = "";
        foreach ($student->getPromotions() as $promotions) {
            $tempPromotion = $promotions->getName();
        }
        if ($student != null) {
            $data = [
                'ID_users' => $student->getIDUsers(),
                'Name' => $student->getName(),
                'Surname' => $student->getSurname(),
                'Birth_date' => $student->getBirthDate()->format('Y-m-d'),
                'Profile_Description' => $student->getProfileDescription(),
                'Email' => $student->getEmail(),
                'Role' => $student->getRole(),
                'Promotion' => $tempPromotion,
            ];

            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Etudiant introuvable');
        }
    });

};