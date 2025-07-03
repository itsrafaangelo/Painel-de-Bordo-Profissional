<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\GithubController;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the dashboard with summary data.
     */
    public function index(): View
    {
        $user = auth()->user();

        // Tarefas para hoje
        $todayTasks = $user->tasks()
            ->where('due_date', today())
            ->where('status', '!=', 'Concluído')
            ->with('project')
            ->get();

        // Últimas anotações
        $recentNotes = $user->notes()
            ->latest()
            ->take(5)
            ->with('project')
            ->get();

        // Snippets recentes
        $recentSnippets = $user->snippets()
            ->latest()
            ->take(5)
            ->with('project')
            ->get();

        // Estatísticas gerais
        $stats = [
            'total_projects' => $user->projects()->count(),
            'active_projects' => $user->projects()->where('status', 'Ativo')->count(),
            'total_tasks' => $user->tasks()->count(),
            'pending_tasks' => $user->tasks()->where('status', '!=', 'Concluído')->count(),
            'total_notes' => $user->notes()->count(),
            'total_snippets' => $user->snippets()->count(),
        ];

        $recentActivities = [];

        // Widget GitHub
        $githubData = null;
        if ($user->github_token) {
            $githubData = GithubController::getGithubData($user);
        }

        return view('dashboard', compact('todayTasks', 'recentNotes', 'recentSnippets', 'stats', 'recentActivities', 'githubData'));
    }
}
