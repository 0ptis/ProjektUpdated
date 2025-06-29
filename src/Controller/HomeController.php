<?php

/*
 * Home Controller
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController.
 */
#[Route('/home')]
class HomeController extends AbstractController
{
    /**
     * public function index.
     *
     * @return void
     */
    #[Route(
        name: 'home_index',
        methods: 'GET'
    )]
    public function index(): Response
    {
        return $this->render('Home/index.html.twig');
    }
}
