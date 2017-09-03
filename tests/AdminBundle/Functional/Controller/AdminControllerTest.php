<?php

namespace Tests\AdminBundle\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    /**
     * @dataProvider testRequestsProvider
     */
    public function testIndex($url, $code, $headers)
    {
        $client = static::createClient();

        $client->request('GET', $url, [], [], $headers);

        $this->assertEquals($code, $client->getResponse()->getStatusCode());
    }

    public function testRequestsProvider()
    {
        return [
            ['/admin/admin/index', 200, ['HTTP_admin' => 'test']],
            ['/admin/admin/index', 403, ['HTTP_admin' => 'test1']],
            ['/admin/admin/index', 403, ['admin' => 'test']],
            ['/admin/admin/index', 403, []],
        ];
    }
}