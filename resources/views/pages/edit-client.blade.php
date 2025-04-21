@extends('layouts.layout')

@section('title', 'Edit Client')

@section('content')
<h1 class="text-3xl font-bold mb-6">Edit Client</h1>

<div class="bg-white shadow-lg rounded p-6">
<form action="{{ isset($client['harvest_id']) ? route('harvest.clients.update', $client['harvest_id']) : route('clients.update', $client->id ?? '') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div class="mb-4">
        <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
        <input type="text" name="name" id="name" value="{{ old('name', $client['name'] ?? $client->name) }}" class="border rounded p-2 w-full" required>
    </div>

    <!-- Email -->
    <div class="mb-4">
        <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email', $client['email'] ?? $client->email) }}" class="border rounded p-2 w-full">
    </div>

    <!-- Phone -->
    <div class="mb-4">
        <label for="phone" class="block text-gray-700 font-bold mb-2">Phone:</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $client['phone'] ?? $client->phone) }}" class="border rounded p-2 w-full">
    </div>

    <div class="mt-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Contacts</h3>
    @if (!empty($client['contacts']))
        <ul class="space-y-4">
            @foreach ($client['contacts'] as $contact)
                <li class="flex flex-col space-y-2">
                    <label>
                        <span class="text-sm font-medium text-gray-700">Name</span>
                        <input type="text" name="contacts[{{ $loop->index }}][name]" value="{{ $contact['name'] }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </label>
                    <label>
                        <span class="text-sm font-medium text-gray-700">Email</span>
                        <input type="email" name="contacts[{{ $loop->index }}][email]" value="{{ $contact['email'] }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </label>
                    <label>
                        <span class="text-sm font-medium text-gray-700">Phone</span>
                        <input type="text" name="contacts[{{ $loop->index }}][phone]" value="{{ $contact['phone'] }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </label>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">No contacts available.</p>
    @endif
</div>

    <!-- Address Line 1 -->
    <div class="mb-4">
        <label for="add1" class="block text-gray-700 font-bold mb-2">Address Line 1:</label>
        <input type="text" name="add1" id="add1" value="{{ old('add1', $client['add1'] ?? $client->add1) }}" class="border rounded p-2 w-full">
    </div>

    <!-- City -->
    <div class="mb-4">
        <label for="city" class="block text-gray-700 font-bold mb-2">City:</label>
        <input type="text" name="city" id="city" value="{{ old('city', $client['city'] ?? $client->city) }}" class="border rounded p-2 w-full">
    </div>

    <!-- State -->
    <div class="mb-4">
        <label for="state" class="block text-gray-700 font-bold mb-2">State:</label>
        <input type="text" name="state" id="state" value="{{ old('state', $client['state'] ?? $client->state) }}" class="border rounded p-2 w-full">
    </div>

    <!-- ZIP Code -->
    <div class="mb-4">
        <label for="zip" class="block text-gray-700 font-bold mb-2">ZIP Code:</label>
        <input type="text" name="zip" id="zip" value="{{ old('zip', $client['zip'] ?? $client->zip) }}" class="border rounded p-2 w-full">
    </div>

    <!-- Website -->
    <div class="mb-4">
        <label for="website" class="block text-gray-700 font-bold mb-2">Website:</label>
        <input type="url" name="website" id="website" 
       value="{{ old('website', $client['website'] ?? $client->website ?? '') }}" 
       class="border rounded p-2 w-full">
    </div>

    <!-- Hidden Harvest ID -->
    <input type="hidden" name="harvest_id" value="{{ $client['harvest_id'] ?? '' }}">

    <!-- Submit Button -->
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Update Client
    </button>
</form>