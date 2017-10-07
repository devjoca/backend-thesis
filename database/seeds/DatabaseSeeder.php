<?php

use App\User;
use App\District;
use App\UserType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::insert([
            ['name' => 'admin'],
            ['name' => 'developer'],
        ]);

        $district = new District;
        $district->name = "Villa María del Triunfo";
        $district->boundary = file_get_contents(base_path('/database/data/vmt.json'));
        $district->layers = file_get_contents(base_path('/database/data/polygons.geojson'));
        $district->save();

        $this->call(VmtStationsSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(IncidentsSeeder::class);

        User::create([
            'email' => 'admin@admin.com',
            'name' => 'admin',
            'user_type_id' => 1,
            'password' => bcrypt('secret'),
        ]);
    }
}
