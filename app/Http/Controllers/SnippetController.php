<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SnippetController extends Controller
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
        $snippets = auth()->user()->snippets()->with('project')->latest()->get();
        return view('snippets.index', compact('snippets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $projects = auth()->user()->projects()->where('status', 'Ativo')->get();
        return view('snippets.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'language' => 'required|string|max:50',
            'code' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();

        $snippet = Snippet::create($validated);

        if ($snippet->project_id) {
            return redirect()->route('projects.show', $snippet->project_id)
                ->with('success', 'Snippet criado com sucesso!');
        }

        return redirect()->route('snippets.index')
            ->with('success', 'Snippet criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Snippet $snippet): View
    {
        $this->authorize('view', $snippet);
        
        return view('snippets.show', compact('snippet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Snippet $snippet): View
    {
        $this->authorize('update', $snippet);
        
        $projects = auth()->user()->projects()->where('status', 'Ativo')->get();
        return view('snippets.edit', compact('snippet', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Snippet $snippet): RedirectResponse
    {
        $this->authorize('update', $snippet);

        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'language' => 'required|string|max:50',
            'code' => 'required|string',
        ]);

        $snippet->update($validated);

        return redirect()->route('snippets.index')
            ->with('success', 'Snippet atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Snippet $snippet): RedirectResponse
    {
        $this->authorize('delete', $snippet);

        $snippet->delete();

        return redirect()->route('snippets.index')
            ->with('success', 'Snippet excluído com sucesso!');
    }
}
