<?php

namespace CRVA\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction()
    {
        return new Response("Bienvenidos a mi modulo de usuarios");
    }

    public function articlesAction($page)
    {
        return new Response("Este es mi articulo" . $page);
    }
}
