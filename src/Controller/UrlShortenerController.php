<?php

namespace App\Controller;

use App\Service\UrlShortener;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UrlShortenerController extends AbstractController
{

    #[Route('/api/shortener', name: 'app_url_shortener', methods: 'POST')]
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $url = json_decode(($request)->getContent())->url;

        $urlShortenerService = new UrlShortener($entityManager);
        $urlShortener = $urlShortenerService->generateShortUrl($url);

        $response = array_merge(["status" => true], $urlShortener);

        return $this->json($response);
    }

    #[Route('/api/shortener-list', name: 'app_url_shortener_list', methods: 'GET')]
    public function list(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {

        $urlShortener = $entityManager->getRepository(\App\Entity\UrlShortener::class)->findAll();

        return $this->json($urlShortener);
    }
}
