@extends('layouts.layout')

@section('title', 'Proposals List')

@section('content')
<h1 class="text-4xl font-extrabold text-center text-green-600 mb-6">All Proposals</h1>
<p class="text-lg text-center mb-8 text-gray-700">Here are all the proposals that have been created.</p>

<!-- Link to Create a New Proposal -->
<div class="text-center mb-8">
    <a href="{{ route('proposals.create') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
        Create New Proposal
    </a>
</div>

<!-- Search Bar -->
<div class="relative max-w-2xl mx-auto mb-8">
    <input type="text" id="search" placeholder="Search proposals..." autocomplete="on"
           class="w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
    <ul id="suggestions" class="absolute left-0 right-0 bg-white border border-gray-300 rounded-lg mt-2 hidden z-10 shadow-lg"></ul>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script for Search -->
<script>
$(document).ready(function () {
    const searchInput = $('#search');
    const suggestions = $('#suggestions');

    // Handle input for search
    searchInput.on('keyup', function (e) {
        let query = $(this).val();

        if (query.length > 1) { // Start searching after 2 characters
            $.ajax({
                url: "{{ route('autocomplete') }}",
                type: "GET",
                data: { query: query, type: 'proposals' }, // Ensure 'type' is passed
                success: function (data) {
                    let suggestionsHtml = '';
                    data.forEach(function (item) {
                        suggestionsHtml += `<li class="p-3 hover:bg-gray-100 cursor-pointer" data-id="${item.id}">${item.title}</li>`;
                    });
                    suggestions.html(suggestionsHtml).removeClass('hidden');
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching search results:', error);
                }
            });
        } else {
            suggestions.html('').addClass('hidden');
        }
    });

    // Handle Enter key press
    searchInput.on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent form submission
            const query = $(this).val().trim();

            if (query.length > 1) {
                // Trigger search and redirect to the first result if available
                $.ajax({
                    url: "{{ route('autocomplete') }}",
                    type: "GET",
                    data: { query: query, type: 'proposals' },
                    success: function (data) {
                        if (data.length > 0) {
                            const firstResult = data[0];
                            window.location.href = `/proposals/${firstResult.id}/edit`; // Redirect to the edit page
                        } else {
                            alert('No results found.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching search results:', error);
                    }
                });
            }
        }
    });

    // Click on suggestion to open the edit proposal page
    $(document).on('click', '#suggestions li', function () {
        const proposalId = $(this).data('id');
        if (proposalId) {
            window.location.href = `/proposals/${proposalId}/edit`; // Redirect to the edit proposal page
        }
    });

    // Hide suggestions when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#search, #suggestions').length) {
            suggestions.html('').addClass('hidden');
        }
    });
});
</script>
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
<style>
    #suggestions {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    #suggestions li {
        padding: 10px;
        cursor: pointer;
        background: #f9f9f9;
        border-bottom: 1px solid #ddd;
        transition: background-color 0.2s ease;
    }
    #suggestions li:hover {
        background: #f0f0f0;
    }
</style>

<script>
document.querySelectorAll('.preview-pdf-button').forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        const url = this.getAttribute('data-url');
        window.open(url, '_blank');
    });
});
    document.querySelectorAll('.preview-pdf-button').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            window.open(url, '_blank');
        });
    });

</script>
<!-- List of Proposals -->
<div class="bg-white shadow-lg rounded-lg p-6">
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($proposals->isEmpty())
        <p class="text-gray-600 text-center">No proposals available.</p>
    @else
        <ul class="divide-y divide-gray-200">
    @foreach ($proposals as $proposal)
    <li class="py-4">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-gray-800">{{ $proposal->title }}</h3>
                <p class="text-sm text-gray-600">{{ $proposal->content }}</p>
                <p class="text-sm text-gray-600">Estimate: ${{ $proposal->estimate }}</p>
                <p class="text-sm text-gray-500">{{ $proposal->created_at->format('M d, Y') }}</p>
                <p class="text-sm text-gray-600">
                    <strong>Projects:</strong>
                    @foreach ($proposal->projects as $project)
                        <span class="text-blue-500">{{ $project->name }}</span>{{ !$loop->last ? ',' : '' }}
                    @endforeach
                </p>
            </div>
        </div>
    </li>
    <div class="flex flex-col space-y-2">

        <!-- Preview PDF Button -->
        <form action="{{ route('proposals.preview-pdf', $proposal->id) }}" method="GET" target="_blank" class="w-full">
            @csrf
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full">
                Preview PDF
            </button>
        </form>

        <!-- Edit Proposal Button -->
        <a href="{{ route('proposals.edit', $proposal->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-center w-full">
            Edit
        </a>

        <!-- Delete Proposal Button -->
        <form action="{{ route('proposals.destroy', $proposal->id) }}" method="POST" class="w-full">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 w-full">
                Delete
            </button>
        </form>
    </div>
</div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection