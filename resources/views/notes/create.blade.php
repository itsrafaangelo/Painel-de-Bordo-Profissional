@extends('layouts.app')

@section('title', 'Nova Anotação')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Nova Anotação</h1>
        <p class="text-gray-600">Crie uma nova anotação com formatação rica.</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título da Anotação *
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: Ata da reunião de planejamento"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Projeto (opcional)
                    </label>
                    @php $selectedProject = request('project_id') ?? old('project_id'); @endphp
                    @if(request('project_id'))
                        <input type="hidden" name="project_id" value="{{ request('project_id') }}">
                        <div class="px-3 py-2 bg-gray-100 rounded text-gray-700">{{ $projects->firstWhere('id', request('project_id'))->name ?? 'Projeto selecionado' }}</div>
                    @else
                        <select name="project_id" 
                                id="project_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Sem projeto</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $selectedProject == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                    @error('project_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Conteúdo *
                    </label>
                    <textarea name="content" 
                              id="content" 
                              rows="12"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Digite o conteúdo da sua anotação...">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('notes.index') }}" 
                       class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        Criar Anotação
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar TinyMCE
    tinymce.init({
        selector: '#content',
        height: 400,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | \
                alignleft aligncenter alignright alignjustify | \
                bullist numlist outdent indent | removeformat | help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
        language: 'pt_BR',
        menubar: false,
        branding: false,
        promotion: false
    });
});
</script>
@endsection 