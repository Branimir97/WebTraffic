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
        $ip = "200.87.11.249";//$request->getClientIp();
        $referer = $request->headers->get('referer');
        if(!isset($_COOKIE['SITE_VISITED']))
        {
            setcookie('SITE_VISITED', $ip, time()+60*60*60*24*30);
            $service->saveVisitor($ip, $referer ? $referer : "undefined");
        }
        if(isset($_COOKIE['SITE_VISITED']))
        {
            $visitor = $service->getVisitor($_COOKIE['SITE_VISITED']);
            if ($_COOKIE['SITE_VISITED'] !== $ip) {
                $service->renewIpAddress($visitor, $ip);
                setcookie('SITE_VISITED', $ip, time()+60*60*60*24*30);
            } 
            $service->renewLastReferer($visitor, $referer ? $referer : "undefined");
            $service->increaseVisitsNumber($visitor);           
        }
        return $this->render('home/index.html.twig');
    }
}
