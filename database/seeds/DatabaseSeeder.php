<?php

use App\User;
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
        $this->call(StationsSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(IncidentsSeeder::class);
        User::create([
            'email' => 'admin@admin.com',
            'name' => 'admin',
            'password' => bcrypt('secret'),
        ]);
    }
}
