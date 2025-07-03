@extends('layouts.app')

@section('title', 'Anotações')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Minhas Anotações</h1>
        <a href="{{ route('notes.create') }}" 
           class="inline-flex items-center px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nova Anotação
        </a>
    </div>

    <!-- Anotações -->
    @if($notes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($notes as $note)
                <div class="bg-white rounded-2xl shadow-xl border border-green-100 hover:shadow-2xl transition-transform hover:scale-105">
                    <div class="p-6 flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $note->title }}</h3>
                            @if($note->project)
                                <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded mb-2">{{ $note->project->name }}</span>
                            @endif
                        </div>
                        <div class="prose prose-sm max-w-none mt-2 mb-4">
                            {!! Str::limit(strip_tags($note->content), 150) !!}
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="text-xs text-gray-500">Criada em {{ $note->created_at->format('d/m/Y H:i') }}</span>
                            <div class="flex space-x-2">
                                <a href="{{ route('notes.show', $note) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Ver</a>
                                <a href="{{ route('notes.edit', $note) }}" class="text-gray-600 hover:text-gray-800 text-sm font-semibold">Editar</a>
                                <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold" onclick="return confirm('Tem certeza que deseja excluir esta anotação?')">Excluir</button>
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <h3 class="mt-2 text-lg font-bold text-gray-900">Nenhuma anotação encontrada</h3>
            <p class="mt-2 text-base text-gray-500">Comece criando sua primeira anotação para registrar ideias e informações importantes.</p>
        </div>
    @endif
</div>
@endsection 