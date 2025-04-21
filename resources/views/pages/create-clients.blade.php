@extends('layouts.layout')

@section('title', 'Create Client')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-center">Create a New Client</h1>

<form action="{{ route('clients.store') }}" method="POST" class="space-y-8">
    @csrf

    <!-- Client Details Section -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Client Details</h2>

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Client Name:</label>
            <input type="text" name="name" id="name" class="border rounded p-2 w-full" placeholder="Enter client name" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email Address:</label>
            <input type="email" name="email" id="email" class="border rounded p-2 w-full" placeholder="Enter client email" required>
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-gray-700 font-bold mb-2">Phone Number:</label>
            <input type="text" name="phone" id="phone" class="border rounded p-2 w-full" placeholder="Enter client phone number">
        </div>
    </div>

    <!-- Address Section -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Address Details</h2>

        <div class="mb-4">
            <label for="add1" class="block text-gray-700 font-bold mb-2">Address Line 1:</label>
            <input type="text" name="add1" id="add1" class="border rounded p-2 w-full" placeholder="Enter address line 1">
        </div>

        <div class="mb-4">
            <label for="add2" class="block text-gray-700 font-bold mb-2">Address Line 2:</label>
            <input type="text" name="add2" id="add2" class="border rounded p-2 w-full" placeholder="Enter address line 2 (optional)">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="city" class="block text-gray-700 font-bold mb-2">City:</label>
                <input type="text" name="city" id="city" class="border rounded p-2 w-full" placeholder="Enter city">
            </div>

            <div class="mb-4">
                <label for="state" class="block text-gray-700 font-bold mb-2">State:</label>
                <input type="text" name="state" id="state" class="border rounded p-2 w-full" placeholder="Enter state">
            </div>
        </div>

        <div class="mb-4">
            <label for="zip" class="block text-gray-700 font-bold mb-2">ZIP Code:</label>
            <input type="text" name="zip" id="zip" class="border rounded p-2 w-full" placeholder="Enter ZIP code">
        </div>
    </div>

    <!-- Client Contacts Section -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Client Contacts</h2>

        <div id="contacts-container">
            <div class="contact-item mb-4">
                <label for="contacts[0][name]" class="block text-gray-700 font-bold mb-2">Contact Name:</label>
                <input type="text" name="contacts[0][name]" class="border rounded p-2 w-full" placeholder="Enter contact name">

                <label for="contacts[0][email]" class="block text-gray-700 font-bold mb-2 mt-4">Contact Email:</label>
                <input type="email" name="contacts[0][email]" class="border rounded p-2 w-full" placeholder="Enter contact email">

                <label for="contacts[0][phone]" class="block text-gray-700 font-bold mb-2 mt-4">Contact Phone:</label>
                <input type="text" name="contacts[0][phone]" class="border rounded p-2 w-full" placeholder="Enter contact phone">
            </div>
        </div>

        <button type="button" id="add-contact" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Add Contact
        </button>
    </div>

    <!-- Additional Details Section -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Additional Details</h2>

        <div class="mb-4">
            <label for="website" class="block text-gray-700 font-bold mb-2">Website:</label>
            <input type="url" name="website" id="website" class="border rounded p-2 w-full" placeholder="Enter client website (optional)">
        </div>

        <div class="mb-4">
            <label for="logo" class="block text-gray-700 font-bold mb-2">Logo:</label>
            <input type="file" name="logo" id="logo" class="border rounded p-2 w-full" accept="image/*">
        </div>
    </div>

    <!-- Submit Button -->
    <div class="text-center">
        <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">
            Create Client
        </button>
    </div>
</form>

<script>
    document.getElementById('add-contact').addEventListener('click', function () {
        const container = document.getElementById('contacts-container');
        const contactCount = container.children.length;

        const contactItem = document.createElement('div');
        contactItem.classList.add('contact-item', 'mb-4');

        contactItem.innerHTML = `
            <label for="contacts[${contactCount}][name]" class="block text-gray-700 font-bold mb-2">Contact Name:</label>
            <input type="text" name="contacts[${contactCount}][name]" class="border rounded p-2 w-full" placeholder="Enter contact name">

            <label for="contacts[${contactCount}][email]" class="block text-gray-700 font-bold mb-2 mt-4">Contact Email:</label>
            <input type="email" name="contacts[${contactCount}][email]" class="border rounded p-2 w-full" placeholder="Enter contact email">

            <label for="contacts[${contactCount}][phone]" class="block text-gray-700 font-bold mb-2 mt-4">Contact Phone:</label>
            <input type="text" name="contacts[${contactCount}][phone]" class="border rounded p-2 w-full" placeholder="Enter contact phone">

            <button type="button" class="remove-contact bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mt-4">
                Remove Contact
            </button>
        `;

        container.appendChild(contactItem);

        // Add event listener to remove button
        contactItem.querySelector('.remove-contact').addEventListener('click', function () {
            contactItem.remove();
        });
    });
</script>
@endsection