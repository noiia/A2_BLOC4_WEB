<?php

declare(strict_types=1);

//use \src\Application\Actions\User\ListUsersAction;
//use \src\Application\Actions\User\ViewUserAction;
use App\Controller\CompanyController;
use App\Controller\InternshipController;
use App\Entity\Appliement_WishList;
use App\Entity\Company;
use App\Entity\Internship;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/../src/Controller/InternshipController.php";

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Twig($loader);
$container = require_once __DIR__ . '/../bootstrap.php';

return function (App $app) {
    global $twig;
    global $container;
    /*$app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });*/

    $app->addBodyParsingMiddleware();
    $app->add(function (Request $request, RequestHandlerInterface $handler): Response {
        $routeContext = RouteContext::fromRequest($request);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

        $response = $handler->handle($request);

        $response = $response->withHeader('Access-Control-Allow-Origin', '*');
        $response = $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
        $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);
        $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

        return $response;
    });
    $app->addRoutingMiddleware();

    $app->get('/Stage', function (Request $request, Response $response) use ($twig, $container){
        $controller = new InternshipController($twig);
        $welcomeResponse = $controller->Welcome($request, $response,[], $container);
        return $welcomeResponse;
    });

    $app->get('/Stage/{id}', function (Request $request, Response $response, array $args) use ($container) {

        $entityManager = $container->get(EntityManager::class);
        $internship = $entityManager->getRepository(Internship::class)->findOneBy(['ID_Internship' => $args['id']]);
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
                'logo_path' => $internship->companies->getCompanyLogoPath(),
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
        $companyResponse = $controller->Company($request, $response,[], $container);
        return $companyResponse;
    });
    $app->get('/Entreprise/api/{id}', function (Request $request, Response $response, array $args) use ($container) {

        $entityManager = $container->get(EntityManager::class);
        $company = $entityManager->getRepository(Company::class)->findOneBy(['ID_company' => $args['id']]);


        $m = 0;
        $Sectors = [];
        $second = null;
        foreach ($company->getSector() as $sector){
            if ($m <= 6){
                $m++;
                if($m%2 != 0) {
                    $second = $sector->getName();
                } else if ($m%2 == 0 && $second != null) {
                    $Sectors[] = [$sector->getName(), $second];
                    $second = null;
                }
            } else {
                break;
            }
        }
        if ($second != null)
        {
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
        if ($company->getRates() != null){
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
        if($company->getCompanyLogoPath() != null){
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
    });

    $app->post('/Entreprise/addComment', function (Request $request, Response $response, array $args) use ($twig, $container) {
        $controller = new CompanyController($twig);
        $companyResponse = $controller->addComment($request, $response);
        return $companyResponse;
    });
    $app->get('/Statistique/Entreprises', function (Request $request, Response $response, array $args) use ($twig, $container) {
        $controller = new CompanyController($twig);
        $companyResponse = $controller->Company($request, $response,[], $container);
        return $companyResponse;
    });
        /*$app->group('/users', function (Group $group) {
            $group->get('', ListUsersAction::class);
            $group->get('/{id}', ViewUserAction::class);
        });*/
};
