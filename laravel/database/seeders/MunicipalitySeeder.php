<?php

namespace Database\Seeders;

use App\Models\Prefecture;
use App\Models\Municipality;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
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

        if (! mb_check_encoding($contents, 'UTF-8')) {

            $contents = mb_convert_encoding($contents, 'UTF-8', 'SJIS-win');
        }

        // 改行で分割
        $lines = preg_split('/\r\n|\r|\n/', $contents);

        foreach ($lines as $i => $line) {
            if (trim($line) === '') {
                continue;
            }

            // BOM 削除
            $line = preg_replace('/^\x{FEFF}/u', '', $line);

            // CSV行を配列に
            $row = str_getcsv($line);

            // 都道府県・市区町村名を取得
            $prefectureName = trim(mb_convert_kana($row[3] ?? '', 's'));
            $municipalityName = trim(mb_convert_kana($row[4] ?? '', 's'));

            echo "Line {$i}: Prefecture='{$prefectureName}', Municipality='{$municipalityName}'\n";

            // 制御文字削除
            $prefectureName = preg_replace('/[\x00-\x1F\x7F]/u', '', $prefectureName);
            $municipalityName = preg_replace('/[\x00-\x1F\x7F]/u', '', $municipalityName);

            if (! $prefectureName || ! $municipalityName) {
                continue;
            }

            // prefecture を取得
            $prefectureId = Prefecture::where('name', $prefectureName)->value('id');

            if (! $prefectureId) {
                $this->command->warn("Prefecture not found: '{$prefectureName}'");
                continue;
            }

            // municipality を作成
            Municipality::firstOrCreate([
                'name' => $municipalityName,
                'prefecture_id' => $prefectureId,
            ]);
        }

        $this->command->info('Municipalities seeding completed!');
    }
}
