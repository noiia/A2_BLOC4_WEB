<?php

namespace App\Controller;

use App\Entity\Appliement_WishList;
use App\Entity\Internship;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RKA\Session;

class PostulationController
{
    private $twig;
    private EntityManager $entityManager;
    private Session $session;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function Postulation(Request $request, Response $response): Response
    {
        $user = $request->getAttribute("user");
        $postulation = $this->entityManager->getRepository(Appliement_WishList::class)->findBy(['Status' => 1, 'users' => $user->getIDUsers(), 'Del' => 0]);
        if ($postulation != null) {
            foreach ($postulation as $forPostulation) {
                $data[] = [
                    'id' => $forPostulation->internships->getIDInternship(),
                    'job' => $forPostulation->internships->getTitle(),
                    'company' => $forPostulation->internships->companies->getName(),
                    'wishlistID' => $forPostulation->getIDAppliementWishlist(),
                ];
            }
            return $this->twig->render($response, 'Postulation/Postulation.html.twig', [
                'internships' => $data,
            ]);
        } else {
            return $this->twig->render($response, 'Postulation/Postulation.html.twig');
        }
    }}
