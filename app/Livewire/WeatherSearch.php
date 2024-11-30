<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Dnsimmons\OpenWeather\OpenWeather;

/**
 * Class WeatherSearch
 * Handles the weather search functionality.
 */
class WeatherSearch extends Component
{
    /**
     * @var string $city The city name to search for weather.
     */
    #[Validate('required|string')]
    public string $city;

    /**
     * @var array|null $weatherData The weather data returned from the API.
     */
    public ?array $weatherData = null;

    /**
     * Searches for the current weather by city name.
     *
     * @param OpenWeather $weather The OpenWeather service instance.
     * @return void
     * @throws ValidationException If the city name is invalid.
     */
    public function searchWeather(OpenWeather $weather): void
    {
        $this->validate();

        // Fetch weather data using OpenWeather package
        $data = $weather->getCurrentWeatherByCityName($this->city, 'metric');
        if (!$data) {
            throw ValidationException::withMessages(['city' => 'Invalid city name. Please enter a valid city.']);
        }

        // Map data to match the UI requirements
        $this->weatherData = [
            'city' => $data['name'] ?? $this->city,
            'conditions' => $data['condition']['desc'] ?? 'N/A',
            'icon_condition' => $data['condition']['icon'] ?? null,
            'temp' => $data['forecast']['temp'] ?? 'N/A',
            'feels_like' => $data['forecast']['feels_like'] ?? 'N/A',
            'humidity' => $data['forecast']['humidity'] ?? 'N/A',
            'temp_min' => $data['forecast']['temp_min'] ?? 'N/A',
            'temp_max' => $data['forecast']['temp_max'] ?? 'N/A',
            'wind_speed' => isset($data['wind']['speed']) ? round($data['wind']['speed'] * 2.23694) : 'N/A',
            'rain' => $data['rain']['1h'] ?? 0,
        ];
    }

    /**
     * Renders the weather search component.
     *
     * @return View|Factory|Application
     */
    public function render(): View|Factory|Application
    {
        return view('livewire.weather-search');
    }
}