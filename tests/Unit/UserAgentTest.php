<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class UserAgentTest extends TestCase
{
    private $http;

    public function setUp()
    {
        parent::setUp();
        $this->http = new Client([
            'base_uri' => 'http://httpbin.org',
            'timeout' => 2.0
        ]);
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->http = null;
    }

    public function testGet()
    {
        $response = $this->http->request('GET', 'user-agent');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()['Content-Type'][0];
        $this->assertEquals('application/json', $contentType);

        $userAgent = json_decode($response->getBody())->{"user-agent"};
        $this->assertRegexp('/Guzzle/', $userAgent);
    }
}