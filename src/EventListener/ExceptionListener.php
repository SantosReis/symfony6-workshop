<?php

namespace App\EventListener;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{

  public function __construct(
    private Environment $twig
    ){
  }

  public function onKernelException(ExceptionEvent $exceptionEvent): void
  {
    
    $exception = $exceptionEvent->getThrowable();

    if (!$exception instanceof NotFoundHttpException) {
      return;
    }

    // dd($exceptionEvent);

    // $content = $this->twig->render('exception/not-found.html.twig');
    $content = $this->twig->render('exception/not-found.html.twig', [
      'message' => $exception->getMessage()
    ]);

    $exceptionEvent->setResponse((new Response())->setContent($content));

  }
}