<?php

namespace App\Controller;

use App\Service\VisitorHelperService;
use DateTime;
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
        $ip = "16.62.54.4";//$request->getClientIp();
        $referer = $request->headers->get('referer');
        $elapsed = 0;
        if(isset($_COOKIE['elapsed']))
        {
            $elapsed = $_COOKIE['elapsed'];
        }

        if(isset($_COOKIE['SITE_VISITED']))
        {
            $visitor = $service->getVisitorByIp($ip);
            if(!is_null($visitor)){
                $service->renewLastReferer($visitor, $referer ? $referer : "undefined");
                $service->increaseVisitsNumber($visitor);      
                $service->increaseSpentTime($visitor, $elapsed);    
            } else {
                $service->saveVisitor($ip, $referer ? $referer : "undefined");
            }       
            setcookie('SITE_VISITED', $ip, time()+60*60*60*24*30);     
        } else {
            $visitor = $service->getVisitorByIp($ip);
            if(!is_null($visitor))
            {
                $service->renewLastReferer($visitor, $referer ? $referer : "undefined");
                $service->increaseVisitsNumber($visitor);      
                $service->increaseSpentTime($visitor, $elapsed);    
            } else {
                $service->saveVisitor($ip, $referer ? $referer : "undefined");
            }
            setcookie('SITE_VISITED', $ip, time()+60*60*60*24*30);                   
        }        
        return $this->render('home/index.html.twig', ['elapsed'=>$elapsed]);
    }
}
