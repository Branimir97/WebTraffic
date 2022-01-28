<?php

namespace App\Service;
use App\Service\Contract\IGeoApiService;

class GeoApiService implements IGeoApiService
{
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
}