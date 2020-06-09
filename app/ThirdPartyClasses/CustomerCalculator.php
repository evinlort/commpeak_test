<?php

namespace App\ThirdPartyClasses;

class CustomerCalculator
{

    public function calculate(array $parsed)
    {
        $response = array();

        foreach ($parsed as $customer_id => $datas) {
            $response[$customer_id] = $this->summarize($datas);
        }
        return $response;
    }

    private function summarize($datas)
    {
        $total_calls = 0;
        $same_continent_total_calls = 0;
        $total_calls_duration = 0;
        $same_continent_calls_duration = 0;
        foreach ($datas as $param) {
            $total_calls += 1;
            $total_calls_duration += $param[0];
            if ($param[1] == $param[2]) {
                $same_continent_total_calls += 1;
                $same_continent_calls_duration += $param[0];
            }
        }
        return array(
            'total_calls' => $total_calls,
            'total_calls_duration' => $total_calls_duration,
            'same_continent_total_calls' => $same_continent_total_calls,
            'same_continent_calls_duration' => $same_continent_calls_duration
        );
    }
}
