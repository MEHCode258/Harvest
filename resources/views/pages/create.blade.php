@extends('layouts.layout')

@section('title', 'Create Proposal')

@section('content')
<h1 class="text-3xl font-bold mb-4">Create a Business Proposal</h1>
<p class="mb-6">Fill out the form below to create a new business proposal.</p>

<form action="{{ route('proposals.store') }}" method="POST" class="space-y-4">
    @csrf

    <!-- Title -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
        <input type="text" name="title" id="title" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
    </div>

    <!-- Client Dropdown -->
    <div>
    <label for="client_id" class="block text-sm font-medium text-gray-700">Client (optional):</label>
    <select name="client_id" id="client_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        <option value="">Select a client</option>
        @foreach($clients as $client)
            <option value="{{ is_object($client) ? $client->id : $client['id'] }}">
                {{ is_object($client) ? $client->name : $client['name'] }}
            </option>
        @endforeach
    </select>
</div>

    <!-- Project Dropdown -->
    <div class="mb-4">
    <label for="projects" class="block text-sm font-medium text-gray-700">Select Projects</label>
    <select name="projects[]" id="projects" multiple class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        @foreach ($projects as $project)
        <option value="{{ $project->id }}" data-estimate="{{ $project->estimate }}">
            {{ $project->name }}
        </option>
        @endforeach
    </select>
</div>

    <!-- Estimate -->
    <div>
        <label for="estimate" class="block text-sm font-medium text-gray-700">Estimate:</label>
        <input type="number" name="estimate" id="estimate" readonly class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
    </div>

    <!-- Content -->
    <div>
        <label for="content" class="block text-sm font-medium text-gray-700">Content:</label>
        <textarea name="content" id="content" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="mt-4 w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
        Create Proposal
    </button>
</form>

<script>
     document.addEventListener('DOMContentLoaded', function () {
        const projectSelect = document.getElementById('projects');
        const estimateInput = document.getElementById('estimate');

        // Function to calculate the total estimate
        function updateEstimate() {
            let totalEstimate = 0;

            // Loop through selected options
            Array.from(projectSelect.selectedOptions).forEach(option => {
                const projectEstimate = parseFloat(option.getAttribute('data-estimate')) || 0;
                totalEstimate += projectEstimate;
            });

            // Update the estimate input field
            estimateInput.value = totalEstimate.toFixed(2); // Format to 2 decimal places
        }

        // Add event listener to update the estimate when the selection changes
        projectSelect.addEventListener('change', updateEstimate);
    });
</script>
@endsection