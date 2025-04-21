@extends('layouts.layout')

@section('title', 'Project Details')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold text-center text-green-600 mb-8">Project Details</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Project Name -->
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $project['name'] }}</h2>

            <!-- Project Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Client -->
                <div>
                    <p class="text-sm font-semibold text-gray-700">Client:</p>
                    <p class="text-gray-600">{{ $project['client']['name'] ?? 'N/A' }}</p>
                </div>
            <div>
            <p class="text-sm font-semibold text-gray-700">Average Hours:</p>
            <p class="text-gray-600">{{ $project->average_hours ?? 'N/A' }}</p>
            </div>

                <!-- Hourly Rate -->
                <div>
                    <p class="text-sm font-semibold text-gray-700">Hourly Rate:</p>
                    <p class="text-gray-600">${{ $project['hourly_rate'] ?? 'N/A' }}</p>
                </div>

                <!-- Budget -->
                <div>
                    <p class="text-sm font-semibold text-gray-700">Budget:</p>
                    <p class="text-gray-600">{{ $project['budget'] ?? 'N/A' }}</p>
                </div>

                <!-- Description -->
                <div>
                    <p class="text-sm font-semibold text-gray-700">Description:</p>
                    <p class="text-gray-600">{{ $project['description'] ?? 'N/A' }}</p>
                </div>

                <!-- Created At -->
                <div>
                    <p class="text-sm font-semibold text-gray-700">Created At:</p>
                    <p class="text-gray-600">{{ $project['created_at'] ?? 'N/A' }}</p>
                </div>

                <!-- Updated At -->
                <div>
                    <p class="text-sm font-semibold text-gray-700">Updated At:</p>
                    <p class="text-gray-600">{{ $project['updated_at'] ?? 'N/A' }}</p>
                </div>

                <!-- Starts On -->
                <div>
                    <p class="text-sm font-semibold text-gray-700">Starts On:</p>
                    <p class="text-gray-600">{{ $project['starts_on'] ?? 'N/A' }}</p>
                </div>

                <!-- Ends On -->
                <div>
                    <p class="text-sm font-semibold text-gray-700">Ends On:</p>
                    <p class="text-gray-600">{{ $project['ends_on'] ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6 text-center">
                <a href="{{ route('projects.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                    Back to Projects
                </a>
            </div>
        </div>
    </div>
</div>
@endsection