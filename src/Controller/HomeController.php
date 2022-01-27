<?php

namespace App\Controller;

use App\Service\IpGeolocationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, IpGeolocationService $service): Response
    {
        $ip = "46.188.144.192";//$request->getClientIp();
        $referer = $request->headers->get('referer');
        $service->saveVisitor($ip, $referer);
        return $this->render('home/index.html.twig');
    }
}
