@extends('layouts.app')

@section('title', 'Snippets')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Meus Snippets</h1>
        <a href="{{ route('snippets.create') }}" 
           class="inline-flex items-center px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Novo Snippet
        </a>
    </div>

    <!-- Snippets -->
    @if($snippets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($snippets as $snippet)
                <div class="bg-white rounded-2xl shadow-xl border border-purple-100 hover:shadow-2xl transition-transform hover:scale-105">
                    <div class="p-6 flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $snippet->title }}</h3>
                            @if($snippet->project)
                                <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded mb-2">{{ $snippet->project->name }}</span>
                            @endif
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded">{{ $snippet->language }}</span>
                        </div>
                        <div class="bg-gray-50 rounded p-3 mb-4 mt-2">
                            <pre class="text-xs text-gray-700 overflow-hidden" style="max-height: 100px;"><code>{{ Str::limit($snippet->code, 200) }}</code></pre>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="text-xs text-gray-500">Criado em {{ $snippet->created_at->format('d/m/Y H:i') }}</span>
                            <div class="flex space-x-2">
                                <a href="{{ route('snippets.show', $snippet) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Ver</a>
                                <a href="{{ route('snippets.edit', $snippet) }}" class="text-gray-600 hover:text-gray-800 text-sm font-semibold">Editar</a>
                                <form action="{{ route('snippets.destroy', $snippet) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold" onclick="return confirm('Tem certeza que deseja excluir este snippet?')">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-24">
            <svg class="h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
            </svg>
            <h3 class="mt-2 text-lg font-bold text-gray-900">Nenhum snippet encontrado</h3>
            <p class="mt-2 text-base text-gray-500">Comece criando seu primeiro snippet de código para facilitar seu dia a dia.</p>
        </div>
    @endif
</div>
@endsection 