@extends('layouts.layout')

@section('title', 'Create Project')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-center">Create a New Project Template</h1>

<form action="{{ route('projects.store') }}" method="POST" class="space-y-8">
    @csrf

    <!-- Project Details Section -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Project Details</h2>

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Project Name:</label>
            <input type="text" name="name" id="name" class="border rounded p-2 w-full" placeholder="Enter project name" required>
        </div>

        <div class="mb-4">
            <label for="code" class="block text-gray-700 font-bold mb-2">Project Code:</label>
            <input type="text" name="code" id="code" class="border rounded p-2 w-full" placeholder="Enter project code (optional)">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="start_date" class="block text-gray-700 font-bold mb-2">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="border rounded p-2 w-full" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-gray-700 font-bold mb-2">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="border rounded p-2 w-full" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea name="description" id="description" rows="4" class="border rounded p-2 w-full" placeholder="Brief description of project"></textarea>
        </div>

        <div class="mb-4">
            <label for="notes" class="block text-gray-700 font-bold mb-2">Notes:</label>
            <textarea name="notes" id="notes" rows="4" class="border rounded p-2 w-full" placeholder="Add any additional notes about the project"></textarea>
        </div>

    </div>
    <!-- Tasks Section -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Tasks and Hourly Rates</h2>

        <div id="tasks-container">
            <div class="task-item mb-4">
                <label for="tasks[0][name]" class="block text-gray-700 font-bold mb-2">Task Name:</label>
                <input type="text" name="tasks[0][name]" class="border rounded p-2 w-full" placeholder="Enter task name" required>

                <label for="tasks[0][rate]" class="block text-gray-700 font-bold mb-2 mt-4">hours</label>
                <input type="number" name="tasks[0][rate]" class="border rounded p-2 w-full" placeholder="Enter hourly rate" required>
            </div>
        </div>

        <button type="button" id="add-task" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Add Task
        </button>
    </div>

    <!-- Estimate Section -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Estimate Details</h2>

        <div class="mb-4">
            <label for="estimate_type" class="block text-gray-700 font-bold mb-2">Estimate Type:</label>
            <select name="estimate_type" id="estimate_type" class="border rounded p-2 w-full" onchange="toggleEstimateFields()">
                <option value="">Select Estimate Type</option>
                <option value="time_and_material">Time and Material</option>
                <option value="fixed_fee">Fixed Fee</option>
                <option value="non_billable">Non-Billable</option>
            </select>
        </div>

        <!-- Time and Material Fields -->
        <div id="time_and_material_fields" class="hidden">
            <div class="mb-4">
                <label for="billable_rate_type" class="block text-gray-700 font-bold mb-2">Billable Rate Type:</label>
                <select name="billable_rate_type" id="billable_rate_type" class="border rounded p-2 w-full">
                    <option value="project_rate">Project Billable Rate</option>
                    <option value="person_rate">Person Billable Rate</option>
                    <option value="task_rate">Task Billable Rate</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="rate" class="block text-gray-700 font-bold mb-2">Hourly Rate:</label>
                <input type="number" name="rate" id="rate" class="border rounded p-2 w-full" placeholder="Enter hourly rate">
            </div>
        </div>

        <!-- Fixed Fee Field -->
        <div id="fixed_fee_field" class="hidden">
            <div class="mb-4">
                <label for="fixed_fee" class="block text-gray-700 font-bold mb-2">Fixed Fee:</label>
                <input type="number" name="fixed_fee" id="fixed_fee" class="border rounded p-2 w-full" placeholder="Enter fixed fee">
            </div>
        </div>

        <!-- Non-Billable Message -->
        <div id="non_billable_message" class="hidden">
            <p class="text-gray-600">This project is marked as non-billable. No billing information is required.</p>
        </div>
    </div>

    <!-- Budget Section -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Budget Details</h2>

        <div class="mb-4">
            <label for="budget_type" class="block text-gray-700 font-bold mb-2">Budget Type:</label>
            <select name="budget_type" id="budget_type" class="border rounded p-2 w-full" onchange="toggleBudgetFields()">
                <option value="">Select Budget Type</option>
                <option value="no_budget">No Budget</option>
                <option value="total_project_fees">Total Project Fees</option>
                <option value="total_project_hours">Total Project Hours</option>
                <option value="hours_per_task">Hours per Task</option>
                <option value="hours_per_person">Hours per Person</option>
            </select>
        </div>

        <div id="budget_options" class="hidden">
        <div class="mb-4">
            <label for="budget_amount" class="block text-gray-700 font-bold mb-2">Budget Amount:</label>
            <input type="number" name="budget_amount" id="budget_amount" class="border rounded p-2 w-full" placeholder="Enter budget amount">
        </div>
            <div class="mb-4">
                <label for="budget_reset" class="block text-gray-700 font-bold mb-2">Budget Reset:</label>
                <select name="budget_reset" id="budget_reset" class="border rounded p-2 w-full">
                    <option value="no_reset">No Reset</option>
                    <option value="monthly_reset">Reset Every Month</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="alert_percentage" class="block text-gray-700 font-bold mb-2">Alert Percentage:</label>
                <input type="number" name="alert_percentage" id="alert_percentage" class="border rounded p-2 w-full" placeholder="Enter percentage (e.g., 80)">
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="text-center">
        <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">
            Create Template
        </button>
    </div>
</form>

<script>
    function toggleEstimateFields() {
        const estimateType = document.getElementById('estimate_type').value;
        const timeAndMaterialFields = document.getElementById('time_and_material_fields');
        const fixedFeeField = document.getElementById('fixed_fee_field');
        const nonBillableMessage = document.getElementById('non_billable_message');

        if (estimateType === 'time_and_material') {
            timeAndMaterialFields.classList.remove('hidden');
            fixedFeeField.classList.add('hidden');
            nonBillableMessage.classList.add('hidden');
        } else if (estimateType === 'fixed_fee') {
            fixedFeeField.classList.remove('hidden');
            timeAndMaterialFields.classList.add('hidden');
            nonBillableMessage.classList.add('hidden');
        } else if (estimateType === 'non_billable') {
            nonBillableMessage.classList.remove('hidden');
            timeAndMaterialFields.classList.add('hidden');
            fixedFeeField.classList.add('hidden');
        } else {
            timeAndMaterialFields.classList.add('hidden');
            fixedFeeField.classList.add('hidden');
            nonBillableMessage.classList.add('hidden');
        }
    }

    function toggleBudgetFields() {
        const budgetType = document.getElementById('budget_type').value;
        const budgetOptions = document.getElementById('budget_options');

        if (budgetType === 'no_budget') {
            budgetOptions.classList.add('hidden');
        } else {
            budgetOptions.classList.remove('hidden');
        }
    }

    document.getElementById('add-task').addEventListener('click', function () {
        const container = document.getElementById('tasks-container');
        const taskCount = container.children.length;

        const taskItem = document.createElement('div');
        taskItem.classList.add('task-item', 'mb-4');

        taskItem.innerHTML = `
            <label for="tasks[${taskCount}][name]" class="block text-gray-700 font-bold mb-2">Task Name:</label>
            <input type="text" name="tasks[${taskCount}][name]" class="border rounded p-2 w-full" placeholder="Enter task name" required>

            <label for="tasks[${taskCount}][rate]" class="block text-gray-700 font-bold mb-2 mt-4">Hourly Rate:</label>
            <input type="number" name="tasks[${taskCount}][rate]" class="border rounded p-2 w-full" placeholder="Enter hourly rate" required>

            <button type="button" class="remove-task bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mt-4">
                Remove Task
            </button>
        `;

        container.appendChild(taskItem);

        // Add event listener to remove button
        taskItem.querySelector('.remove-task').addEventListener('click', function () {
            taskItem.remove();
        });
    });

</script>
@endsection