<?php

namespace Tests\Feature;

use App\Services\WeatherService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeatherSearchCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_weather_search_with_valid_city()
    {
        // Mock the WeatherService
        $weatherServiceMock = $this->createMock(WeatherService::class);
        $weatherServiceMock->method('getWeatherData')
            ->willReturn([
                'city' => 'London',
                'conditions' => 'Clear',
                'icon_condition' => 'https://openweathermap.org/img/w/01d.png',
                'temp' => 15,
                'feels_like' => 14,
                'humidity' => 80,
                'temp_min' => 10,
                'temp_max' => 20,
                'wind_speed' => 5,
                'rain' => 0,
            ]);

        $this->app->instance(WeatherService::class, $weatherServiceMock);

        // Run the command
        $this->artisan('app:weather-search', ['city' => 'London'])
            ->expectsOutput('Weather data for London:')
            ->expectsOutput('City: London')
            ->expectsOutput('Conditions: Clear')
            ->expectsOutput('Temperature: 15°C')
            ->expectsOutput('Feels Like: 14°C')
            ->expectsOutput('Humidity: 80%')
            ->expectsOutput('Min Temperature: 10°C')
            ->expectsOutput('Max Temperature: 20°C')
            ->expectsOutput('Wind Speed: 5 mph')
            ->expectsOutput('Rain: 0 mm')
            ->expectsOutput('Icon: https://openweathermap.org/img/w/01d.png')
            ->assertExitCode(0);
    }

    public function test_weather_search_with_invalid_city()
    {
        // Mock the WeatherService
        $weatherServiceMock = $this->createMock(WeatherService::class);
        $weatherServiceMock->method('getWeatherData')
            ->willThrowException(new Exception('Invalid city name. Please enter a valid city.'));

        $this->app->instance(WeatherService::class, $weatherServiceMock);

        // Run the command
        $this->artisan('app:weather-search', ['city' => 'InvalidCity'])
            ->expectsOutput('Error: Invalid city name. Please enter a valid city.')
            ->assertExitCode(0);
    }
}