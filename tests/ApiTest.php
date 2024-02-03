<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

final class ApiTest extends TestCase
{
    public $baseUrl = 'http://mailer-test.test/api.php';

    public function testGetSubs()
    {
        $client = new Client();
        $response = $client->get($this->baseUrl);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPOSTNew()
    {
        $client = new Client();

        $data = array(
            'email' => 'user@test.com',
            'firstname' => 'first',
            'lastname' => 'last',
            'status' => 1
        );

        $response = $client->post($this->baseUrl, $data);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPOSTExist()
    {
        $client = new Client();

        $data = array(
            'email' => 'user@mail.com',
            'firstname' => 'first',
            'lastname' => 'last',
            'status' => 1
        );

        $response = $client->post($this->baseUrl, $data);

        $this->assertEquals(200, $response->getStatusCode());
        //$data = json_decode($response->getBody()->getContents(), true);
        $content = (string) $response->getBody();
        $data = json_decode($content);
        //$res = $response->getBody()->getContents();
        //fwrite(STDERR, print_r($data, TRUE));
        //$this->assertArrayHasKey('cache', $data);
    }
}
