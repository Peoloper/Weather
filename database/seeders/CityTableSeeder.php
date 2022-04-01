<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'name' => 'Rzeszów',
            'user_id' => 1
        ]);
        City::create([
            'name' => 'Kraków',
            'user_id' => 2
        ]);
        City::create([
            'name' => 'Szczecin',
            'user_id' => 3
        ]);
        City::create([
            'name' => 'Gdańsk',
            'user_id' => 4
        ]);
        City::create([
            'name' => 'Poznań',
            'user_id' => 5
        ]);
        City::create([
            'name' => 'Lublin',
            'user_id' => 6
        ]);
        City::create([
            'name' => 'Łańcut',
            'user_id' => 7
        ]);
        City::create([
            'name' => 'Warszawa',
            'user_id' => 8
        ]);
        City::create([
            'name' => 'Katowice',
            'user_id' => 9
        ]);
        City::create([
            'name' => 'Sopot',
            'user_id' => 10
        ]);

    }
}
