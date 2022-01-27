<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        $ip = "46.188.144.192";

        $ipdata = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

        dd($ipdata);
        return $this->render('home/index.html.twig');
    }
}
