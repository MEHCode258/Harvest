
@extends('layouts.layout')

@section('title', 'Projects')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold text-center text-green-600 mb-8">Projects</h1>

        <!-- Search Bar -->
        <div class="mb-6 relative">
            <input type="text" id="search" placeholder="Search projects..." 
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
        <div class="mb-6 text-center">
            <a href="{{ route('projects.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Create New Project
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($projects->isEmpty())
                <p class="text-gray-600 text-center">No projects available.</p>
            @else
                <h2 class="text-2xl font-bold mb-4">Projects</h2>
                <ul class="space-y-6">
                    @foreach ($projects as $project)
                        <li class="border border-gray-200 rounded-lg p-6 bg-gray-50 hover:bg-gray-100 transition">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $project->name }}</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- General Information -->
                                <div>
                                    <p class="text-sm text-gray-600"><strong>Code:</strong> {{ $project->code ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600"><strong>Description:</strong> {{ $project->description ?? 'No description available' }}</p>
                                    <p class="text-sm text-gray-600"><strong>Notes:</strong> {{ $project->notes ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600"><strong>Average Hours:</strong> {{ $project->average_hours ?? 'N/A' }}</p>
                                </div>

                                <!-- Dates -->
                                <div>
                                    <p class="text-sm text-gray-600"><strong>Start Date:</strong> {{ $project->start_date }}</p>
                                    <p class="text-sm text-gray-600"><strong>End Date:</strong> {{ $project->end_date }}</p>
                                </div>

                                <!-- Estimate Details -->
                                <div>
                                    <p class="text-sm text-gray-600"><strong>Estimate Type:</strong> {{ $project->estimate_type ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600"><strong>Billable Rate Type:</strong> {{ $project->billable_rate_type ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600"><strong>Hourly Rate:</strong> ${{ $project->rate ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600"><strong>Fixed Fee:</strong> ${{ $project->fixed_fee ?? 'N/A' }}</p>
                                </div>

                                <!-- Budget Details -->
                                <div>
                                    <p class="text-sm text-gray-600"><strong>Budget Type:</strong> {{ $project->budget_type ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600"><strong>Budget Amount:</strong> ${{ $project->budget_amount ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600"><strong>Budget Reset:</strong> {{ $project->budget_reset ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600"><strong>Alert Percentage:</strong> {{ $project->alert_percentage ?? 'N/A' }}%</p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4 flex space-x-4">
                                <!-- Edit Button -->
                                <a href="{{ route('projects.edit', $project->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

<script>
   document.addEventListener('DOMContentLoaded', function () {
       const searchInput = document.getElementById('search');
       const suggestions = document.getElementById('suggestions');
       let projectsData = []; // Store fetched projects for comparison

       // Handle input event for search
       searchInput.addEventListener('input', function () {
           const query = searchInput.value.trim();

           if (query.length > 1) {
               fetch(`/autocomplete?query=${query}&type=projects`)
                   .then(response => {
                       if (!response.ok) {
                           throw new Error('Network response was not ok');
                       }
                       return response.json();
                   })
                   .then(data => {
                       projectsData = data; // Store the fetched projects
                       suggestions.innerHTML = '';
                       data.forEach(project => {
                           const li = document.createElement('li');
                           li.textContent = project.name; // Use 'name' consistently
                           li.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                           li.addEventListener('click', () => {
                               // Redirect to the project details page
                               window.location.href = `/projects/${project.id}`;
                           });
                           suggestions.appendChild(li);
                       });
                       suggestions.classList.remove('hidden'); // Show suggestions
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
               const query = searchInput.value.trim();
               const matchedProject = projectsData.find(project => project.name.toLowerCase() === query.toLowerCase());
               if (matchedProject) {
                   // Redirect to the project details page
                   window.location.href = `/projects/${matchedProject.id}`;
               }
           }
       });

       // Hide suggestions when clicking outside
       document.addEventListener('click', function (e) {
           if (!e.target.closest('#search') && !e.target.closest('#suggestions')) {
               suggestions.innerHTML = '';
               suggestions.classList.add('hidden');
           }
       });
   });
</script>

@endsection