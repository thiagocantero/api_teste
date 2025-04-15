<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class WeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:check {city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the weather for a given city';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $city = $this->argument('city');
        $apiKey = 'WEATHER_API_KEY'; // Substitua pela sua chave de API
        $endpoint = "http://api.openweathermap.org/data/2.5/weather";

        $response = Http::get($endpoint, [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric', // Retornar temperatura em Celsius
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->info("Weather in {$city}: {$data['weather'][0]['description']}");
            $this->info("Temperature: {$data['main']['temp']}°C");
        } else {
            $this->error("Could not retrieve weather data for {$city}.");
        }
    }
}