<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projects = auth()->user()->projects()
            ->withCount([
                'tasks',
                'notes',
                'snippets',
                'tasks as completed_tasks_count' => function ($query) {
                    $query->where('status', 'Concluído');
                },
            ])
            ->latest()
            ->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Ativo,Arquivado,Concluído',
        ]);

        $validated['user_id'] = auth()->id();

        Project::create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Projeto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): View
    {
        $this->authorize('view', $project);
        $project->load([
            'tasks' => function ($q) {
                $q->orderBy('due_date')->orderBy('status');
            },
            'notes' => function ($q) {
                $q->latest();
            },
            'snippets' => function ($q) {
                $q->latest();
            },
        ]);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project): View
    {
        $this->authorize('update', $project);
        
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Ativo,Arquivado,Concluído',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Projeto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Projeto excluído com sucesso!');
    }
}
