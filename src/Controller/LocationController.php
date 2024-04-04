<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Location;
use App\Entity\Rate;
use App\Entity\Users;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LocationController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    function addLocation(Request $request, Response $response): Response
    {
        $json = $request->getParsedBody();

        if (isset($json['street'], $json['zipCode'], $json['city'])) {
            $street = $json['street'];
            $zipcode = $json['zipCode'];
            $city = $json['city'];


            $entity = new Location();
            $entity->setStreet($street);
            $entity->setZipCode($zipcode);
            $entity->setCity($city);
            $entity->setDepartement($zipcode[0] . $zipcode[1]);
            $entity->setDel(0);

            $this->entityManager->persist($entity);

            $this->entityManager->flush();

            $lastEntry = $this->entityManager->getRepository(Location::class)->findOneBy([], ['ID_location' => 'DESC']);
            $response->getBody()->write(json_encode(['success' => true, 'id' => $lastEntry->getIDLocation()]));
            return $response->withHeader('content-type', 'application-json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(['success' => false]));
            return $response->withHeader('content-type', 'application-json')->withStatus(501);
        }
    }

    function apiLocation(Request $request, Response $response, int $id)
    {
        $location = $this->entityManager->getRepository(Location::class)->findOneBy(["ID_location" => $id]);
        if ($location) {
            $data = [
                'street' => $location->getStreet(),
                'zipcode' => $location->getZipCode(),
                'id' => $location->getIDLocation()
            ];
            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Emplacement géographique introuvable');
        }
    }
}