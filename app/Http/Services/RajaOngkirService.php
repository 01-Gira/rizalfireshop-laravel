<?php 

namespace App\Http\Services;
use GuzzleHttp\Client;

class RajaOngkirService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => config('rajaongkir.base_url')]);
        $this->apiKey = config('rajaongkir.api_key');
    }

    public function provinces()
    {
        $response = $this->client->get('province', [
            'headers' => [
                'key' => $this->apiKey,
            ],
        ]);
    
        return json_decode($response->getBody(), true)['rajaongkir']['results'];
    }

    public function cities($provinceId)
    {
        $response = $this->client->get('city', [
            'headers' => [
                'key' => $this->apiKey,
            ],
            'query' => [
                'province' => $provinceId,
            ],
        ]);

        return json_decode($response->getBody(), true)['rajaongkir']['results'];
    }

    public function cost($destination, $weight, $courier)
    {
        $origin = env('RAJAONGKIR_ORIGIN');

        $response = $this->client->post('cost', [
            'headers' => [
                'key' => $this->apiKey,
            ],
            'form_params' => [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier,
            ],
        ]);

        return json_decode($response->getBody(), true)['rajaongkir']['results'];

    }
}

