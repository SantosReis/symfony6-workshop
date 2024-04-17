<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Contact;
use App\Entity\Product;
use App\Entity\Manufacturer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DoctrineRelationalController extends AbstractController
{
    #[Route('/doctrine/relational', name: 'app_doctrine_relational')]
    public function index(): Response
    {
        return $this->render('doctrine_relational/index.html.twig', [
            'controller_name' => 'DoctrineRelationalController',
        ]);
    }

    #[Route('/doctrine/relational/one-to-many-bidirectional', name: 'one_to_many_bidirectional')]
    public function one_to_many_bidirectional(EntityManagerInterface $entityManager): Response
    {
        //insert into database
        // $manufacturer = new Manufacturer();
        // $manufacturer->setName('ACME');
        // $entityManager->persist($manufacturer);
        // $entityManager->flush();

        // return new Response(sprintf('Manufacturer record created with id %d', $manufacturer->getId()));

        //checking relationships
        $manufacturer = $entityManager->find(Manufacturer::class, 1);

        $product = new Product();
        $product->setName('Radio knob');
        // dd($product); //check before set relationship
        $product->setManufacturer($manufacturer); //set Manufacturer into Product
        //dd($entityManager->contains($manufacturer), $entityManager->contains($product)); //check if existis in both entities
        
        $entityManager->persist($product);
        $entityManager->flush();
        dd($entityManager->contains($manufacturer), $entityManager->contains($product));
        // dd($product);

        


        return new Response(sprintf('Manufacturer record created with id %d', $manufacturer->getId()));

        // return $this->render('doctrine_relational/one-to-many-bidirectional.html.twig', [
        //     'controller_name' => 'DoctrineRelationalController',
        // ]);
    }


    #[Route('/doctrine/relational/one-to-many-unidirectional', name: 'one_to_many_unidirectional')]
    public function one_to_many_unidirectional(EntityManagerInterface $entityManager): Response
    {
        //insert into database
        $address = new Address();
        $address->setNumber(22);
        $address->setStreet('Unter den Linden');
        $entityManager->persist($address);

        $contact = new Contact();
        $contact->setAddress($address);
        $entityManager->persist($address);

        // dd($contact);

        $entityManager->flush();

        return new Response(sprintf('Address record created with id %d and User record created with id %d', $address->getId(), $contact->getId()));

        // return $this->render('doctrine_relational/one-to-many-bidirectional.html.twig', [
        //     'controller_name' => 'DoctrineRelationalController',
        // ]);
    }
}
