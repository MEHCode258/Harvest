<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Job;
use App\Services\HarvestService;
use Illuminate\Pagination\LengthAwarePaginator;



class ClientController extends Controller
{
   

    protected $harvestService;

    public function __construct(HarvestService $harvestService)
    {
        $this->harvestService = $harvestService;
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'add1' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip' => 'nullable|string',
            'harvest_id' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contacts' => 'nullable|array',
            'contacts.*.name' => 'nullable|string',
            'contacts.*.email' => 'nullable|email',
            'contacts.*.phone' => 'nullable|string',
        ]);
    
        // Save the updated clients back to the session

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Client::create($request->all()); // Save client to the database

        if (!empty($data['contacts'])) {
            foreach ($data['contacts'] as $contact) {
                $client->contacts()->create($contact);
            }
        }

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function show($id)
    {
        // Fetch the client from the database
        $client = Client::findOrFail($id);
        $client = Client::with('contacts')->findOrFail($id);

        // Pass the client data to the view
        return view('pages.client-details', compact('client'));
    }

    public function index(HarvestService $harvestService)
{
    // Fetch database clients with contacts and add the 'type' property
    $dbClients = Client::with('contacts')->get()->map(function ($client) {
        $clientArray = $client->toArray(); // Convert Eloquent model to array
        $clientArray['type'] = 'database'; // Add 'type' for database clients
        return $clientArray; // Return as an array
    });

    // Fetch Harvest clients and add the 'type' property
    try {
        $harvestClients = collect($harvestService->getClients()['clients'] ?? [])->map(function ($client) use ($harvestService) {
            return [
                'id' => null, // Harvest clients don't have a database ID
                'name' => $client['name'] ?? 'N/A',
                'email' => $client['email'] ?? 'N/A',
                'phone' => $client['phone'] ?? 'N/A',
                'add1' => $client['address'] ?? 'N/A',
                'city' => $client['city'] ?? 'N/A',
                'state' => $client['state'] ?? 'N/A',
                'zip' => $client['postal_code'] ?? 'N/A',
                'currency' => $client['currency'] ?? 'N/A',
                'website' => $client['website'] ?? null,
                'created_at' => $client['created_at'] ?? 'N/A',
                'updated_at' => $client['updated_at'] ?? 'N/A',
                'harvest_id' => $client['id'] ?? null, // Add Harvest ID
                'contacts' => $harvestService->getContacts($client['id']), // Fetch contacts
                'type' => 'harvest', // Add 'type' for Harvest clients
            ];
        });
    } catch (\Exception $e) {
        \Log::error('Error fetching Harvest clients: ' . $e->getMessage());
        $harvestClients = collect(); // Fallback to an empty collection if Harvest API fails
    }

    // Merge database clients and Harvest clients
    $mergedClients = $dbClients->merge($harvestClients);

    // Paginate the merged collection
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 10; // Number of items per page
    $currentItems = $mergedClients->slice(($currentPage - 1) * $perPage, $perPage)->values();
    $clients = new LengthAwarePaginator($currentItems, $mergedClients->count(), $perPage, $currentPage, [
        'path' => LengthAwarePaginator::resolveCurrentPath(),
    ]);

    return view('pages.clients', compact('clients'));
}
    public function update(Request $request, $id)
    {
        // Check if the client is a database client or a Harvest client
        $isHarvestClient = $request->input('is_harvest_client', false);

        if ($isHarvestClient) {
            // Update Harvest client
            $harvestService = app('App\Services\HarvestService');
            try {
                $data = $request->only(['name', 'email', 'phone', 'address', 'city', 'state', 'postal_code', 'currency', 'website']);
                $harvestService->updateClient($id, $data);
                return redirect()->back()->with('success', 'Harvest client updated successfully.');
            } catch (\Exception $e) {
                \Log::error('Error updating Harvest client: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to update Harvest client.');
            }
        } else {
            // Update database client
            $client = Client::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email',
                'phone' => 'nullable|string',
                'add1' => 'nullable|string',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'zip' => 'nullable|string',
                'currency' => 'nullable|string',
                'website' => 'nullable|url',
            ]);

            $client->update($validated);
            return redirect()->back()->with('success', 'Client updated successfully.');
        }
    }

    public function edit(Client $client)
    {
        $client->load('contacts');
        return view('pages.edit-client', compact('client')); // Pass the client to the view
    }

    public function create()
    {
        return view('pages.create-clients'); // Ensure this view exists
    }

    public function editHarvestClient($harvest_id)
    {
        // Fetch the Harvest client using the HarvestService
        try {
            $harvestClient = app('App\Services\HarvestService')->get("clients/{$harvest_id}");
            $contacts = app('App\Services\HarvestService')->getContacts($harvest_id);
            $client = [
                'id' => null, // No local ID for Harvest clients
                'name' => $harvestClient['name'] ?? 'N/A',
                'email' => $harvestClient['email'] ?? 'N/A',
                'phone' => $harvestClient['phone'] ?? 'N/A',
                'add1' => $harvestClient['address'] ?? 'N/A',
                'city' => $harvestClient['city'] ?? 'N/A',
                'state' => $harvestClient['state'] ?? 'N/A',
                'zip' => $harvestClient['postal_code'] ?? 'N/A',
                'website' => $harvestClient['website'] ?? null,
                'harvest_id' => $harvest_id,
            ];
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'Failed to fetch Harvest client: ' . $e->getMessage());
        }

        return view('pages.edit-client', compact('client'));
    }

    public function updateHarvestClient(Request $request, $harvest_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'add1' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        try {
            app('App\Services\HarvestService')->updateClient($harvest_id, $request->only([
                'name', 'email', 'phone', 'add1', 'city', 'state', 'zip', 'website'
            ]));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Harvest client: ' . $e->getMessage());
        }

        return redirect()->route('clients.index')->with('success', 'Harvest client updated successfully.');
    }

    public function getContacts($clientId)
    {
        return Cache::remember("harvest_contacts_{$clientId}", now()->addMinutes(10), function () use ($clientId) {
            try {
                $response = $this->get("clients/{$clientId}/contacts");
                return $response['contacts'] ?? []; // Return the contacts array
            } catch (\Exception $e) {
                \Log::error('Error fetching Harvest contacts: ' . $e->getMessage());
                return []; // Return an empty array if the API call fails
            }
        });
    }
}