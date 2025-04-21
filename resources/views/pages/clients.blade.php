@extends('layouts.layout')

@section('title', 'Clients')

@section('content')
<h1 class="text-4xl font-extrabold text-center text-green-600 mb-8">Clients</h1>

    <!-- New Client Button -->
    <div class="mb-6 text-center">
        <a href="{{ route('clients.create') }}" 
        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
            + New Client
        </a>
    </div>

 <!-- Search Bar -->
 <div class="mb-6 relative">
        <input type="text" id="search" placeholder="Search clients..." 
               class="w-full py-2 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <ul id="suggestions" class="bg-white border border-gray-300 rounded-lg mt-2 hidden"></ul>
    </div>

    <style>
        #suggestions {
            list-style-type: none;
            padding: 0;
            margin: 0;
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            width: 100%;
            z-index: 1000;
        }

        #suggestions li {
            padding: 10px;
            cursor: pointer;
        }

        #suggestions li:hover {
            background: #f0f0f0;
        }
    </style>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($clients as $client)
        <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <!-- Client Logo -->
            @if (!empty($client->logo))
            <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client['name'] }} Logo" class="h-20 w-20 rounded-full mx-auto mb-4 border-2 border-gray-300" loading="lazy">            @else
                <div class="h-20 w-20 bg-gray-300 rounded-full mx-auto mb-4 flex items-center justify-center border-2 border-gray-300">
                    <span class="text-gray-500 font-semibold">No Logo</span>
                </div>
            @endif

            <!-- Client Details -->
            <h2 class="text-xl font-bold text-gray-800 text-center mb-2">{{ $client['name'] ?? 'No Name Provided' }}</h2>
            <p class="text-sm text-gray-600 text-center mb-1">{{ $client['email'] ?? 'No email provided' }}</p>
            <p class="text-sm text-gray-600 text-center mb-4">{{ $client['phone'] ?? 'No phone provided' }}</p>
            
            
            <!-- Address -->
            <div class="mt-4 text-sm text-gray-600 text-center">
                <p>{{ $client['add1'] }}</p>
                <p>{{ $client['city'] }}, {{ $client['state'] }} {{ $client['zip'] }}</p>
            </div>

            <!-- Harvest Details -->
            @if (!empty($client['harvest_id']))
                <div class="mt-4 text-center bg-gray-100 p-4 rounded-lg">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Harvest Details</h3>
                    <p class="text-sm text-gray-600">Harvest ID: <span class="font-medium">{{ $client['harvest_id'] }}</span></p>
                    <p class="text-sm text-gray-600">Currency: <span class="font-medium">{{ $client['currency'] }}</span></p>
                    <p class="text-sm text-gray-600">Created At: <span class="font-medium">{{ \Carbon\Carbon::parse($client['created_at'])->format('M d, Y') }}</span></p>
                </div>
            @endif

            <!-- Contacts (only for database clients) -->
            @if (!empty($client['contacts']))
                <div class="mt-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Contacts:</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        @foreach ($client['contacts'] as $contact)
                            <li>
                                <span class="font-medium">{{ $contact['name'] }}</span> - 
                                {{ $contact['email'] }} - {{ $contact['phone'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
     <!-- Action Buttons -->
     <div class="mt-6 flex justify-center space-x-4">
    <!-- Buttons for Database Clients -->
    @if ($client['type'] === 'database')
        <a href="{{ route('clients.edit', $client['id']) }}" 
           class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
            Edit
        </a>
        <a href="{{ route('clients.show', $client['id']) }}" 
           class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
            View Details
        </a>
    @endif

    <!-- Buttons for Harvest API Clients -->
    @if ($client['type'] === 'harvest')
        <a href="{{ route('harvest.clients.edit', ['harvest_id' => $client['harvest_id']]) }}" 
           class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
            Edit Harvest
        </a>
        <a href="https://indiciadesigncreativellc.harvestapp.com/clients/{{ $client['harvest_id'] }}" 
           target="_blank" 
           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            View Harvest
        </a>
    @endif
</div>
</div>
@endforeach
</div>
{{ $clients->links() }}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const suggestions = document.getElementById('suggestions');
        let selectedClient = null; // Track the selected client

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim();

            if (query.length > 1) {
                fetch('/autocomplete?query=' + query + '&type=clients')
                    .then(response => response.json())
                    .then(data => {
                        suggestions.innerHTML = '';
                        selectedClient = null; // Reset selected client
                        data.forEach(client => {
                            const li = document.createElement('li');
                            li.textContent = client.name; // Display client name
                            li.dataset.client = JSON.stringify(client);
                            li.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                            li.addEventListener('click', () => {
                                // Redirect to the client details page
                                if (client.id) {
                                    window.location.href = `/clients/${client.id}`;
                                } else if (client.harvest_id) {
                                    window.location.href = `https://indiciadesigncreativellc.harvestapp.com/clients/${client.harvest_id}`;
                                }
                            });
                            li.addEventListener('mouseenter', () => {
                                selectedClient = client; // Set the selected client on hover
                                console.log('Selected client:', selectedClient);
                            });
                            suggestions.appendChild(li);
                        });
                        suggestions.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                    });
            } else {
                suggestions.innerHTML = '';
                suggestions.classList.add('hidden');
            }
        });

        // Handle Enter key press
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent form submission
                if (!selectedClient && suggestions.firstChild) {
                    // Set the first suggestion as the selected client if none is hovered
                    const firstSuggestion = suggestions.firstChild;
                    selectedClient = JSON.parse(firstSuggestion.dataset.client);
                }

                if (selectedClient) {
                    if (selectedClient.id) {
                        window.location.href = `/clients/${selectedClient.id}`;
                    } else if (selectedClient.harvest_id) {
                        window.location.href = `https://indiciadesigncreativellc.harvestapp.com/clients/${selectedClient.harvest_id}`;
                    }
                }
            }
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('#search') && !e.target.closest('#suggestions')) {
                suggestions.innerHTML = '';
                suggestions.classList.add('hidden');
            }
        });
    });
</script>
@endsection