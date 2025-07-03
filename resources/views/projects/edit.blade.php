@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Editar Projeto</h1>
        <p class="text-gray-600">Atualize as informações do seu projeto.</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $project->name) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select id="status" name="status" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="Ativo" {{ old('status', $project->status) == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="Arquivado" {{ old('status', $project->status) == 'Arquivado' ? 'selected' : '' }}>Arquivado</option>
                    <option value="Concluído" {{ old('status', $project->status) == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route('projects.show', $project) }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection 