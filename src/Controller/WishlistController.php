<?php

namespace App\Controller;

use App\Entity\Appliement_WishList;
use App\Entity\Internship;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RKA\Session;

class WishlistController
{
    private $twig;
    private EntityManager $entityManager;
    private Session $session;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
        $this->session = new Session();
    }

    public function Wishlist(Request $request, Response $response): Response
    {
        $user = $request->getAttribute("user");
        $wishlist = $this->entityManager->getRepository(Appliement_WishList::class)->findBy(['Status' => 5, 'users' => $user->getIDUsers()]);
        if ($wishlist != null) {
            foreach ($wishlist as $forWishlist) {
                $data[] = [
                    'id' => $forWishlist->internships->getIDInternship(),
                    'job' => $forWishlist->internships->getTitle(),
                    'company' => $forWishlist->internships->companies->getName(),
                ];
            }
            return $this->twig->render($response, 'Wishlist/Wishlist.html.twig', [
                'internships' => $data,
            ]);
        } else {
            return $this->twig->render($response, 'Wishlist/Wishlist.html.twig');
        }
    }
}