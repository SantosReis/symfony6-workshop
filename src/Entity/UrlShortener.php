<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UrlShortenerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UrlShortenerRepository::class)]
#[ApiResource]
class UrlShortener
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $longer = null;

    #[ORM\Column(length: 255)]
    private ?string $shorter = null;

    #[ORM\Column(nullable: true)]
    private ?int $counter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLonger(): ?string
    {
        return $this->longer;
    }

    public function setLonger(string $longer): static
    {
        $this->longer = $longer;

        return $this;
    }

    public function getShorter(): ?string
    {
        return $this->shorter;
    }

    public function setShorter(string $shorter): static
    {
        $this->shorter = $shorter;

        return $this;
    }

    public function getCounter(): ?int
    {
        return $this->counter;
    }

    public function setCounter(?int $counter): static
    {
        $this->counter = $counter;

        return $this;
    }
}
