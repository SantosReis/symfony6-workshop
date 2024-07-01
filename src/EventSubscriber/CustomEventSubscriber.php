<?php

namespace App\EventSubscriber;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CustomEventSubscriber implements EventSubscriberInterface
{
  public function __construct(
    private readonly LoggerInterface $loggerInterface
  )
  {

  }

  public static function getSubscribedEvents(): array
  {
    return [
        KernelEvents::RESPONSE => [
          ['onPreResponseEvent', 50],
          ['onPostResponseEvent', 100]
        ]
      ];
  }

  public function onPreResponseEvent(ResponseEvent $responseEvent): void
  {
    // dd($responseEvent);
    $this->loggerInterface->info(__METHOD__);
  }
  public function onPostResponseEvent(ResponseEvent $responseEvent): void
  {
    // dd($responseEvent);
    $this->loggerInterface->info(__METHOD__);
  }
}