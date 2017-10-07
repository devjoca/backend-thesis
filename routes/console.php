<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('load-stations', function () {
    $files = collect([
        '/Users/joca/Desktop/1.json',
        '/Users/joca/Desktop/2.json',
        '/Users/joca/Desktop/3.json',
        '/Users/joca/Desktop/4.json',
    ]);

    $files->each(function($file) {
        $data = json_decode(file_get_contents($file), TRUE);

        foreach($data['payload'] as $station) {
            \DB::table('stations')->insert([
                'name' => $station['title'],
                'lat' => $station['lat'],
                'long' => $station['lon'],
            ]);
        }
    });




    $this->comment('Finish');
});

