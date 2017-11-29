<?php

namespace App\Console\Commands;

use App\District;
use App\Incident;
use Geo;
use Illuminate\Console\Command;

class ColorIncidentLayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'color';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Color Incident Layers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Starting Coloring Process");
        $incidents = Incident::all();

        $json = file_get_contents(base_path('database/data/blank-colored.geojson'));
        $geo = Geo::parseGeoJson($json);

        $n = 0;
        $counts = [];
        foreach ($geo->getComponents() as $g) {
            $n ++;
            $count = 0;
            $incidents->each(function($i) use($g, &$count) {
                $d = $this->haversineDistance($i->lat, $i->long, $g->getCentroid()->y(), $g->getCentroid()->x());
                if ($d < 0.150) $count +=1;
            });
            $counts[] = $count;
        }

        $max_c = max($counts);
        $min_c = min($counts);

        $geojson = [
            "type"=> "FeatureCollection",
            "features"=> []
        ];

        $n = 0;
        foreach ($geo->getComponents() as $g) {
             $geojson["features"][] = [
                "type" => "Feature",
                "properties" => [
                    "max_c"=> $max_c,
                    "min_c"=> $min_c,
                    "count"=> $counts[$n],
                    "color"=> $this->getColor($this->normalize($max_c, $min_c, $counts[$n])),
                ],
                "geometry"=> json_decode($g->out('json')),
             ];
             $n++;
        }

        $d = District::first();
        $d->layers = json_encode($geojson);
        $d->save();
        $this->info("Finish Coloring Process");
    }

    private function getColor($ratio)
    {
        $green = [90, 75, 40];
        $red = [0, 100, 40];

        return [
            (int)($green[0] + $ratio * ($red[0] - $green[0])),
            (int)($green[1] + $ratio * ($red[1] - $green[1])),
            (int)($green[2] + $ratio * ($red[2] - $green[2])),
        ];
    }

    private function normalize($max, $min, $c)
    {
        return (double)($c-$min)/($max-$min);
    }

    private function haversineDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {

        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
    }
}
