<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SnippetController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\GithubController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Projects
    Route::resource('projects', ProjectController::class);
    
    // Tasks (Kanban)
    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    
    // Notes
    Route::resource('notes', NoteController::class);
    
    // Snippets
    Route::resource('snippets', SnippetController::class);
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ideas
    Route::get('/ideas', [IdeaController::class, 'index'])->name('ideas.index');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');

    // GitHub
    Route::get('/github/login', [GithubController::class, 'redirectToProvider'])->name('github.login');
    Route::get('/github/callback', [GithubController::class, 'handleProviderCallback'])->name('github.callback');
});

require __DIR__.'/auth.php';
