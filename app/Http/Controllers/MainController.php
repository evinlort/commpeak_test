<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThirdPartyClasses\CSVParser;
use App\ThirdPartyClasses\CustomerCalculator;

class MainController extends Controller
{
    public function __construct()
    {
        $this->csv_parser = resolve(CSVParser::class);
        $this->calculator = new CustomerCalculator();
    }

    public function index()
    {
        return view('welcome');
    }

    public function show(Request $r)
    {
        $parsed_csv_array = $this->csv_parser->parse_csv_file($r->file('csv'));
        // $data = $this->calculator->calculate($parsed_csv_array);
        return view('customer_view' ,array('data' => $parsed_csv_array));
    }

    public function customer_data(Request $r)
    {
        $customer_data = json_decode($r->getContent());
        $data = $this->calculator->calculate(array($r->id => $customer_data));
        return response($data[$r->id], 200)->header('Content-Type','text/html');
    }
}
