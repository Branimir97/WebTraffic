<?php

namespace App\Service;

use App\Entity\Visitor;
use App\Repository\VisitorRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class IpGeolocationService
{
    private $entityManager;
    private $visitorRepository;

    public function __construct(EntityManagerInterface $entityManager, VisitorRepository $visitorRepository)
    {
        $this->entityManager = $entityManager;
        $this->visitorRepository = $visitorRepository;
    }

    public function gatherInformation(string $ip) 
    {
        $ipdata = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
        return [
            "countryName" => $ipdata->geoplugin_countryName,
            "countryCode" => $ipdata->geoplugin_countryCode,
            "continentName" => $ipdata->geoplugin_continentName,
            "continentCode" => $ipdata->geoplugin_continentCode,
            "currencyCode" => $ipdata->geoplugin_currencyCode,
            "timezone" => $ipdata->geoplugin_timezone
        ];
    }

    public function saveVisitor(string $ip, string $referer)
    {
        $visitor = $this->visitorRepository->findOneBy(['ip' => $ip]);
        if(!$visitor) {
            $visitor = new Visitor();
            $visitorInformations = $this->gatherInformation($ip);
            $visitor->setIp($ip);
            $visitor->setCountryName($visitorInformations["countryName"]);
            $visitor->setCountryCode($visitorInformations["countryCode"]);
            $visitor->setContinentName($visitorInformations["continentName"]);
            $visitor->setContinentCode($visitorInformations["continentCode"]);
            $visitor->setCurrencyCode($visitorInformations["currencyCode"]);
            $visitor->setTimezone($visitorInformations["timezone"]);
            $visitor->setSpentTime(new DateTime("00:00:00"));
            $visitor->setVisitsNumber(1);
            $this->entityManager->persist($visitor);
            $this->entityManager->flush();
        } 
        $this->increaseVisitsNumber($visitor);
        
    }

    public function increaseVisitsNumber(Visitor $visitor)
    {
        $visitor->setVisitsNumber($visitor->getVisitsNumber()+1);
        $this->entityManager->persist($visitor);
        $this->entityManager->flush();
    }
}