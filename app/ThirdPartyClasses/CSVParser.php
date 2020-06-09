<?php

namespace App\ThirdPartyClasses;

class CSVParser
{

    public function __construct()
    {
        $this->ip2continent = null;
        $this->ipstack = new IPStack();
        $this->phone_codes = new CountryPhoneCode();
        $this->parsed_csv_array = array();
    }

    public function parse_csv_file($file)
    {
        $file_handle = fopen($file, 'r');
        while (!feof($file_handle)) {
            if ($csv_line = fgetcsv($file_handle, 0, ',')) {
                $csv_array[] = $csv_line;
            }
        }
        fclose($file_handle);

        $ips = array();
        foreach ($csv_array as $line) {
            $ips[] = $line[4];
        }
        // $this->ip2continent = $this->ipstack->getContinentCodesByIPs($ips);
        $parsed_csv_array = array();
        foreach ($csv_array as $line) {
            $this->parseCSV($parsed_csv_array, $line);
        }

        return $parsed_csv_array;
    }

    private function parseCSV(array &$array, array $c_line)
    {
        if (!isset($array[$c_line[0]])) {
            $array[$c_line[0]] = array();
        }
        $array[$c_line[0]][] = $this->parseLine($c_line);
    }

    private function parseLine(array $line)
    {
        $new_line = array();
        $new_line[] = $line[2];
        // $new_line[] = $this->ip2continent[$line[4]];
        $new_line[] = $line[4];
        $new_line[] = $this->getContinentByPhone($line[3]);
        // $new_line[] = $line[3];
        return $new_line;
    }

    private function getContinentByPhone(String $phone)
    {
        foreach ($this->phone_codes->csv as $continent => $codes) {
            for ($i = 1; $i <= 8; $i++) {
                $phone_part = substr($phone, 0, $i);
                if (in_array($phone_part, $codes)) {
                    $response = $continent;
                }
            }
        }
        return $response;
    }
}
