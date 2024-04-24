<?php

namespace App\Service;

class MessageType
{
    public function getMessageBaseOnType($type): string
    {
        $message = 'Message type not found!';

        if($type == 1){
          $message = 'Message type 1';
        }elseif($type == 2){
          $message = 'Message type 2';
        }elseif($type == 3){
          $message = 'Message type 3';
        }

        return $message;

    }
}