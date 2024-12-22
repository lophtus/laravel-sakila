<?php

namespace Database\Seeders;

use App\Sakila\Film;
use App\Sakila\Language;
use Illuminate\Database\Seeder;
use Exception;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filmCount = (int)$this->command->ask('How many films do you need? Default: ', 'all');

        $file = storage_path() . '/app/data/title.basics.tsv';

        if (! file_exists($file)) {
            throw new Exception(sprintf('Seeder data file \'%s\' not found.', $file));
        }

        $fp = fopen($file, 'r');

        $seedCount = 0;

        while ((
            [
                $titleId,
                $titleType,
                $primaryTitle,
                $originalTitle,
                $isAdult,
                $startYear,
                $endYear,
                $runtimeMinutes,
                $genres
            ] = fgetcsv($fp, 1024, "\t")) !== FALSE) {

            $seedCount++;

            if($filmCount !== 'all' && $seedCount >= $filmCount) {
                return;
            }

            // skip header
            if ($seedCount <= 1) {
                continue;
            }

            // clean up data
            if ($startYear === '\\N') {
                $startYear = null;
            }

            if ($runtimeMinutes === '\\N') {
                $runtimeMinutes = null;
            }

            // find related language record
            $language = Language::whereName('en')->first();

            // chop title to length
            if (strlen($primaryTitle) > 255) {
                $primaryTitle = substr($primaryTitle, 0, 251) . '...';
            }

            $film = Film::create([
                'title' => $primaryTitle,
                'length' => $runtimeMinutes,
                'release_year' => $startYear,
                'language_id' => $language->language_id,
            ]);

            $this->command->info(sprintf(
                'Added film id=%s \'%s\' (%s)',
                $film->film_id,
                $film->title,
                $film->release_year
            ));
        }

        $this->command->info(sprintf('Added %s films', $seedCount));

        fclose($fp);
    }
}
