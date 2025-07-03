<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NoteController extends Controller
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
        $notes = auth()->user()->notes()->with('project')->latest()->get();
        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $projects = auth()->user()->projects()->where('status', 'Ativo')->get();
        return view('notes.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();

        $note = Note::create($validated);

        if ($note->project_id) {
            return redirect()->route('projects.show', $note->project_id)
                ->with('success', 'Anotação criada com sucesso!');
        }

        return redirect()->route('notes.index')
            ->with('success', 'Anotação criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note): View
    {
        $this->authorize('view', $note);
        
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note): View
    {
        $this->authorize('update', $note);
        
        $projects = auth()->user()->projects()->where('status', 'Ativo')->get();
        return view('notes.edit', compact('note', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note): RedirectResponse
    {
        $this->authorize('update', $note);

        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update($validated);

        return redirect()->route('notes.index')
            ->with('success', 'Anotação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note): RedirectResponse
    {
        $this->authorize('delete', $note);

        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'Anotação excluída com sucesso!');
    }
}
