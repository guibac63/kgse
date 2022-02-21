<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class homeController
{

    /**
     * @Route("/",name="home")
     */
    function homepage():Response
    {
        return new Response("<body>redirection ok</body>");
    }

}