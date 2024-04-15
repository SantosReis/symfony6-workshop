<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function index(MailerInterface $mailer, $appEmail, $publicDir)
    {

        $email = (new TemplatedEmail())
            ->from($appEmail)
            ->to(new Address('email@example.com', 'Gary'))
            ->subject('Your order has been placed')
            ->textTemplate('email/order-confirmation.text.twig')
            ->htmlTemplate('email/order-confirmation.html.twig')
            ->attachFromPath($publicDir . '/pdf/test.pdf')
            ->context([
                'delivery_date' => date_create('+3 days'),
                'order_number' => rand(5, 50000),
            ]);

        $mailer->send($email);

        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
}
