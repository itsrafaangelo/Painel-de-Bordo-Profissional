@extends('layouts.app')

@section('title', 'Editar Tarefa')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Editar Tarefa</h1>
        <p class="text-gray-600">Atualize as informações da sua tarefa.</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}" required
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
                        <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('project_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select name="status" id="status" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="A Fazer" {{ old('status', $task->status) == 'A Fazer' ? 'selected' : '' }}>A Fazer</option>
                    <option value="Em Andamento" {{ old('status', $task->status) == 'Em Andamento' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="Concluído" {{ old('status', $task->status) == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Prazo (opcional)</label>
                <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('due_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route('tasks.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection 