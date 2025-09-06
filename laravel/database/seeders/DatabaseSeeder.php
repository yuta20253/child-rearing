<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PrefectureSeeder;
use Database\Seeders\MunicipalitySeeder;
use Database\Seeders\AddressSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PrefectureSeeder::class,
            MunicipalitySeeder::class,
            AddressSeeder::class,
            UserSeeder::class,
        ]);
    }
}
