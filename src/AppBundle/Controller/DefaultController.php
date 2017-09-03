<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function indexAction()
    {
        return new Response('Default index');
    }

    public function adminAction()
    {
        return new Response('Default admin');
    }
}
