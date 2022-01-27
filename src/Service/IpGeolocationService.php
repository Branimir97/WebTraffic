<?php

namespace App\Service;

class IpGeolocationService
{
    public function gatherInformation(string $ip) 
    {
        $ipdata = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
        return $ipdata->geoplugin_countryCode;
    }
}