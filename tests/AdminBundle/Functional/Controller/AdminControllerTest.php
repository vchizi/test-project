<?php

namespace Tests\AdminBundle\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    /**
     * @dataProvider testRequestsProvider
     */
    public function testIndex($url, $code, $headers, $method = 'GET')
    {
        $client = static::createClient();

        $client->request($method, $url, [], [], $headers);

        $this->assertEquals($code, $client->getResponse()->getStatusCode());
    }

    public function testRequestsProvider()
    {
        return [
            ['/admin/admin/index', 200, ['HTTP_admin' => 'test'], 'GET'],
            ['/admin/admin/index', 200, ['HTTP_admin' => 'test'], 'POST'],
            ['/admin/admin/index', 403, ['HTTP_admin' => 'test1']],
            ['/admin/admin/index', 403, ['admin' => 'test']],
            ['/admin/admin/index', 403, []],
        ];
    }
}