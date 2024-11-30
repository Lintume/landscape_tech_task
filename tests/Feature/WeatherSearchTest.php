<?php

namespace Tests\Feature;

use App\Livewire\WeatherSearch;
use App\Services\WeatherService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Tests\TestCase;

class WeatherSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_weather_with_valid_city()
    {
        // Mock the OpenWeather service
        $weatherMock = $this->createMock(WeatherService::class);
        $weatherMock->method('getWeatherData')
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
            ->assertSet('weatherData.wind_speed', 5)
            ->assertSet('weatherData.rain', 0)
            ->assertOk()
            ->assertHasNoErrors();
    }

    public function test_search_weather_with_invalid_city()
    {
        // Mock the OpenWeather service
        $weatherMock = $this->createMock(WeatherService::class);
        $weatherMock->method('getWeatherData')
            ->willThrowException(ValidationException::withMessages(['city' => 'Invalid city name. Please enter a valid city.']));

        // Test the component
        Livewire::test(WeatherSearch::class)
            ->set('city', 'InvalidCity')
            ->call('searchWeather', $weatherMock)
            ->assertSet('weatherData', null)
            ->assertSee('Invalid city name. Please enter a valid city.')
            ->assertHasErrors(['city' => 'Invalid city name. Please enter a valid city.']);
    }
}