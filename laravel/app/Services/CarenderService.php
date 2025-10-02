<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class CarenderService
{
    public function getCarender()
    {
        Carbon::setLocale('ja');
        $week = [];
        for ($i=0; $i < 7; $i++) {
            $date = Carbon::today()->addDays($i);
            $week[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->isoFormat('ddd'),
            ];
        }
        return $week;
    }
}
