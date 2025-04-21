@extends('layouts.layout')

@section('title', 'Edit Proposal')

@section('content')
<h1 class="text-3xl font-bold mb-6">Edit Proposal</h1>

<div class="bg-white shadow-lg rounded p-6">
    <form action="{{ route('proposals.update', $proposal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $proposal->title) }}" class="border rounded p-2 w-full" required>
        </div>

        <!-- Content -->
        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-bold mb-2">Content:</label>
            <textarea name="content" id="content" rows="6" class="border rounded p-2 w-full" required>{{ old('content', $proposal->content) }}</textarea>
        </div>

        <!-- Estimate -->
        <div class="mb-4">
            <label for="estimate" class="block text-gray-700 font-bold mb-2">Estimate:</label>
            <input type="number" name="estimate" id="estimate" value="{{ old('estimate', $proposal->estimate) }}" class="border rounded p-2 w-full" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Save Changes
        </button>
    </form>
</div>
@endsection