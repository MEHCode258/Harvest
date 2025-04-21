@extends('layouts.layout')

@section('title', 'Client Details')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold text-center text-green-600 mb-8">Client Details</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Client Details -->
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $client->name }}</h2>
            <p class="text-sm text-gray-600"><strong>Email:</strong> {{ $client->email ?? 'No email provided' }}</p>
            <p class="text-sm text-gray-600"><strong>Phone:</strong> {{ $client->phone ?? 'No phone provided' }}</p>
            <p class="text-sm text-gray-600"><strong>Address:</strong> {{ $client->add1 }}, {{ $client->city }}, {{ $client->state }} {{ $client->zip }}</p>
            <p class="text-sm text-gray-600"><strong>Website:</strong> <a href="{{ $client->website }}" target="_blank" class="text-blue-500">{{ $client->website }}</a></p>

            <!-- Contacts -->
            <div class="mt-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Contacts:</h3>
                @if (!empty($client['contacts']))
                    <ul class="text-sm text-gray-600 space-y-1">
                        @foreach ($client['contacts'] as $contact)
                            <li>
                                <span class="font-medium">{{ $contact['name'] }}</span> - 
                                {{ $contact['email'] ?? 'No email' }} - 
                                {{ $contact['phone'] ?? 'No phone' }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No contacts available.</p>
                @endif
            </div>

            <!-- Back Button -->
            <div class="mt-6 text-center">
                <a href="{{ route('clients.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                    Back to Clients
                </a>
            </div>
        </div>
    </div>
</div>
@endsection