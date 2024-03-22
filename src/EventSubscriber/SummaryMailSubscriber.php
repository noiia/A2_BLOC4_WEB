<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/*
 * Ecoute la page et execute la fonction sendProductPaidMail quand l'action se termine
 */

class SummaryMailSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::TERMINATE =>[
                ['sendProductPaidMail',0],
            ],
        ];
    }
    public function sendProductPaidMail(TerminateEvent $event){

    }
}