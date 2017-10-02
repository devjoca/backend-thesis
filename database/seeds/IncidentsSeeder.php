<?php

use App\Incident;
use Illuminate\Database\Seeder;

class IncidentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Incident::class, 50)->create();
    }
}
