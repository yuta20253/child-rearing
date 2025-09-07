<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addressIds = [90400, 90409, 90445, 90643, 40388];
        $facilitiesArr = ['中央図書館', '北口図書館', '鳴尾図書館', '中央図書館上ヶ原分室', '中央図書館'];
        $latitudeArr = [34.730886, 34.74714, 34.719111, 34.755604, 35.756448];
        $longitudeArr = [135.329875, 135.3578630, 135.364598, 135.338997, 139.802337];
        $count = 0;

        foreach($addressIds  as $index => $addressId) {
            DB::table('facilities')->insert([
                'name' => $facilitiesArr[$index],
                'address_id' => $addressId,
                'image' => '',
                'latitude' => $latitudeArr[$index],
                'longitude' => $longitudeArr[$index],
                'equipment' => '図書館',
                'description' => '西宮市にある図書館です。',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $count += 1;
        }
    }
}
