<?php

namespace App\Controller;

use App\Entity\Internship;
use App\Entity\Users;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class WishlistController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function Wishlist(Request $request, Response $response): Response
    {
        $userSession = $request->getAttribute("user");
        $users = $this->entityManager->getRepository(Users::class)->findOneBy(['ID_users' => $userSession->getIDUsers()]);
        $internships = $users->getWishlist();
        
        $internshipInWishlist = [];
        if ($internships != null) {
            foreach ($internships as $internship) {
                $internshipInWishlist[] =
                    [
                        'internshipID' => $internship->getIDInternship(),
                        'job' => $internship->getTitle(),
                        'company' => $internship->companies->getName()
                    ];
            }
            $role = $users->getRole();
            return $this->twig->render($response, 'Wishlist/Wishlist.html.twig', [
                'role' => $role,
                'internships' => $internshipInWishlist,
            ]);
        } else {
            return $this->twig->render($response, 'Wishlist/Wishlist.html.twig');
        }
    }

    public function deleteInternshipFromWishlist(Request $request, Response $response, int $id): Response
    {
        $userSession = $request->getAttribute("user");

        $user = $this->entityManager->find(Users::class, $userSession->getIDUsers());
        $wishlist = $this->entityManager->find(Internship::class, $id);

        $user->removeWishlist($wishlist);

        $this->entityManager->flush();
        return $response;
    }

    public function addInternshipToWishlist(Request $request, Response $response, int $id): Response
    {
        $userSession = $request->getAttribute("user");
        $user = $this->entityManager->find(Users::class, $userSession->getIDUsers());
        if ($user) {
            $internship = $this->entityManager->find(Internship::class, $id);
            if ($internship) {
                $user->getWishlist()->add($internship);
                $this->entityManager->flush();
                return $response->withStatus(201);
            } else {
                $response->getBody()->write("L'internship avec l'ID $id n'a pas été trouvé.");
                return $response->withStatus(404);
            }
        } else {
            $response->getBody()->write("Utilisateur non trouvé.");
            return $response->withStatus(404);
        }
    }
}