<?php

if (! function_exists('appCarbonParse')) {
    function appCarbonParse($date, $format = null)
    {
        $date = \Carbon\Carbon::parse($date);

        if(is_null($format)) return $date;

        return $date->format($format);
    }
}