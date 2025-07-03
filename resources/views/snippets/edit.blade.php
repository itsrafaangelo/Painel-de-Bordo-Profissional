@extends('layouts.app')

@section('title', 'Editar Snippet')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Editar Snippet</h1>
        <p class="text-gray-600">Atualize o seu snippet de código.</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('snippets.update', $snippet) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $snippet->title) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">Projeto (opcional)</label>
                <select name="project_id" id="project_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Sem projeto</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', $snippet->project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('project_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="language" class="block text-sm font-medium text-gray-700 mb-2">Linguagem *</label>
                <select name="language" id="language" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Selecione a linguagem</option>
                    @foreach([
                        'php', 'javascript', 'python', 'java', 'csharp', 'cpp', 'c', 'ruby', 'go', 'rust', 'swift', 'kotlin', 'scala', 'html', 'css', 'sql', 'bash', 'powershell', 'yaml', 'json', 'xml', 'markdown', 'typescript', 'vue', 'react', 'angular', 'dart', 'r', 'matlab', 'perl', 'lua', 'haskell', 'elixir', 'clojure', 'erlang', 'fsharp', 'ocaml', 'nim', 'zig', 'crystal', 'julia', 'd', 'fortran', 'cobol', 'pascal', 'ada', 'lisp', 'prolog', 'smalltalk', 'forth', 'assembly', 'verilog', 'vhdl', 'tcl', 'awk', 'sed', 'groovy', 'j', 'apl', 'k', 'q', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'
                    ] as $lang)
                        <option value="{{ $lang }}" {{ old('language', $snippet->language) == $lang ? 'selected' : '' }}>{{ ucfirst($lang) }}</option>
                    @endforeach
                </select>
                @error('language')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Código *</label>
                <textarea name="code" id="code" rows="12"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm">{{ old('code', $snippet->code) }}</textarea>
                @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route('snippets.show', $snippet) }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection 