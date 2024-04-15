<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SendMailTest extends WebTestCase
{
    /** @test */
    public function emails_are_sent_correctly(): void
    {
        //Setup
        $client = static::createClient();

        //Perform an action
        $client->request('GET', '/email');

        //Make assertions
        $sentMail = $this->getMailerMessage(0);
        
        // 1 email sent
        $this->assertEmailCount(1);
        // Sent to the correct person
        $this->assertEmailHeaderSame($sentMail, 'To', 'Gary <email@example.com>');
        // Has correct body content
        $this->assertEmailTextBodyContains($sentMail, 'The expected delivery date is');
        // Has an attachment
        $this->assertEmailAttachmentCount($sentMail, 1);
    }
}
