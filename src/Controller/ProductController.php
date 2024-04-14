<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/products', name: 'products_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'all', methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/{slug}', name: 'name')]
    public function show(Product $product): Response
    {
        return new Response('Displaying product: ' . $product->getName());
        // return $this->render('product/index.html.twig', [
        //     'controller_name' => 'ProductController',
        // ]);
    }
}
