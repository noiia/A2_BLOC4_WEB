<?php

namespace App\Controller;


use App\Entity\Users;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

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
        $internshipManag = $this->entityManager->getRepository(Internship::class)->findAll();
        $data = [];
        if ($internshipManag) {
            foreach ($internshipManag as $forInternshipManag) {
                $data[] = [
                    'id' => $forInternshipManag->getIDInternship(),
                    'job' => $forInternshipManag->getTitle(),
                ];
            }
        }
        return $this->twig->render($response, 'InternshipManagement/InternshipManagement.html.twig', [
            'internships' => $data,
        ]);
    }
}