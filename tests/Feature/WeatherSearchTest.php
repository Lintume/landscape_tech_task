<?php

namespace Tests\Feature;

use App\Livewire\WeatherSearch;
use Dnsimmons\OpenWeather\OpenWeather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WeatherSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_weather_with_valid_city()
    {
        // Mock the OpenWeather service
        $weatherMock = $this->createMock(OpenWeather::class);
        $weatherMock->method('getCurrentWeatherByCityName')
            ->willReturn([
                'name' => 'London',
                'condition' => ['desc' => 'Clear', 'icon' => '01d'],
                'forecast' => [
                    'temp' => 15,
                    'feels_like' => 14,
                    'humidity' => 80,
                    'temp_min' => 10,
                    'temp_max' => 20,
                ],
                'wind' => ['speed' => 5],
                'rain' => ['1h' => 0],
            ]);

        // Test the component
        Livewire::test(WeatherSearch::class)
            ->set('city', 'London')
            ->call('searchWeather', $weatherMock)
            ->assertSet('weatherData.city', 'London')
            ->assertSet('weatherData.conditions', 'Clear')
            ->assertSet('weatherData.temp', 15)
            ->assertSet('weatherData.feels_like', 14)
            ->assertSet('weatherData.humidity', 80)
            ->assertSet('weatherData.temp_min', 10)
            ->assertSet('weatherData.temp_max', 20)
            ->assertSet('weatherData.wind_speed', round(5 * 2.23694))
            ->assertSet('weatherData.rain', 0)
            ->assertOk()
            ->assertHasNoErrors();
    }

    public function test_search_weather_with_invalid_city()
    {
        // Mock the OpenWeather service
        $weatherMock = $this->createMock(OpenWeather::class);
        $weatherMock->method('getCurrentWeatherByCityName')
            ->willReturn(null);

        // Test the component
        Livewire::test(WeatherSearch::class)
            ->set('city', 'InvalidCity')
            ->call('searchWeather', $weatherMock)
            ->assertSet('weatherData', null)
            ->assertSee('Invalid city name. Please enter a valid city.')
            ->assertHasErrors(['city' => 'Invalid city name. Please enter a valid city.']);
    }
}