@extends('layouts.app')

@section('title', 'Minhas Tarefas')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Minhas Tarefas</h1>
        <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nova Tarefa
        </a>
    </div>
    <div class="space-y-6">
        @foreach($groupedTasks as $projectId => $tasks)
            <div class="bg-white rounded-xl shadow p-4">
                <button type="button" class="w-full flex justify-between items-center text-left group" onclick="this.nextElementSibling.classList.toggle('hidden')">
                    <span class="font-bold text-lg text-gray-900">
                        @if($projectId === 'avulsas')
                            Tarefas Avulsas
                        @else
                            {{ optional($projects->firstWhere('id', $projectId))->name ?? 'Projeto desconhecido' }}
                        @endif
                    </span>
                    <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full">{{ $tasks->count() }}</span>
                </button>
                <div class="mt-4 space-y-6">
                    <!-- Tarefas a fazer/em andamento -->
                    <div>
                        <div class="font-semibold text-gray-700 mb-2">A Fazer / Em Andamento</div>
                        <div class="space-y-3 todo-list">
                        @forelse($tasks->where('status', '!=', 'Concluído') as $task)
                            <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3 border border-gray-200 task-card" data-task-id="{{ $task->id }}">
                                <input type="checkbox" class="accent-blue-600 task-checkbox" data-task-id="{{ $task->id }}" @if($task->status === 'Concluído') checked @endif>
                                <div class="flex-1">
                                    <span class="font-semibold text-gray-900">{{ $task->title }}</span>
                                    @if($task->due_date)
                                        <span class="ml-2 text-xs text-gray-500">{{ $task->due_date->format('d/m/Y') }}</span>
                                    @endif
                                    @if($task->description)
                                        <div class="text-xs text-gray-500">{{ Str::limit($task->description, 60) }}</div>
                                    @endif
                                </div>
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:bg-blue-50 p-2 rounded-full transition" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M12 7v10m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </a>
                            </div>
                        @empty
                            <div class="text-gray-400 text-sm">Nenhuma tarefa a fazer neste grupo.</div>
                        @endforelse
                        </div>
                    </div>
                    <!-- Tarefas concluídas -->
                    <div>
                        <div class="font-semibold text-green-700 mb-2">Concluídas</div>
                        <div class="space-y-3 done-list">
                        @forelse($tasks->where('status', 'Concluído') as $task)
                            <div class="flex items-center gap-3 bg-green-50 rounded-lg p-3 border border-green-200 task-card" data-task-id="{{ $task->id }}">
                                <input type="checkbox" class="accent-blue-600 task-checkbox" data-task-id="{{ $task->id }}" checked>
                                <div class="flex-1">
                                    <span class="font-semibold text-gray-900 line-through text-gray-400">{{ $task->title }}</span>
                                    @if($task->due_date)
                                        <span class="ml-2 text-xs text-gray-500 line-through">{{ $task->due_date->format('d/m/Y') }}</span>
                                    @endif
                                    @if($task->description)
                                        <div class="text-xs text-gray-500 line-through">{{ Str::limit($task->description, 60) }}</div>
                                    @endif
                                </div>
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:bg-blue-50 p-2 rounded-full transition" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M12 7v10m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </a>
                            </div>
                        @empty
                            <div class="text-gray-400 text-sm">Nenhuma tarefa concluída neste grupo.</div>
                        @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.task-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const taskId = this.dataset.taskId;
            const checked = this.checked;
            const status = checked ? 'Concluído' : 'A Fazer';
            const card = this.closest('.task-card');
            const projectCard = this.closest('.bg-white.rounded-xl.shadow.p-4');
            const todoList = projectCard.querySelector('.todo-list');
            const doneList = projectCard.querySelector('.done-list');
            fetch(`/tasks/${taskId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ status })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Erro ao atualizar o status da tarefa.');
                    this.checked = !checked;
                } else {
                    // Move o card para a lista correta
                    if (checked) {
                        // Para concluídas
                        card.querySelector('span.font-semibold').classList.add('line-through', 'text-gray-400');
                        card.querySelectorAll('span.text-xs, div.text-xs').forEach(el => el.classList.add('line-through'));
                        card.classList.remove('bg-gray-50', 'border-gray-200');
                        card.classList.add('bg-green-50', 'border-green-200');
                        doneList.appendChild(card);
                    } else {
                        // Para a fazer/em andamento
                        card.querySelector('span.font-semibold').classList.remove('line-through', 'text-gray-400');
                        card.querySelectorAll('span.text-xs, div.text-xs').forEach(el => el.classList.remove('line-through'));
                        card.classList.remove('bg-green-50', 'border-green-200');
                        card.classList.add('bg-gray-50', 'border-gray-200');
                        todoList.appendChild(card);
                    }
                }
            })
            .catch(() => {
                alert('Erro ao atualizar o status da tarefa.');
                this.checked = !checked;
            });
        });
    });
});
</script>
@endpush 