<?php

namespace App\Services;

use Dnsimmons\OpenWeather\OpenWeather;
use Illuminate\Validation\ValidationException;

class WeatherService
{
    protected OpenWeather $openWeather;

    public function __construct(OpenWeather $openWeather)
    {
        $this->openWeather = $openWeather;
    }

    /**
     * Fetch and map weather data for a given city.
     *
     * @param string $city
     * @return array
     * @throws ValidationException
     */
    public function getWeatherData(string $city): array
    {
        $data = $this->openWeather->getCurrentWeatherByCityName($city, 'metric');

        if (!$data) {
            throw ValidationException::withMessages(['city' => 'Invalid city name. Please enter a valid city.']);
        }

        return [
            'city' => $data['name'] ?? $city,
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
}