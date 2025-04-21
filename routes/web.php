<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Page routes
Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/create', 'pages.create')->name('create');
Route::view('/clients', 'pages.clients')->name('clients');
Route::view('/pdf', 'pages.pdf')->name('pdf');

// Project routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

// Proposal routes
Route::get('/proposals/create', [ProposalController::class, 'create'])->name('proposals.create');
Route::get('/proposals', [ProposalController::class, 'index'])->name('proposals.index');
Route::post('/proposals', [ProposalController::class, 'store'])->name('proposals.store');
Route::delete('/proposals/{proposal}', [ProposalController::class, 'destroy'])->name('proposals.destroy');
Route::get('/proposals/{proposal}/edit', [ProposalController::class, 'edit'])->name('proposals.edit');
Route::put('/proposals/{proposal}', [ProposalController::class, 'update'])->name('proposals.update');
Route::post('/proposals/generate-pdf', [ProposalController::class, 'generateProjectClientPdf'])->name('proposals.generate-pdf');
Route::get('/proposals/{proposal}/preview-pdf', [ProposalController::class, 'previewPdf'])->name('proposals.preview-pdf');
Route::get('/harvest/clients/{client}/edit', [HarvestClientController::class, 'edit'])->name('harvest.clients.edit');
// Search routes
Route::get('/projects/search', [SearchController::class, 'searchProjects'])->name('projects.search');
Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');

// Client routes
Route::resource('clients', ClientController::class);

// Fallback route
Route::fallback(function () {
    return response()->json(['error' => 'Route not found'], 404);
});