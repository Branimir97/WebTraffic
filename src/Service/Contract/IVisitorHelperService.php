<?php

namespace App\Service\Contract;

use App\Entity\Visitor;

interface IVisitorHelperService
{
    public function saveVisitor(string $ip, string $referer);

    public function increaseVisitsNumber(Visitor $visitor);

    public function renewLastReferer(Visitor $visitor, string $referer); 

    public function renewIpAddress(Visitor $visitor, string $newIpAddress);

    public function getVisitorByIp(string $ip);

    public function increaseSpentTime(Visitor $visitor, float $elapsed);

    public function persistAndFlush(Visitor $visitor);
}