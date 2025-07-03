<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource (Kanban Board).
     */
    public function index(): View
    {
        $tasks = auth()->user()->tasks()->with('project')->orderBy('due_date')->get();
        $projects = auth()->user()->projects()->where('status', 'Ativo')->get();
        // Agrupar tarefas por projeto_id (null = avulsas)
        $groupedTasks = $tasks->groupBy(function($task) {
            return $task->project_id ?? 'avulsas';
        });
        return view('tasks.index', compact('groupedTasks', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $projects = auth()->user()->projects()->where('status', 'Ativo')->get();
        return view('tasks.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:A Fazer,Em Andamento,Concluído',
            'due_date' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id();

        $task = Task::create($validated);

        if ($task->project_id) {
            return redirect()->route('projects.show', $task->project_id)
                ->with('success', 'Tarefa criada com sucesso!');
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): View
    {
        $this->authorize('view', $task);
        
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        $this->authorize('update', $task);
        
        $projects = auth()->user()->projects()->where('status', 'Ativo')->get();
        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:A Fazer,Em Andamento,Concluído',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa excluída com sucesso!');
    }

    /**
     * Update task status via AJAX (for Kanban drag & drop).
     */
    public function updateStatus(Request $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'status' => 'required|string|in:A Fazer,Em Andamento,Concluído',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status atualizado com sucesso!',
            'task' => $task->load('project')
        ]);
    }
}
