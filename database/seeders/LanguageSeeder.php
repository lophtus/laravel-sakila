<?php

namespace Database\Seeders;

use App\Sakila\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            'af',
            'am',
            'ar',
            'az',
            'be',
            'bg',
            'bn',
            'bs',
            'ca',
            'cmn',
            'cr',
            'cs',
            'cy',
            'da',
            'de',
            'el',
            'en',
            'es',
            'et',
            'eu',
            'fa',
            'fi',
            'fr',
            'fro',
            'ga',
            'gd',
            'gl',
            'goh',
            'gsw',
            'gu',
            'haw',
            'he',
            'hi',
            'hr',
            'hu',
            'hy',
            'id',
            'is',
            'it',
            'iu',
            'ja',
            'ka',
            'kk',
            'kn',
            'ko',
            'ku',
            'ky',
            'la',
            'lo',
            'lt',
            'lv',
            'mi',
            'mk',
            'ml',
            'mn',
            'mr',
            'ms',
            'my',
            'myv',
            'ne',
            'nl',
            'no',
            'nqo',
            'pa',
            'pl',
            'prs',
            'ps',
            'pt',
            'qac',
            'qal',
            'qbn',
            'qbo',
            'qbp',
            'rm',
            'rn',
            'ro',
            'ru',
            'sd',
            'sk',
            'sl',
            'sq',
            'sr',
            'st',
            'sv',
            'ta',
            'te',
            'tg',
            'th',
            'tl',
            'tn',
            'tr',
            'uk',
            'ur',
            'uz',
            'vi',
            'wo',
            'xh',
            'yi',
            'yue',
            'zh',
            'zu',
        ];

        foreach ($languages as $name) {
            $language = Language::create([
                'name' => $name
            ]);

            $this->command->info(sprintf(
                'Added language id=%s \'%s\'.',
                $language->language_id,
                $language->name
            ));
        }
    }
}
