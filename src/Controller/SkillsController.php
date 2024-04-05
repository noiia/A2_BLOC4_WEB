<?php

namespace App\Controller;

use App\Entity\Skills;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SkillsController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    function addSkill(Request $request, Response $response): Response
    {
        $json = $request->getParsedBody();

        if (isset($json['skill'])) {
            $entity = new Skills();
            $entity->setName($json['skill']);
            $entity->setDel(0);

            $this->entityManager->persist($entity);

            $this->entityManager->flush();

            $lastEntry = $this->entityManager->getRepository(Skills::class)->findOneBy([], ['ID_skills' => 'DESC']);
            $response->getBody()->write(json_encode(['success' => true, 'id' => $lastEntry->getIDSkills()]));
            return $response->withHeader('content-type', 'application-json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(['success' => false]));
            return $response->withHeader('content-type', 'application-json')->withStatus(501);
        }
    }

    function apiSkill(Request $request, Response $response, int $id)
    {
        $skill = $this->entityManager->getRepository(Skills::class)->findOneBy(["ID_skills" => $id, "Del" => 0]);
        if ($skill) {
            $data = [
                'name' => $skill->getName(),
                'id' => $skill->getIDSkills()
            ];
            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Compétence introuvable');
        }
    }

    function delSkill(Request $request, Response $response): Response
    {
        $json = $request->getParsedBody();

        if (isset($json['id'])) {
            $entity = $this->entityManager->getRepository(Skills::class)->findOneBy(["ID_skills" => $json['id']]);
            $entity->setDel(1);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            return $response->withHeader('content-type', 'application-json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(['success' => false]));
            return $response->withHeader('content-type', 'application-json')->withStatus(501);
        }
    }
}