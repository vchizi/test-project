<?php

namespace Tests\AppBundle\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrdersControllerTest extends WebTestCase
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
            ['/app/orders/view', 200],
            ['/app/orders/getOrder', 200],
            ['/app/orders/index', 404],
        ];
    }
}
