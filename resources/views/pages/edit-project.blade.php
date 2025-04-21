@extends('layouts.layout')

@section('title', 'Edit Project')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold text-center text-green-600 mb-8">Edit Project</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('projects.update', $project['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Project Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                    <input type="text" id="name" name="name" value="{{ $project['name'] }}" 
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" 
                           required>
                </div>
                
                <!-- Average Hours -->
                <div class="mb-4">
                    <label for="average_hours" class="block text-sm font-medium text-gray-700">Average Hours</label>
                    <input type="number" id="average_hours" name="average_hours" value="{{ $project['average_hours'] ?? '' }}" 
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" 
                           placeholder="Enter average hours">
                </div>


                <!-- Project Code -->
                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium text-gray-700">Project Code</label>
                    <input type="text" id="code" name="code" value="{{ $project['code'] ?? '' }}" 
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <!-- Start and End Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $project['start_date'] ?? '' }}" 
                               class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" 
                               required>
                    </div>
                    <div class="mb-4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $project['end_date'] ?? '' }}" 
                               class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" 
                               required>
                    </div>
                </div>

                <!-- Project Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="4" 
                              class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">{{ $project['description'] ?? '' }}</textarea>
                </div>

                <!-- Notes -->
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea id="notes" name="notes" rows="4" 
                              class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">{{ $project['notes'] ?? '' }}</textarea>
                </div>

                <!-- Estimate Type -->
                <div class="mb-4">
                    <label for="estimate_type" class="block text-sm font-medium text-gray-700">Estimate Type</label>
                    <select id="estimate_type" name="estimate_type" 
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        <option value="">Select Estimate Type</option>
                        <option value="time_and_material" {{ $project['estimate_type'] === 'time_and_material' ? 'selected' : '' }}>Time and Material</option>
                        <option value="fixed_fee" {{ $project['estimate_type'] === 'fixed_fee' ? 'selected' : '' }}>Fixed Fee</option>
                        <option value="non_billable" {{ $project['estimate_type'] === 'non_billable' ? 'selected' : '' }}>Non-Billable</option>
                    </select>
                </div>

                <!-- Hourly Rate -->
                <div class="mb-4">
                    <label for="rate" class="block text-sm font-medium text-gray-700">Hourly Rate</label>
                    <input type="number" id="rate" name="rate" value="{{ $project['rate'] ?? '' }}" 
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <!-- Fixed Fee -->
                <div class="mb-4">
                    <label for="fixed_fee" class="block text-sm font-medium text-gray-700">Fixed Fee</label>
                    <input type="number" id="fixed_fee" name="fixed_fee" value="{{ $project['fixed_fee'] ?? '' }}" 
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <!-- Budget Type -->
                <div class="mb-4">
                    <label for="budget_type" class="block text-sm font-medium text-gray-700">Budget Type</label>
                    <select id="budget_type" name="budget_type" 
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        <option value="">Select Budget Type</option>
                        <option value="no_budget" {{ $project['budget_type'] === 'no_budget' ? 'selected' : '' }}>No Budget</option>
                        <option value="total_project_fees" {{ $project['budget_type'] === 'total_project_fees' ? 'selected' : '' }}>Total Project Fees</option>
                        <option value="total_project_hours" {{ $project['budget_type'] === 'total_project_hours' ? 'selected' : '' }}>Total Project Hours</option>
                        <option value="hours_per_task" {{ $project['budget_type'] === 'hours_per_task' ? 'selected' : '' }}>Hours per Task</option>
                        <option value="hours_per_person" {{ $project['budget_type'] === 'hours_per_person' ? 'selected' : '' }}>Hours per Person</option>
                    </select>
                </div>

                <!-- Budget Amount -->
                <div class="mb-4">
                    <label for="budget_amount" class="block text-sm font-medium text-gray-700">Budget Amount</label>
                    <input type="number" id="budget_amount" name="budget_amount" value="{{ $project['budget_amount'] ?? '' }}" 
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <!-- Alert Percentage -->
                <div class="mb-4">
                    <label for="alert_percentage" class="block text-sm font-medium text-gray-700">Alert Percentage</label>
                    <input type="number" id="alert_percentage" name="alert_percentage" value="{{ $project['alert_percentage'] ?? '' }}" 
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="flex justify-between">
                    <button type="submit" 
                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                        Save Changes
                    </button>
                    <a href="{{ route('projects.index') }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection