<?php

namespace Tests\AppBundle\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider testRequestsProvider
     */
    public function testIndex($url, $code)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertEquals($code, $client->getResponse()->getStatusCode());
    }

    public function testRequestsProvider()
    {
        return [
            ['/app/default/index', 200],
            ['/app/default/admin', 200],
            ['/app/default/view', 404],
        ];
    }
}
