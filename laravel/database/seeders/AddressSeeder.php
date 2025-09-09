<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Municipality;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = storage_path('csv/address.csv');
        if (! file_exists($file)) {
            $this->command->error("File not found: $file");
            return;
        }

        // ファイル全体を読み込み
        $contents = file_get_contents($file);

        // UTF-8か確認
        if (! mb_check_encoding($contents, 'UTF-8')) {
            $contents = mb_convert_encoding($contents, 'UTF-8', 'SJIS-win');
        }

        $lines = preg_split('/\r\n|\r|\n/', $contents);

        foreach ($lines as $line) {
            if (trim($line) === '') {
                continue;
            }
            // BOM 削除
            $line = preg_replace('/^\x{FEFF}/u', '', $line);

            // CSV行を配列に
            $row = str_getcsv($line);

            $prefectureName = trim(mb_convert_kana($row[3] ?? '', 's'));
            $municipalityName = trim(mb_convert_kana($row[4] ?? '', 's'));

            $town = trim(mb_convert_kana($row[5] ?? '', 's'));
            if ($town === '以下に掲載がない場合') {
                $town = '';
            }
            $postalCode = trim(mb_convert_kana($row[2] ?? '', 's'));

            $municipality = Municipality::where('name', $municipalityName)->whereHas('prefecture', function ($q) use ($prefectureName) {
                $q->where('name', $prefectureName);
            })->first();

            if (! $municipality) {
                continue;
            }

            Address::create([
                'municipality_id' => $municipality->id,
                'town' => $town,
                'postal_code' => $postalCode,
            ]);
        }
    }
}
