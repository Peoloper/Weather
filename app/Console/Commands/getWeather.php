<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class getWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $cities = City::all();
        $api_key = '5891e06e0b289e466f149ff95b40ce33'; // const confing env


        foreach ($cities as $key => $city)
        {
            $api_url = 'https://api.openweathermap.org/data/2.5/weather?q='.$city->name.',pl&appid='.$api_key;
            $data[$key] = file_get_contents($api_url);

            $d = json_decode($data[$key]);
            $api_url_2 = 'https://api.openweathermap.org/data/2.5/onecall?lat='. $d->coord->lat.'&lon='.$d->coord->lon.'&exclude={part}&units=metric&appid='.$api_key;
            $data2[$key] = file_get_contents($api_url_2);

            City::where('id', $city->id)->update([
                'data' => $data2[$key],
            ]);
        }
    }
}
