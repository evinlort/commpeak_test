<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThirdPartyClasses\CSVParser;
use App\ThirdPartyClasses\CustomerCalculator;

class MainController extends Controller
{
    public function __construct()
    {
        $this->csv_parser = new CSVParser();
        $this->calculator = new CustomerCalculator();
    }

    public function index()
    {
        return view('welcome');
    }

    public function show(Request $r)
    {
        $parsed_csv_array = $this->csv_parser->parse_csv_file($r->file('csv'));
        $data = $this->calculator->calculate($parsed_csv_array);
        return view('customer_view' ,array('data' => $data));
    }
}
