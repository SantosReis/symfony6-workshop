<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function index(MailerInterface $mailer): Response
    {

        $email = (new Email())
            ->from('sales@app.com')
            ->to('email@example.com')
            ->subject('Your order has been placed')
            ->html('<p>Thank you, your order has been placed</p>');

        $mailer->send($email);

        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
}
