<?php

namespace App\Controller;

use App\Service\IpGeolocationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(IpGeolocationService $service): Response
    {
        $ip = "46.188.144.192";

        $service->saveVisitor($ip);
        return $this->render('home/index.html.twig');
    }
}
