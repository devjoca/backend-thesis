<?php

use Illuminate\Database\Seeder;

class VmtStationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stations = [
            ['name' => 'Comisaria Villa María del triunfo','lat' => '-12.1656945','long' => '-76.9477808','created_at' => NULL,'updated_at' => NULL],
            ['name' => 'Comisaria José Carlos Mariategui','lat' => '-12.1496728','long' => '-76.9503243','created_at' => NULL,'updated_at' => NULL],
            ['name' => 'Comisaria Nueva Esperanza','lat' => '-12.1700938','long' => '-76.923482','created_at' => NULL,'updated_at' => NULL],
            ['name' => 'Comisaria San Francisco de Tablada de Lurín','lat' => '-12.2001557','long' => '-76.9280697','created_at' => NULL,'updated_at' => NULL],
            ['name' => 'Comisaria José Galvez Barrenechea','lat' => '-12.2077171','long' => '-76.9063756','created_at' => NULL,'updated_at' => NULL],
        ];

        DB::table('stations')->insert($stations);
    }
}
