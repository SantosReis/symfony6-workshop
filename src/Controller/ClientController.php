<?php

namespace App\Controller;

use App\Service\MessageGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/client/list', name: 'app_client_list')]
    public function list(LoggerInterface $logger, MessageGenerator $messageGenerator): Response
    {
        $message = $messageGenerator->getHappyMessage(2);
        dd($message);

        $logger->info('Test message');
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
