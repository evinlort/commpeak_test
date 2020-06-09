<?php

namespace App\ThirdPartyClasses;

use Illuminate\Support\Facades\Http;

class IPStack
{
    public function __construct()
    {
        $this->base_url = 'http://api.ipstack.com/';
        $this->access_key = '?access_key=ed09e98ccc0c3f163c4d575a764f3629';
        $this->continent_request = '&fields=continent_code';
    }

    public function getContinentCodesByIPs(array $ips)
    {
        $result = array();
        foreach ($ips as $ip) {
            $result[$ip] = $this->getContinentCode($ip);
        }
        return $result;
    }

    public function getContinentCode(String $ip)
    {
        $url = $this->base_url . $ip . $this->access_key . $this->continent_request;
        $response = Http::get($url);
        $json = json_decode($response, true);
        return $json['continent_code'];
    }
}
