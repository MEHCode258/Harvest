use App\Models\Job; // Replace with the model you want to search
use Illuminate\Support\Facades\DB;

<?php


// Example search functionality
$query = 'search term'; // Replace with your search term

// Perform a search query
\App\Models\Job::whereRaw('LOWER(name) LIKE ?', ['%business%'])->get();
return $results;