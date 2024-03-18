<?php

namespace App\EventSubscriber;

use \src\EventListener\ExceptionListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/*
 * la classe suivante important la fonction getSubscribedEvents() de EventSubscriberInterface, va créer des éléments d'écoute et
 * automatiquement instanciés dans le fichier Yaml les informations d'évènement et leurs conséquences données en return, ici les events
 * foo et except pour les fonctions liées et leur ordre de priorité.
*/
class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        ## les valeurs numériques correspondent à l'ordre de priorité, les prioritées sont définies entre -255 et 255 et la plus forte est 0
        return [
            'foo' => [
                ['doSomething', 10],
                ['doOtherThing', 0],
            ],
            'except' => [
                ['doExceptionThing', -10]
            ],
        ];
    }
    public function doSomething() {}
    public function doOtherThing(){}
    public function doExceptionThing(ExceptionListener $event) {}

    /*
     *  kernel.request : envoyé avant que le contrôleur ne soit déterminé, au plus tôt dans le cycle de vie.
     *  kernel.controller : envoyé après détermination du contrôleur, mais avant son exécution.
     *  kernel.response : envoyé après que le contrôleur retourne un objet Response.
     *  kernel.terminate : envoyé après que la réponse est envoyée à l'utilisateur.
     *  kernel.exception : envoyé si une exception est lancée par l'application.
     */
}