<?php
// filepath: c:\Users\Miles\Desktop\Projects\Seedling\app\Http\Controllers\ProposalController.php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Job;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class ProposalController extends Controller
{
     // List all proposals
     public function index()
     {
        $proposals = Proposal::with('client')->get(); // Ensure 'client' relationship is loaded
         return view('pages.proposals', compact('proposals'));

     }
    // Show the create form for a new proposal
    public function create()
    {
    
        $dbClients = Client::all();

        // Fetch clients from Harvest
        try {
            $harvestClients = app('App\Services\HarvestService')->getClients();
            $harvestClients = collect($harvestClients['clients'] ?? [])->map(function ($client) {
                return [
                    'id' => null, // Harvest clients don't have a database ID
                    'name' => $client['name'] ?? 'N/A',
                    'email' => $client['email'] ?? 'N/A',
                    'phone' => $client['phone'] ?? 'N/A',
                    'add1' => $client['address']['line_1'] ?? 'N/A',
                    'add2' => $client['address']['line_2'] ?? null,
                    'city' => $client['address']['city'] ?? 'N/A',
                    'state' => $client['address']['state'] ?? 'N/A',
                    'zip' => $client['address']['postal_code'] ?? 'N/A',
                    'website' => $client['website'] ?? null,
                ];
            });
        } catch (\Exception $e) {
            $harvestClients = collect(); // Fallback to an empty collection if Harvest API fails
        }
    
        // Merge database clients and Harvest clients
        $clients = $dbClients->toBase()->merge($harvestClients);
    
        // Fetch projects from the database
        $projects = Job::all();
    
        return view('pages.create', compact('clients', 'projects'));
    }

    // Store the new proposal in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'client_id' => 'nullable|exists:clients,id',
            'projects' => 'required|array', // Validate that projects are an array
            'projects.*' => 'exists:projects,id', // Validate that each project exists
            'content' => 'required|string',
        ]);
    
        // Debugging: Log the request data
        Log::info('Request Data:', $request->all());
    
        // Calculate the total estimate from the selected projects
        $totalEstimate = Project::whereIn('id', $request->projects)->sum('estimate');
    
        // Debugging: Log the total estimate
        Log::info('Total Estimate:', ['totalEstimate' => $totalEstimate]);
    
        // Create the proposal
        $proposal = Proposal::create([
            'title' => $request->title,
            'client_id' => $request->client_id,
            'estimate' => $totalEstimate,
            'content' => $request->content,
        ]);
    
        // Attach the selected projects
        $proposal->projects()->attach($request->projects);
    
        return redirect()->route('proposals.index')->with('success', 'Proposal created successfully!');
    }


    public function generateProjectClientPdf(Request $request)
{
    try {
        // Validate the request
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'required|exists:jobs,id',
        ]);

        // Fetch the client and project data
        $client = Client::findOrFail($request->input('client_id'));
        $project = Job::findOrFail($request->input('project_id'));

        // Fetch the proposal
        $proposal = Proposal::where('client_id', $request->input('client_id'))
            ->where('job_id', $request->input('project_id'))
            ->first();

        if (!$proposal) {
            Log::error('Proposal not found for client_id and project_id', [
                'client_id' => $request->input('client_id'),
                'project_id' => $request->input('project_id'),
            ]);
            return redirect()->back()->with('error', 'Proposal not found.');
        }

        // Set notes from the proposal content
        $notes = $proposal->content ?? 'No additional notes provided.';
        Log::info('Notes:', ['notes' => $notes]); // Debug log for notes

        // Debug logs for other data
        Log::info('Client:', ['client' => $client]);
        Log::info('Project:', ['project' => $project]);
        Log::info('Proposal:', ['proposal' => $proposal]);

        // Prepare data for the PDF
        $data = [
            'date' => now()->format('F j, Y'),
            'client' => $client,
            'project' => $project,
            'notes' => $notes, // Pass notes to the view
        ];

        // Generate the PDF
        $pdf = Pdf::loadView('pages.pdf', $data);

        // Stream the PDF to the browser
        return $pdf->stream('Project_Client_Information.pdf');
    } catch (\Exception $e) {
        Log::error('Error generating PDF:', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Failed to generate PDF.');
    }
}
// Show the edit form for an existing proposal
public function edit(Proposal $proposal)
{
     // Fetch clients from the database
     $dbClients = Client::all();

     // Fetch clients from Harvest
     try {
         $harvestClients = app('App\Services\HarvestService')->getClients();
         $harvestClients = collect($harvestClients['clients'] ?? [])->map(function ($client) {
             return [
                 'id' => null, // Harvest clients don't have a database ID
                 'name' => $client['name'] ?? 'N/A',
                 'email' => $client['email'] ?? 'N/A',
                 'phone' => $client['phone'] ?? 'N/A',
                 'add1' => $client['address']['line_1'] ?? 'N/A',
                 'add2' => $client['address']['line_2'] ?? null,
                 'city' => $client['address']['city'] ?? 'N/A',
                 'state' => $client['address']['state'] ?? 'N/A',
                 'zip' => $client['address']['postal_code'] ?? 'N/A',
                 'website' => $client['website'] ?? null,
             ];
         });
     } catch (\Exception $e) {
         $harvestClients = collect(); // Fallback to an empty collection if Harvest API fails
     }
 
     // Merge database clients and Harvest clients
     $clients = $dbClients->toBase()->merge($harvestClients);
 
     // Fetch projects from the database
     $projects = Job::all();
 
     // Use the correct view name
     return view('pages.edit-proposal', compact('proposal', 'clients', 'projects'));
}

// Update the existing proposal in the database
public function update(Request $request, Proposal $proposal)
{
    // Validate the updated proposal data
    $request->validate([
        'title' => 'required|string|max:255',
        'client_id' => 'nullable|exists:clients,id',
        'job_id' => 'nullable|exists:projects,id',
        'estimate' => 'required|numeric',
        'content' => 'required|string',
    ]);

    // Update the proposal
    $proposal->update($request->only(['title', 'estimate', 'content']));

    // Fetch the selected project
    $project = Job::find($request->job_id);

    // Regenerate the PDF
    $pdf = Pdf::loadView('pages.pdf', [
        'proposal' => $proposal,
        'project' => $project, // Pass the project to the PDF view
    ]);

    $pdfPath = 'proposals/' . $proposal->id . '.pdf';
    \Storage::put('public/' . $pdfPath, $pdf->output());

    // Update the proposal with the new PDF path
    $proposal->update(['pdf_path' => $pdfPath]);

    return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully!');
}
   

    public function destroy(Proposal $proposal)
    {
        // Delete the associated PDF file from storage
        if ($proposal->pdf_path && \Storage::exists('public/' . $proposal->pdf_path)) {
            \Storage::delete('public/' . $proposal->pdf_path);
        }

        // Delete the proposal from the database
        $proposal->delete();

        return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully!');
    }

    public function previewPdf(Proposal $proposal)
{
    try {
        // Fetch the client and project data
        $client = $proposal->client; // Assuming a relationship exists
        $project = $proposal->job;   // Assuming a relationship exists

        // Prepare data for the PDF
        $data = [
            'date' => now()->format('F j, Y'),
            'client' => $client,
            'project' => $project,
        ];

        // Generate the PDF
        $pdf = Pdf::loadView('pages.pdf', $data);

        // Stream the PDF to the browser
        return $pdf->stream('Proposal_Preview.pdf');
    } catch (\Exception $e) {
        Log::error('Error previewing PDF:', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Failed to preview PDF.');
    }
}
    
}