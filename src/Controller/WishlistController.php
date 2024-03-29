<?php

namespace App\Controller;

use App\Entity\Appliement_WishList;
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
        $user = $request->getAttribute("user");
        $wishlist = $this->entityManager->getRepository(Appliement_WishList::class)->findBy(['Status' => 5, 'users' => $user->getIDUsers(), 'Del' => 0]);
        if ($wishlist != null) {
            foreach ($wishlist as $forWishlist) {
                $data[] = [
                    'internshipID' => $forWishlist->internships->getIDInternship(),
                    'job' => $forWishlist->internships->getTitle(),
                    'company' => $forWishlist->internships->companies->getName(),
                    'wishlistID' => $forWishlist->getIDAppliementWishlist(),
                ];
            }
            return $this->twig->render($response, 'Wishlist/Wishlist.html.twig', [
                'internships' => $data,
            ]);
        } else {
            return $this->twig->render($response, 'Wishlist/Wishlist.html.twig');
        }
    }

    public function deleteInternshipFromWishlist(Request $request, Response $response, int $id): Response
    {
        $user = $request->getAttribute("user");
        $wishlist = $this->entityManager->getRepository(Appliement_WishList::class)->findOneBy(['Status' => 5, 'ID_Appliement_Wishlist' => $id, 'users' => $user->getIDUsers(), 'Del' => 0]);
        if ($wishlist !== null) {
            $wishlist->setDel(1);
            $this->entityManager->flush();
        }
        return $this->twig->render($response, 'Wishlist/Wishlist.html.twig');
    }
}