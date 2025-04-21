@extends('layouts.layout')

@section('title', 'Home')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <header class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-green-600">Welcome to Seedling</h1>
            <p class="mt-4 text-lg text-gray-700">
                Your all-in-one solution for creating, managing, and sharing professional proposals.
            </p>
        </header>

        <!-- Features Section -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h2 class="text-2xl font-bold text-gray-800">Create Proposals</h2>
                <p class="mt-4 text-gray-600">
                    Quickly generate detailed proposals for your clients with ease.
                </p>
                <a href="{{ route('proposals.create') }}" class="mt-6 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Get Started
                </a>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h2 class="text-2xl font-bold text-gray-800">Manage Clients</h2>
                <p class="mt-4 text-gray-600">
                    Keep track of your clients and their details in one place.
                </p>
                <a href="{{ route('clients.index') }}" class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    View Clients
                </a>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h2 class="text-2xl font-bold text-gray-800">Track Projects</h2>
                <p class="mt-4 text-gray-600">
                    Stay organized by managing all your projects efficiently.
                </p>
                <a href="{{ route('projects.index') }}" class="mt-6 inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Explore Projects
                </a>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="mt-12 text-center">
            <h2 class="text-3xl font-bold text-gray-800">Start Building Your Proposals Today</h2>
            <p class="mt-4 text-gray-600">
                Seedling makes it easy to create professional proposals, manage clients, and track projects—all in one place.
            </p>
            <a href="{{ route('proposals.create') }}" class="mt-6 inline-block bg-green-500 text-white px-6 py-3 rounded-lg text-lg hover:bg-green-600">
                Create Your First Proposal
            </a>
        </section>
    </div>
</div>
@endsection