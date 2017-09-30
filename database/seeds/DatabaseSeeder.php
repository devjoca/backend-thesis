<?php

use App\User;
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

        $this->call(StationsSeeder::class);
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
