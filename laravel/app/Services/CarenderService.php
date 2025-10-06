<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class CarenderService
{
    public function getCarender(string $baseDate = null):array
    {
        Carbon::setLocale('ja');

        $start = $baseDate ? Carbon::parse($baseDate) : Carbon::today();
        $week = [];
        for ($i=0; $i < 7; $i++) {
            $date = $start->copy()->addDays($i);
            $week[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->isoFormat('ddd'),
            ];
        }
        return $week;
    }
}
