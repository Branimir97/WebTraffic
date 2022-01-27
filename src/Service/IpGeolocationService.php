<?php

namespace App\Service;

use App\Entity\Visitor;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Time;

class IpGeolocationService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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

    public function saveVisitor(string $ip)
    {
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
}