<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class AdminController
{
    public function indexAction()
    {
        return new Response('Admin index');
    }
}