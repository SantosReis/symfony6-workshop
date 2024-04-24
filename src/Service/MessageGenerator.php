<?php

namespace App\Service;

// use Psr\Log\LoggerInterface;

class MessageGenerator
{

  public function __construct(
      // private LoggerInterface $logger,
      private MessageType $messageType,
      private $adminEmail
  ) {
    $this->messageType = $messageType;
    $this->adminEmail = $adminEmail;
    // $this->logger = $logger;
  }

  public function getHappyMessage($type): string
  {
      // dd($this->adminEmail);
      $message = $this->messageType->getMessageBaseOnType($type);
      // $this->logger->info($message);
      

      return $message;

  }
}