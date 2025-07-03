@extends('layouts.app')

@section('title', 'Projetos')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <form method="GET" class="flex flex-1 gap-2">
            <input type="text" name="search" placeholder="Buscar por nome..." value="{{ request('search') }}"
                   class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-200" />
            <select name="status" class="px-4 py-2 border rounded-lg">
                <option value="">Todos os Status</option>
                <option value="Ativo" {{ request('status') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="Arquivado" {{ request('status') == 'Arquivado' ? 'selected' : '' }}>Arquivado</option>
                <option value="Concluído" {{ request('status') == 'Concluído' ? 'selected' : '' }}>Concluído</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">Filtrar</button>
        </form>
        <a href="{{ route('projects.create') }}" 
           class="inline-flex items-center px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Novo Projeto
        </a>
    </div>

    <!-- Projetos -->
    @if($projects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 hover:shadow-2xl transition-transform hover:scale-105 relative">
                    <div class="p-6 flex flex-col h-full justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-bold text-gray-900">
                                    <a href="{{ route('projects.show', $project) }}" class="hover:underline">{{ $project->name }}</a>
                                </h3>
                                <span class="px-3 py-1 text-xs font-medium rounded-full 
                                    @if($project->status === 'Ativo') bg-green-100 text-green-800
                                    @elseif($project->status === 'Arquivado') bg-gray-100 text-gray-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ $project->status }}
                                </span>
                            </div>
                            @if($project->description)
                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($project->description, 100) }}</p>
                            @endif
                            <div class="mb-4">
                                @php
                                    $totalTasks = $project->tasks_count;
                                    $completedTasks = $project->completed_tasks_count;
                                    $progress = $totalTasks > 0 ? intval(($completedTasks / $totalTasks) * 100) : 0;
                                @endphp
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500">Progresso</span>
                                    <span class="text-gray-700 font-semibold">{{ $progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                            <div class="flex gap-4 text-xs text-gray-600 mb-2">
                                <div class="flex items-center gap-1">
                                    <span class="text-lg">📋</span> {{ $completedTasks }}/{{ $totalTasks }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-lg">📝</span> {{ $project->notes_count }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-lg">&lt;/&gt;</span> {{ $project->snippets_count }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('projects.show', $project) }}" 
                                   class="flex items-center px-3 py-1 text-blue-600 hover:bg-blue-50 rounded transition text-sm font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver
                                </a>
                            </div>
                            <div x-data="{ open: false }" class="relative inline-block text-left">
                                <button type="button" @click="open = !open" class="inline-flex justify-center w-8 h-8 rounded-full hover:bg-gray-100 focus:outline-none" id="menu-button-{{ $project->id }}" aria-expanded="true" aria-haspopup="true">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v.01M12 12v.01M12 18v.01" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-36 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button-{{ $project->id }}">
                                    <a href="{{ route('projects.edit', $project) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Editar Detalhes</a>
                                    <form id="delete-project-{{ $project->id }}" action="{{ route('projects.destroy', $project) }}" method="POST" class="delete-project-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('delete-project-{{ $project->id }}')" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem">Excluir Projeto</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <h3 class="mt-4 text-lg font-bold text-gray-900">Nenhum projeto encontrado</h3>
            <p class="mt-2 text-base text-gray-500">Comece criando seu primeiro projeto para organizar sua produtividade.</p>
            <div class="mt-8">
                <a href="{{ route('projects.create') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Novo Projeto
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(formId) {
        Swal.fire({
            title: 'Tem certeza?',
            text: 'Esta ação não poderá ser desfeita!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endpush 