@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto" x-data="{ tab: 'visao' }">
    {{-- Cabeçalho do Projeto Moderno --}}
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl shadow p-6 mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-200 rounded-full flex items-center justify-center text-3xl text-blue-700 font-bold shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h3m4 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h7a2 2 0 002-2z" /></svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ $project->name }}</h1>
                <p class="text-gray-600 mb-2">{{ $project->description }}</p>
                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    {{ $project->status }}
                </span>
            </div>
        </div>
        <div class="flex flex-col gap-3 items-end">
            <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M12 7v10m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Editar Projeto
            </a>
            <div class="flex gap-2">
                <div class="bg-white rounded-lg px-3 py-1 text-xs text-gray-700 shadow">Tarefas: {{ $project->tasks->count() }}</div>
                <div class="bg-white rounded-lg px-3 py-1 text-xs text-gray-700 shadow">Concluídas: {{ $project->tasks->where('status', 'Concluído')->count() }}</div>
            </div>
            {{-- Barra de progresso --}}
            @php
                $total = $project->tasks->count();
                $done = $project->tasks->where('status', 'Concluído')->count();
                $progress = $total > 0 ? intval(($done / $total) * 100) : 0;
            @endphp
            <div class="w-40 bg-gray-200 rounded-full h-2.5 mt-2">
                <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
            </div>
            <span class="text-xs text-gray-500">Progresso: {{ $progress }}%</span>
        </div>
    </div>
    {{-- Fim do cabeçalho moderno --}}

    {{-- Abas de Navegação --}}
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-8" aria-label="Tabs">
            <button @click="tab = 'visao'" :class="tab === 'visao' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Visão Geral</button>
            <button @click="tab = 'tarefas'" :class="tab === 'tarefas' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Tarefas</button>
            <button @click="tab = 'anotacoes'" :class="tab === 'anotacoes' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Anotações</button>
            <button @click="tab = 'snippets'" :class="tab === 'snippets' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Snippets de Código</button>
        </nav>
    </div>

    {{-- Conteúdo das Abas --}}
    <div>
        {{-- Aba Visão Geral --}}
        <div x-show="tab === 'visao'">
            {{-- Estatísticas reais --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-700 mb-1">{{ $project->tasks->count() }}</div>
                    <div class="text-xs text-gray-600">Tarefas</div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-700 mb-1">{{ $project->notes->count() }}</div>
                    <div class="text-xs text-gray-600">Anotações</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-700 mb-1">{{ $project->snippets->count() }}</div>
                    <div class="text-xs text-gray-600">Snippets</div>
                </div>
            </div>
            {{-- Próximas tarefas reais --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Próximas Tarefas</h2>
                <ul class="divide-y divide-gray-200">
                    @foreach($project->tasks->where('status', '!=', 'Concluído')->sortBy('due_date')->take(5) as $task)
                        <li class="py-2 flex justify-between items-center">
                            <span>{{ $task->title }}</span>
                            <span class="text-xs text-gray-500">{{ $task->due_date ? $task->due_date->format('d/m/Y') : '-' }}</span>
                        </li>
                    @endforeach
                    @if($project->tasks->where('status', '!=', 'Concluído')->count() == 0)
                        <li class="py-2 text-gray-400">Nenhuma tarefa pendente.</li>
                    @endif
                </ul>
            </div>
            {{-- Últimas anotações reais --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Últimas Anotações</h2>
                <ul class="divide-y divide-gray-200">
                    @foreach($project->notes->take(3) as $note)
                        <li class="py-2">{{ $note->title }}</li>
                    @endforeach
                    @if($project->notes->count() == 0)
                        <li class="py-2 text-gray-400">Nenhuma anotação.</li>
                    @endif
                </ul>
            </div>
            {{-- Últimos snippets reais --}}
            <div>
                <h2 class="text-lg font-semibold mb-2">Últimos Snippets</h2>
                <ul class="divide-y divide-gray-200">
                    @foreach($project->snippets->take(3) as $snippet)
                        <li class="py-2">{{ $snippet->title }}</li>
                    @endforeach
                    @if($project->snippets->count() == 0)
                        <li class="py-2 text-gray-400">Nenhum snippet.</li>
                    @endif
                </ul>
            </div>
        </div>
        {{-- Aba Tarefas --}}
        <div x-show="tab === 'tarefas'">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Painel Kanban</h2>
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">+ Nova Tarefa</a>
            </div>
            {{-- Kanban Moderno --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                @php
                    $kanban = [
                        'A Fazer' => $project->tasks->where('status', 'A Fazer'),
                        'Concluído' => $project->tasks->where('status', 'Concluído'),
                    ];
                    $colors = [
                        'A Fazer' => 'bg-white border-blue-200',
                        'Concluído' => 'bg-green-50 border-green-200',
                    ];
                    $icons = [
                        'A Fazer' => '📝',
                        'Concluído' => '✅',
                    ];
                    $titles = [
                        'A Fazer' => 'Tarefas a Fazer',
                        'Concluído' => 'Tarefas Concluídas',
                    ];
                @endphp
                @foreach(['A Fazer', 'Concluído'] as $col)
                    <div class="rounded-2xl {{ $colors[$col] }} border p-6 min-h-[250px] flex flex-col shadow">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-2xl">{{ $icons[$col] }}</span>
                            <h3 class="font-bold text-gray-700 text-xl">{{ $titles[$col] }}</h3>
                            <span class="ml-2 px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">{{ $kanban[$col]->count() }}</span>
                        </div>
                        <div class="flex-1 space-y-4">
                            @forelse($kanban[$col] as $task)
                                <div class="bg-white rounded-lg shadow border-l-4 @if($col=='A Fazer')border-blue-400 @else border-green-400 @endif p-4 flex flex-col gap-1 hover:shadow-lg transition">
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-gray-900 text-base">{{ $task->title }}</span>
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs rounded bg-gray-100 text-gray-700 ml-2">
                                            @if($task->due_date)
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                {{ $task->due_date->format('d/m/Y') }}
                                            @else
                                                Sem prazo
                                            @endif
                                        </span>
                                    </div>
                                    @if($task->description)
                                        <span class="text-xs text-gray-500 mt-1">{{ Str::limit($task->description, 60) }}</span>
                                    @endif
                                    <div class="flex gap-2 mt-2">
                                        <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:bg-blue-50 p-2 rounded-full transition" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M12 7v10m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <span class="text-xs text-gray-400">Nenhuma tarefa</span>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- Aba Anotações --}}
        <div x-show="tab === 'anotacoes'">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Anotações do Projeto</h2>
                <a href="{{ route('notes.create', ['project_id' => $project->id]) }}" class="px-4 py-2 bg-yellow-400 text-gray-900 font-semibold rounded-lg shadow hover:bg-yellow-500 transition">+ Nova Anotação</a>
            </div>
            @if($project->notes->count() > 0)
                <div class="grid grid-cols-1 gap-4">
                    @foreach($project->notes as $note)
                        <div class="bg-white rounded-lg shadow border-l-4 border-yellow-400 p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <a href="{{ route('notes.show', $note) }}" class="font-semibold text-gray-900 hover:underline text-base">{{ $note->title }}</a>
                                    <span class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $note->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                                <div class="text-gray-600 text-sm truncate">{{ Str::limit(strip_tags($note->content), 80) }}</div>
                            </div>
                            <div class="flex gap-2 items-center mt-2 md:mt-0">
                                <a href="{{ route('notes.edit', $note) }}" title="Editar" class="text-blue-600 hover:bg-blue-50 p-2 rounded-full transition" aria-label="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M12 7v10m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </a>
                                <form id="delete-note-{{ $note->id }}" action="{{ route('notes.destroy', $note) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" title="Excluir" onclick="confirmDelete('delete-note-{{ $note->id }}')" class="text-red-600 hover:bg-red-50 p-2 rounded-full transition" aria-label="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-100 rounded-lg p-6 text-center text-gray-400">Nenhuma anotação encontrada.</div>
            @endif
        </div>
        {{-- Aba Snippets --}}
        <div x-show="tab === 'snippets'">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Snippets de Código</h2>
                <a href="{{ route('snippets.create', ['project_id' => $project->id]) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">+ Novo Snippet</a>
            </div>
            @if($project->snippets->count() > 0)
                <div class="grid grid-cols-1 gap-4">
                    @foreach($project->snippets as $snippet)
                        <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <a href="{{ route('snippets.show', $snippet) }}" class="font-semibold text-gray-800 hover:underline">{{ $snippet->title }}</a>
                                    <span class="text-xs text-gray-500">{{ $snippet->created_at->format('d/m/Y') }}</span>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-blue-100 text-blue-700">{{ $snippet->language }}</span>
                            </div>
                            <div class="flex gap-2 items-center">
                                <button type="button" onclick="copySnippet('{{ addslashes($snippet->code) }}')" class="text-green-600 hover:underline text-xs font-semibold">Copiar</button>
                                <a href="{{ route('snippets.edit', $snippet) }}" title="Editar" class="text-blue-600 hover:bg-blue-50 p-2 rounded-full transition" aria-label="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M12 7v10m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </a>
                                <form id="delete-snippet-{{ $snippet->id }}" action="{{ route('snippets.destroy', $snippet) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('delete-snippet-{{ $snippet->id }}')" class="text-red-600 hover:underline text-xs font-semibold">Excluir</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-100 rounded-lg p-6 text-center text-gray-400">Nenhum snippet encontrado.</div>
            @endif
        </div>
    </div>
</div>
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
    function copySnippet(code) {
        navigator.clipboard.writeText(code).then(function() {
            Swal.fire({
                icon: 'success',
                title: 'Copiado!',
                text: 'O código foi copiado para a área de transferência.',
                timer: 1200,
                showConfirmButton: false
            });
        });
    }
</script>
@endpush
@endsection 