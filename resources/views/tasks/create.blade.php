@extends('layouts.app')

@section('title', 'Nova Tarefa')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Nova Tarefa</h1>
        <p class="text-gray-600">Crie uma nova tarefa para organizar seu trabalho.</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título da Tarefa *
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: Implementar autenticação"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @php $selectedProject = request('project_id') ?? old('project_id'); @endphp
                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Projeto (opcional)
                    </label>
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
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Descrição
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Descreva os detalhes da tarefa...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status *
                    </label>
                    <select name="status" 
                            id="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="A Fazer" {{ old('status') === 'A Fazer' ? 'selected' : '' }}>A Fazer</option>
                        <option value="Em Andamento" {{ old('status') === 'Em Andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="Concluído" {{ old('status') === 'Concluído' ? 'selected' : '' }}>Concluído</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Prazo (opcional)
                    </label>
                    <input type="date" 
                           name="due_date" 
                           id="due_date" 
                           value="{{ old('due_date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('tasks.index') }}" 
                       class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        Criar Tarefa
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 