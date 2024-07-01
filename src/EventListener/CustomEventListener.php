<?php

namespace App\EventListener;

use App\Event\CustomEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: CustomEvent::class, method: 'onCustomEvent')]
final class CustomEventListener
{
    public function __construct(
        private readonly LoggerInterface $loggerInterface
        ){
        
    }
    public function onCustomEvent(CustomEvent $event): void
    {
        $this->loggerInterface->info("A custom event:  {$event->getDateTime()->getTimestamp()}");
    }
}
