<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilitiyIds = [1,2,3,4,5];
        $titles = [
            '中央図書館イベント',
            '北口図書館イベント',
            '鳴尾図書館イベント',
            '中央図書館上ヶ原分室イベント',
            '中央図書館イベント（東京）',
        ];
        $descriptions = [
            '西宮市の中央図書館でのイベントです。',
            '西宮市の北口図書館でのイベントです。',
            '西宮市の鳴尾図書館でのイベントです。',
            '西宮市の上ヶ原分室でのイベントです。',
            '東京都にある中央図書館のイベントです。',
        ];

        $startTimes = [
                '2025-10-10 10:00:00',
                '2025-10-11 13:00:00',
                '2025-10-12 14:00:00',
                '2025-10-13 09:00:00',
                '2025-10-14 10:00:00',
            ];

        $endTimes = [
            '2025-10-10 12:00:00',
            '2025-10-11 15:00:00',
            '2025-10-12 16:00:00',
            '2025-10-13 11:00:00',
            '2025-10-14 12:00:00',
        ];

        $capacities = [20, 15, 25, 10, 30];


        foreach ($facilitiyIds as $index => $facilitiyId) {
            DB::table('events')->insert([
                'facility_id' => $facilitiyId,
                'title' => $titles[$index],
                'description' => $descriptions[$index],
                'start_datetime' => $startTimes[$index],
                'end_datetime' => $endTimes[$index],
                'capacity' => $capacities[$index],
            ]);
        }
    }
}
