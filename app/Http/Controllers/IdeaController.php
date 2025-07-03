<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idea;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    public function index()
    {
        $ideas = Idea::where('user_id', Auth::id())->latest()->paginate(20);
        return view('ideas.index', compact('ideas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);
        Idea::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
        return redirect()->back()->with('success', 'Ideia adicionada!');
    }
}
