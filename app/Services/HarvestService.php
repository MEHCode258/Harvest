<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Services\HarvestService;

class HarvestService
{
    protected $baseUrl;
    protected $accessToken;
    protected $accountId;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.harvest.api_url'), '/'); // Ensure no trailing slash
        $this->accessToken = config('services.harvest.access_token');
        $this->accountId = config('services.harvest.account_id');

        if (!$this->baseUrl || !$this->accessToken || !$this->accountId) {
            throw new \InvalidArgumentException('Missing Harvest API configuration values.');
        }
    }

    public function get($endpoint, $params = [])
    {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/'); // Ensure proper URL formatting

        \Log::info('Harvest API URL: ' . $url); // Log the full URL for debugging

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Harvest-Account-ID' => $this->accountId,
            'Content-Type' => 'application/json',
        ])->get($url, $params);

        if ($response->failed()) {
            throw new \Exception('Harvest API request failed: ' . $response->body());
        }

        return $response->json();
    }

        public function put($endpoint, $data = [])
    {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/'); // Ensure proper URL formatting

        \Log::info('Harvest API PUT URL: ' . $url); // Log the full URL for debugging
        \Log::info('Harvest API PUT Data: ', $data); // Log the data being sent

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Harvest-Account-ID' => $this->accountId,
            'Content-Type' => 'application/json',
        ])->put($url, $data);

        if ($response->failed()) {
            throw new \Exception('Harvest API PUT request failed: ' . $response->body());
        }


        return $response->json();

    }
    public function getTasks()
    {
        return $this->get('tasks');
    }

    public function getUsers()
    {
         return $this->get('users');
    }

    public function getClients()
    {
        $response = $this->get('clients');
        \Log::info('Harvest Clients Response:', $response); // Log the raw response
        return $response;
    }

    public function updateClient($harvestId, $data)
    {
        return $this->put("clients/{$harvestId}", $data);
    }

    public function getContacts($clientId)
    {
        try {
            $response = $this->get("clients/{$clientId}/contacts");
            return $response['contacts'] ?? []; // Return the contacts array
        } catch (\Exception $e) {
            \Log::error('Error fetching Harvest contacts: ' . $e->getMessage());
            return []; // Return an empty array if the API call fails
        }
    }
}