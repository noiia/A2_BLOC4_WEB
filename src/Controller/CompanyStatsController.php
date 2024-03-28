<?php

namespace App\Controller;

use App\Entity\Company;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class CompanyStatsController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function CompanyStats(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'CompanyStats/CompanyStats.html.twig');
    }
}