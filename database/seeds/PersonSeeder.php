<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('people')->insert([
            [
                'name'=> 'José Carlos',
                'lastname' => 'Pereyra',
                'birthday' =>  Carbon::createFromFormat('d/m/Y','17/06/1993'),
                'microsoft_person_id' => '1fc47eab-a2c5-477a-a667-1e82587449ec',
                'dni' => '73076794',
            ],
            [
                'name'=> 'Gianluca',
                'lastname' => 'Candiotti',
                'birthday' =>  Carbon::createFromFormat('d/m/Y','18/06/1993'),
                'microsoft_person_id' => '7666a26c-5ba9-458c-b1df-f3231b8bd805',
                'dni' => '73076795'
            ],
            [
                'name'=> 'Alfredo',
                'lastname' => 'Fuentes',
                'birthday' =>  Carbon::createFromFormat('d/m/Y','19/06/1993'),
                'microsoft_person_id' => '86e1da93-2f84-43ff-9b5c-a0dc3c8f9c34',
                'dni' => '73076796'
            ],
        ]);
    }
}
