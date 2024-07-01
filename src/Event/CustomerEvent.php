<?php

namespace App\Event;
use Symfony\Contracts\EventDispatcher\Event;

class CustomEvent extends Event{
  private \DateTimeImmutable $timestamp;

  public function __construct()
  {
    $this->timestamp = new \DateTimeImmutable;
  }

  public function getDateTime(): \DateTimeImmutable
  {
    return $this->timestamp;
  }
}