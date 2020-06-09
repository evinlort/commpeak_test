<?php

namespace App\ThirdPartyClasses;

use Illuminate\Support\Facades\Storage;

class CountryPhoneCode
{
    public function __construct()
    {
        $re = '/^(?=\#).+$/m';
        $this->file = trim(preg_replace($re, '', Storage::disk('public')->get("countryInfo.txt")));
        foreach(explode("\n", $this->file) as $line) {
            $parsed_line = str_getcsv($line, "\t");
            $this->csv[$parsed_line[8]][] = $parsed_line[12];
        }
    }
}
