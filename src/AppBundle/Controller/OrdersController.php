<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class OrdersController
{
    public function viewAction()
    {
        return new Response('Orders view');
    }

    public function getOrderAction()
    {
        return new Response('Orders getOrder');
    }
}
