<?php

namespace App\Service\Contract;

interface IGeoApiService
{
    public function gatherInformation(string $ip);
}