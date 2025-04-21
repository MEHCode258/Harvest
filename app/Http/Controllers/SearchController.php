<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\Project;
use App\Models\Job;
use App\Models\Client;
use App\Models\Task;
use Illuminate\Support\Facades\Log;


class SearchController extends Controller
{
    public function searchProjects(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }
    
        $projects = Job::where('name', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name']); // Ensure 'name' is included in the response
    
        return response()->json($projects);
        
    }

    public function autocomplete(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type');
    
        Log::info('Autocomplete Query:', ['query' => $query, 'type' => $type]);
    
        if (empty($query)) {
            return response()->json([]);
        }
    
        if ($type === 'projects') {
            $projects = Job::where('name', 'LIKE', "%{$query}%")
                ->limit(10)
                ->get(['id', 'name']);
    
            Log::info('Autocomplete Results:', $projects->toArray());
    
            return response()->json($projects);
        }
    
        if ($type === 'proposals') {
            $proposals = Proposal::where('title', 'LIKE', "%{$query}%")
                ->limit(10)
                ->get(['id', 'title']);
    
            Log::info('Autocomplete Results:', $proposals->toArray());
    
            return response()->json($proposals);
        }
    
        return response()->json([]);
  }

public function searchProposals(Request $request)
{
    if ($request->has('query')) {
        $query = Proposal::query();
        $query->where('title', 'like', '%' . $request->query('query') . '%')
              ->orWhereHas('projects', function ($q) use ($request) {
                  $q->where('name', 'like', '%' . $request->query('query') . '%');
              });
    }

    $proposals = $query->get();

    return response()->json($proposals);
}

}
