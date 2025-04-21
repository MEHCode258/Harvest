<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;


class JobController extends Controller
{
    public function index()
    {
        // Fetch jobs from the jobdb table
        $jobs = Job::all();
        dd($jobs);
        // Return the jobs to a view (assuming you have a view named 'jobs.index')
        return view('pages.projects', compact('jobs'));
    }
}