<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class UrlShortenerDatabaseTest extends ApiTestCase
{
    private $response;
    protected $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        DatabasePrimer::prime($kernel);
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    private function getValidObjectForTestRequest()
    {
        return json_encode(compact('email', 'password'));

        // return (object) [
        //     'url' => static::UNTESTED_VALUE,
        // ];
    }


    public function test_it_can_send_url_to_be_shortened(): void
    {

        $url = 'https://github.com/SantosReis/laravel-test-driven-api/blob/main/tests/Unit/TodoListTest.php';
        $content = ['url' => $url];

        $testBody = $content;

        $client = static::createClient();
        // dd($client->getResponse());

        $client->request('POST', '/api/shortener', ['json' => $content]);

        // dd(json_decode($client->getResponse()->getContent(), true));
        $data = json_decode($client->getResponse()->getContent(), true);
        // $this->assertArrayHasKey('url', $data);


        

        dd($data);
        // $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // $this->response = static::createClient()->request('POST', '/url-shortener');

        // $this->assertResponseIsSuccessful();
        // $this->assertJsonContains(['@url' => '/']);
    }

    /*public function test_it_can_retrieve_shortened_url_if_exists(): void
    {
        $this->assertTrue(true);
    }*/
    public function test_it_can_retrieve_all_shortened_urls(): void{

        $client = static::createClient();
        $client->request('GET', '/api/shortener-list');

        $this->assertResponseIsSuccessful();
        //TODO
    }

    /*public function test_it_redirect_to_original_url(): void{
        //TODO
        $this->assertTrue(true);
    }

    public function test_it_can_delete_shortener(): void{
        //TODO
        $this->assertTrue(true);
    }*/


    protected function tearDown(): void
    {
        $kernel = self::bootKernel();
        DatabasePrimer::prime($kernel);
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
