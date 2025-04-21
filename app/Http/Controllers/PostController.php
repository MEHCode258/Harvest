<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Log the query for debugging
        \Log::info("Search query: {$query}");
    
        // Simplified query to check if search works
        $results = DB::table('jobdb')
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['title', 'content']); // Return both title and content
    
        return response()->json($results);
    }
}