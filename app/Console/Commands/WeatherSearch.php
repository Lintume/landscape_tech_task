<?php

namespace App\Console\Commands;

use App\Services\WeatherService;
use Exception;
use Illuminate\Console\Command;

class WeatherSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:weather-search {city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show weather data for a given city using the WeatherSearch Livewire component';

    /**
     * Execute the console command.
     *
     * @param WeatherService $weatherService
     * @return int
     */
    public function handle(WeatherService $weatherService): int
    {
        $city = $this->argument('city');

        try {
            $data = $weatherService->getWeatherData($city);

            $this->info('Weather data for ' . $city . ':');
            $this->info('City: ' . $data['city']);
            $this->info('Conditions: ' . $data['conditions']);
            $this->info('Temperature: ' . $data['temp'] . '°C');
            $this->info('Feels Like: ' . $data['feels_like'] . '°C');
            $this->info('Humidity: ' . $data['humidity'] . '%');
            $this->info('Min Temperature: ' . $data['temp_min'] . '°C');
            $this->info('Max Temperature: ' . $data['temp_max'] . '°C');
            $this->info('Wind Speed: ' . $data['wind_speed'] . ' mph');
            $this->info('Rain: ' . $data['rain'] . ' mm');
            $this->info('Icon: ' . $data['icon_condition']);
        } catch (Exception $e) {
            $this->error('Error: ' . $e->getMessage());

            return 0;
        }

        return 0;
    }
}
