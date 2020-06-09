<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThirdPartyClasses\IPStack;
use App\ThirdPartyClasses\CountryPhoneCode;

class MainController extends Controller
{
    private $data;

    public function __construct()
    {
        $this->ipstack = new IPStack();
        $this->phone_codes = new CountryPhoneCode();
    }

    public function index()
    {
        return view('welcome');
    }

    public function show(Request $r)
    {
        $file_handle = fopen($r->file('csv'), 'r');
        while (!feof($file_handle)) {
            if ($csv_line = fgetcsv($file_handle, 0, ',')) {
                $csv_array[] = $csv_line;
            }
        }
        fclose($file_handle);

        $ips = array();
        foreach($csv_array as $line) {
            $ips[] = $line[4];
        }
        $this->ip2continent = $this->ipstack->getContinentCodesByIPs($ips);
        $parsed_csv_array = array();
        foreach($csv_array as $line) {
            $this->parseCSV($parsed_csv_array, $line);
        }
        
        dd($parsed_csv_array);
        return $parsed_csv_array;
    }

    private function parseCSV(Array &$array, Array $c_line)
    {
        if (!isset($array[$c_line[0]])) {
            $array[$c_line[0]] = array();
        }
        $array[$c_line[0]][] = $this->parseLine($c_line);
    }

    private function parseLine(array $line)
    {
        $line[] = $this->ip2continent[$line[4]];
        return $line;
    }

    private function __set($name, $value) {
        $this->data[$name] = $value;
    }

    private function __get($name) {
        return $this->data[$name];
    }
}
