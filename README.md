# Weather Application

This is a weather application built with PHP and Laravel. It fetches current weather data from the OpenWeather API and displays it to the user.

## Features

- Fetch current weather by city name
- Display weather conditions, temperature, humidity, wind speed, and more
- Convert wind speed from metric to imperial units

## Requirements

- PHP 7.4 or higher
- Composer
- Laravel 8 or higher
- OpenWeather API key

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/yourusername/weather-app.git
    cd weather-app
    ```

2. Install dependencies:
    ```sh
    composer install
    npm install
    npm run dev
    ```

3. Copy the `.env.example` file to `.env` and update the environment variables:
    ```sh
    cp .env.example .env
    ```

4. Set your OpenWeather API key in the `.env` file:
    ```env
    OPENWEATHER_API_KEY=your_api_key_here
    ```

5. Generate an application key:
    ```sh
    php artisan key:generate
    ```

6. Run the development server:
    ```sh
    php artisan serve
    ```

## Usage

1. Open your browser and navigate to `http://localhost:8000`.
2. Enter a city name to fetch the current weather data.

## Contributing

Thank you for considering contributing to this project! Please follow the [contribution guide](CONTRIBUTING.md).

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).