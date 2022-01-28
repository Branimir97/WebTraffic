<?php

namespace App\Service;

use App\Entity\Visitor;
use App\Repository\VisitorRepository;
use App\Service\IpGeolocationService;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class VisitorHelperService
{
    private $entityManager;
    private $visitorRepository;
    private $ipGeoService;

    public function __construct(EntityManagerInterface $entityManager, 
                                VisitorRepository $visitorRepository, 
                                IpGeolocationService $ipGeoService)
    {
        $this->entityManager = $entityManager;
        $this->visitorRepository = $visitorRepository;
        $this->ipGeoService = $ipGeoService;
    }

    public function saveVisitor(string $ip, string $referer)
    { 
        $visitor = new Visitor();
        $visitorInformations = $this->ipGeoService->gatherInformation($ip);
        $visitor->setIp($ip);
        $visitor->setCountryName($visitorInformations["countryName"]);
        $visitor->setCountryCode($visitorInformations["countryCode"]);
        $visitor->setContinentName($visitorInformations["continentName"]);
        $visitor->setContinentCode($visitorInformations["continentCode"]);
        $visitor->setCurrencyCode($visitorInformations["currencyCode"]);
        $visitor->setTimezone($visitorInformations["timezone"]);
        $visitor->setSpentTime(0);
        $visitor->setVisitsNumber(1);
        $visitor->setReferer($referer);
        $this->persistAndFlush($visitor);    
    }

    public function increaseVisitsNumber(Visitor $visitor)
    {
        $visitor->setVisitsNumber($visitor->getVisitsNumber()+1);
        $this->persistAndFlush($visitor);
    }

    public function renewLastReferer(Visitor $visitor, string $referer) 
    {
        if($visitor->getReferer() !== $referer) 
        {
            $visitor->setReferer($referer);
            $this->persistAndFlush($visitor);
        }
    }

    public function persistAndFlush(Visitor $visitor) 
    {
        $this->entityManager->persist($visitor);
        $this->entityManager->flush();
    }

    public function renewIpAddress(Visitor $visitor, string $newIpAddress)
    {
        $visitor->setIp($newIpAddress);
        $this->persistAndFlush($visitor);
    }

    public function getVisitorByIp(string $ip)
    {
        return $this->visitorRepository->findOneBy(['ip' => $ip]);    
    }

    public function getVisitorByOldIp(string $ip)
    {
        return $this->visitorRepository->findOneBy(['previousIp' => $ip]);    
    }

    public function increaseSpentTime(Visitor $visitor, float $elapsed)
    {
        $previousState = $visitor->getSpentTime();
        $visitor->setSpentTime($previousState + $elapsed);
        $this->persistAndFlush($visitor);
    }
}