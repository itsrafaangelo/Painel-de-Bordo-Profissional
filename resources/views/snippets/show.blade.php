@extends('layouts.app')

@section('title', $snippet->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $snippet->title }}</h1>
                <div class="flex items-center space-x-4 mt-2">
                    @if($snippet->project)
                        <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                            {{ $snippet->project->name }}
                        </span>
                    @endif
                    <span class="inline-block px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded">
                        {{ $snippet->language }}
                    </span>
                    <span class="text-sm text-gray-500">
                        Criado em {{ $snippet->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('snippets.edit', $snippet) }}" 
                   class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">
                    Editar
                </a>
                <form action="{{ route('snippets.destroy', $snippet) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 text-red-700 bg-red-100 hover:bg-red-200 rounded-lg text-sm"
                            onclick="return confirm('Tem certeza que deseja excluir este snippet?')">
                        Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <pre class="language-{{ $snippet->language }} rounded-lg overflow-x-auto"><code>{{ $snippet->code }}</code></pre>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('snippets.index') }}" 
           class="text-blue-600 hover:text-blue-800">
            ← Voltar para Snippets
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aplicar syntax highlighting
    Prism.highlightAll();
});
</script>
@endsection 