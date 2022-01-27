<?php

namespace App\Controller;

use App\Service\VisitorHelperService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, VisitorHelperService $service): Response
    {
        $ip = "113.77.157.195";//$request->getClientIp();
        $referer = $request->headers->get('referer');
        $service->saveVisitor($ip, $referer ? $referer : "undefined");
        return $this->render('home/index.html.twig');
    }
}
