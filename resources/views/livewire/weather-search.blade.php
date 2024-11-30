<div class="container ml-10 mt-10">
    <!-- Search Form -->
    <div class="mb-4">
        <h1 class="text-2xl font-bold mb-2">Weather Search</h1>
        <form wire:submit.prevent="searchWeather">
            <input
                type="text"
                wire:model.defer="city"
                placeholder="Enter a UK city..."
                class="border border-gray-300 rounded p-2 w-full"
            />
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 mt-2 rounded hover:bg-blue-600">
                Search
            </button>
        </form>
    </div>

    <!-- Error Message -->
    @error('city')
    <p class='text-sm text-red-600'>{{ $message }}</p>
    @enderror

    <!-- Weather Results -->
    @if ($weatherData)
        <div class="bg-gray-100 p-4 rounded shadow">
            <h2 class="text-xl font-bold mb-2">Weather in {{ $weatherData['city'] }}</h2>
            <p><strong>Current Conditions:</strong> {{ $weatherData['conditions'] }}</p>
            @if($weatherData['icon_condition'])
                <img src="{{ $weatherData['icon_condition'] }}" alt="Weather Icon">
            @endif
            <p><strong>Temperature:</strong> {{ $weatherData['temp'] }} °C</p>
            <p><strong>Feels Like:</strong> {{ $weatherData['feels_like'] }} °C</p>
            <p><strong>Humidity:</strong> {{ $weatherData['humidity'] }}%</p>
            <p><strong>Min Temp:</strong> {{ $weatherData['temp_min'] }} °C</p>
            <p><strong>Max Temp:</strong> {{ $weatherData['temp_max'] }} °C</p>
            <p><strong>Wind Speed:</strong> {{ $weatherData['wind_speed'] }} mph</p>
            <p><strong>Rain (Last Hour):</strong> {{ $weatherData['rain'] ?? 'No data' }} mm</p>
        </div>
    @endif
</div>
