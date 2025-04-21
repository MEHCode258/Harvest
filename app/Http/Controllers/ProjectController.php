<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Services\HarvestService;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Job::all(); // Fetch all projects from the database
        Log::info('Fetched Projects:', $projects->toArray()); // Log the fetched projects

        return view('pages.projects', compact('projects'));
    }

    public function show($id)
    {
        $project = Job::findOrFail($id); // Fetch project from the database
        Log::info('Fetched Project:', ['project' => $project]); // Log the fetched project
        return view('pages.project-details', compact('project'));
    }

    public function create()
    {
        return view('pages.create-project');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'code' => 'nullable|string',
            'notes' => 'nullable|string',
            'estimate_type' => 'nullable|string',
            'billable_rate_type' => 'nullable|string',
            'rate' => 'nullable|numeric',
            'fixed_fee' => 'nullable|numeric',
            'budget_type' => 'nullable|string',
            'budget_amount' => 'nullable|numeric',
            'budget_reset' => 'nullable|string',
            'alert_percentage' => 'nullable|numeric',
            'tasks' => 'nullable|array',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.rate' => 'required|numeric',
        ]);

        $project = Job::create($request->except('tasks')); // Save project to the database

        if ($request->has('tasks')) {
            foreach ($request->tasks as $task) {
                $project->tasks()->create($task);
            }
        }
        Log::info($project);
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function edit($id)
    {
        $project = Job::findOrFail($id); // Fetch project from the database
        return view('pages.edit-project', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'code' => 'nullable|string',
            'notes' => 'nullable|string',
            'estimate_type' => 'nullable|string',
            'billable_rate_type' => 'nullable|string',
            'rate' => 'nullable|numeric',
            'fixed_fee' => 'nullable|numeric',
            'budget_type' => 'nullable|string',
            'budget_amount' => 'nullable|numeric',
            'budget_reset' => 'nullable|string',
            'alert_percentage' => 'nullable|numeric',
        ]);

        $project = Job::findOrFail($id); // Fetch project from the database
        $project->update($request->all()); // Update project in the database

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $project = Job::findOrFail($id); // Fetch project from the database
        $project->delete(); // Delete project from the database

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}