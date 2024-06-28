<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

// use Psr\Log\LoggerInterface;

class UrlShortener
{
  public const SHORT_URL_LENGTH = 9;
  public const RANDOM_BYTES = 32;
  public const URL = 'https://t.ly/';

  public function __construct(
    // private LoggerInterface $logger,
    private EntityManagerInterface $entityManager
  ) {

    // $this->messageType = $messageType;
    // $this->adminEmail = $adminEmail;
    // $this->logger = $logger;
  }

  protected function encrypt(string $longUrl): string
  {
    $shortenedUrl = substr(
        base64_encode(
            sha1(uniqid(random_bytes(self::RANDOM_BYTES),true))
        ),
        0,
        self::SHORT_URL_LENGTH
    );

      return self::URL.$shortenedUrl;
  }

  public function is_encrypited($url){
    return substr($url, 0, 13) == self::URL ? true : false;
  }

  public function generateShortUrl(string $url): array
  {

    $findTo = $this->is_encrypited($url) ? 'shorter' : 'longer';
    $urlShortener = $this->entityManager->getRepository(\App\Entity\UrlShortener::class)->findOneBy([$findTo => $url]);

    $generated = false;
    if($urlShortener){
      $longUrl = $urlShortener->getLonger();
      $shortUrl = $urlShortener->getShorter();
    }else{
      $longUrl = $url;
      $shortUrl = $this->encrypt($url);
      $generated = $this->persistUrl($url, $shortUrl) ? true : false;
    }

    return [
      'long_url' => $longUrl,
      'short_url' => $shortUrl,
      'generated' => $generated
    ];

  }

  public function persistUrl(string $longUrl, string $shortenedUrl): bool
  {
      
    $urlShortener = new \App\Entity\UrlShortener();
    $urlShortener->setLonger($longUrl);
    $urlShortener->setShorter($shortenedUrl);
    
    $this->entityManager->persist($urlShortener);
    $this->entityManager->flush();

    return (bool)$urlShortener;
  }
}