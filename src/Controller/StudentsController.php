<?php


namespace App\Controller;

use App\Entity\Location;
use App\Entity\Promotion;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


use App\Entity\Users;

class StudentsController
{
    private $twig;
    private EntityManager $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
        $this->entityManager = $container->get(EntityManager::class);
    }

    public function Students(Request $request, Response $response): Response
    {
        $students = $this->entityManager->getRepository(Users::class)->findAll();
        $promotions = $this->entityManager->getRepository(Promotion::class)->findAll();

        $runwayStudents = [];
        foreach ($students as $forStudent) {
            $runwayStudents[] = [
                'ID_users' => $forStudent->getIDUsers(),
                'Name' => $forStudent->getName(),
                'Surname' => $forStudent->getSurname(),
                'Birth_date' => $forStudent->getBirthDate()->format('d-m-Y'),
                'Profile_Description' => $forStudent->getProfileDescription(),
                'Email' => $forStudent->getEmail(),
                'Role' => $forStudent->getRole(),
                'Del' => $forStudent->isDel(),
            ];
        }
        $differentPromotions = [];
        $locations = [];
        foreach ($promotions as $forPromotions) {
            $differentPromotions[] = [
                'ID_promotion' => $forPromotions->getIDPromotion(),
                'Name' => $forPromotions->getName(),
            ];
            $locations[] = [
                'city' => $forPromotions->location->getCity()
            ];
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, 'Students/Students.html.twig', [
            'students' => $runwayStudents,
            'promotions' => $differentPromotions,
            'locations' => $locations,
        ]);
    }

    public function StudentsApi(Request $request, Response $response, int $id)
    {
        $student = $this->entityManager->getRepository(Users::class)->findOneBy(['ID_users' => $id]);
        $tempPromotion = [];
        foreach ($student->getPromotions() as $promotions) {
            $tempPromotion["promotionName"] = $promotions->getName();
            $tempPromotion["promotionLocation"] = $promotions->location->getCity();
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
                'location' => $tempPromotion['promotionLocation'],
                'Promotion' => $tempPromotion['promotionName'],
                'Del' => $student->isDel(),
            ];

            $payload = json_encode($data);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Etudiant introuvable');
        }
    }

    function generatePassword()
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789()[]#@/.';
        $password = '';
        $charsLength = strlen($chars);
        for ($i = 0; $i < 10; $i++) {
            $password .= $chars[rand(0, $charsLength - 1)];
        }
        return $password;
    }

    function sendLoginsMail($to, $login, $password)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = 'smtp.gmail.com';
            $mail->Username = 'projetweb658@gmail.com';
            $mail->Password = 'quip gpmh zeha lnoh';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('projetweb658@gmail.com', 'noreplyInternet');
            $mail->addAddress($to, 'Destinataire');

            $mail->isHTML(true);
            $mail->Subject = 'Logins';
            $mail->Body = 'Bonjour,<br>Voici vos nouveaux identifiants pour le site Inter-net.<br>Login : ' . $login . '<br>Password : ' . $password . '<br><br><br>Gardez-les et ne les partagez pas.<br>Bien cordialement,<br><br>L\'équipe de développement.';

            $mail->send();
            echo 'L\'e-mail a été envoyé avec succès.';
        } catch (Exception $e) {
            echo 'Erreur lors de l\'envoi de l\'e-mail : ', $mail->ErrorInfo;
        }
    }

    function addStudents(Request $request, Response $response)
    {
        $jsonTable = $request->getBody();

        $table = json_decode($jsonTable, true);

        $user = new Users();

        $user->setName($table['Name']);
        $user->setSurname($table['Surname']);

        $login = $table['Name'] . "." . $table['Surname'];
        $user->setLogin($login);

        $password = $this->generatePassword();
        $user->setPassword(hash('sha512', $password));

        $date = date_create($table['Date'], new DateTimeZone('UTC'));
        $user->setBirthDate($date);
        
        $user->setProfileDescription($table['Description']);
        $user->setEmail($table['Email']);
        $user->setRole(1);
        $user->setDel(0);

        $idPromotion = $table['idPromotion'];

        $promotion = $this->entityManager->getRepository(Promotion::class)->findOneBy(["ID_promotion" => $idPromotion]);
        if ($promotion !== null) {
            $user->getPromotions()->add($promotion);
        } else {
            $response->getBody()->write("Promotion not found");
            return $response->withStatus(404);
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        //$this->sendLoginsMail($table['Email'], $login, $password);

        $response->getBody()->write("Login: " . $login . " Password: " . $password);
        return $response->withStatus(200);
    }

    function updateStudents(Request $request, Response $response)
    {
        $jsonTable = $request->getBody();

        $table = json_decode($jsonTable, true);

        $user = $this->entityManager->getRepository(Users::class)->findOneBy(["ID_users" => $table["ID_users"]]);
        $user->setName($table['Name']);
        $user->setSurname($table['Surname']);
        $login = $table['Name'] . "." . $table['Surname'];
        $user->setLogin($login);
        $password = $this->generatePassword();
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $date = date_create($table['Date'], new DateTimeZone('UTC'));
        $user->setBirthDate($date);
        $user->setProfileDescription($table['Description']);
        $user->setEmail($table['Email']);
        $user->setRole(1);
        $user->setDel(0);

        $idPromotion = $table['idPromotion'];

        $promotion = $this->entityManager->getRepository(Promotion::class)->findOneBy(["ID_promotion" => $idPromotion]);
        if ($promotion !== null) {
            $user->getPromotions()->add($promotion);
        } else {
            $response->getBody()->write("Promotion not found");
            return $response->withStatus(404);
        }
    }

    function delStudents(Request $request, Response $response, int $id)
    {
        $student = $this->entityManager->getRepository(Users::class)->findOneBy(['ID_users' => $id]);
        $student->setDel(1);
        $this->entityManager->persist($student);
        $this->entityManager->flush();
        $response->getBody()->write("student deleted successfully");
        return $response;
    }

    function locatePromotion(Request $request, Response $response, int $id)
    {
        $promotion = $this->entityManager->getRepository(Promotion::class)->findOneBy(['ID_promotion' => $id]);

        if ($promotion != null) {
            $campus = $promotion->location->getCity();
            $payload = json_encode($campus);

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            return $response->withStatus(404)->getBody()->write('Promotion introuvable');
        }
    }
}