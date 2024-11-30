<?php

namespace App\Livewire;

use App\Services\WeatherService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

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
     * @param WeatherService $weatherService
     * @return void
     * @throws ValidationException If the city name is invalid.
     */
    public function searchWeather(WeatherService $weatherService): void
    {
        $this->validate();

        try {
            $this->weatherData = $weatherService->getWeatherData($this->city);
        } catch (ValidationException $e) {
            $this->reset('weatherData');
            throw ValidationException::withMessages(['city' => 'Invalid city name. Please enter a valid city.']);
        }
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