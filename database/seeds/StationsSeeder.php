<?php

use App\Station;
use App\Jurisdiction;
use Illuminate\Database\Seeder;

class StationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(base_path('database/data/stations.json'));
        $data =json_decode($json, true);

        $created_stations = collect();

        foreach($data['features'] as $f) {
            if(count($f['geometry']['coordinates']) == 3) {
                $station = Station::create([
                    'name' => $f['properties']['Name'],
                    'description' => $f['properties']['description'],
                    'lat' => $f['geometry']['coordinates'][1],
                    'long' => $f['geometry']['coordinates'][0],
                ]);
                $created_stations[] = $station;
            }
        }

        foreach($data['features'] as $f) {
            if(count($f['geometry']['coordinates']) != 3) {
                $created_stations->each(function($s) use($f) {
                    if($s->name == $f['properties']['Name']) {
                        Jurisdiction::create([
                            'station_id' => $s->id,
                            'geojson' => json_encode($f),
                        ]);
                        return false;
                    }
                });
            }
        }

    }
}
