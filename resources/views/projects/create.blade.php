@extends('layouts.app')

@section('title', 'Novo Projeto')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Novo Projeto</h1>
        <p class="text-gray-600">Crie um novo projeto para organizar suas tarefas, anotações e snippets.</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome do Projeto *
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: Sistema de Faturamento XPTO"
                           required>
                    @error('name')
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
                              placeholder="Descreva brevemente o objetivo deste projeto...">{{ old('description') }}</textarea>
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
                        <option value="Ativo" {{ old('status') === 'Ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="Arquivado" {{ old('status') === 'Arquivado' ? 'selected' : '' }}>Arquivado</option>
                        <option value="Concluído" {{ old('status') === 'Concluído' ? 'selected' : '' }}>Concluído</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('projects.index') }}" 
                       class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        Criar Projeto
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 