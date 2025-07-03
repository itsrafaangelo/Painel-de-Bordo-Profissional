@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Coluna Principal -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Widget Saudação e Foco do Dia -->
        <div class="bg-white rounded-2xl shadow p-6 flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">@php
                    $hora = now()->format('H');
                    if ($hora < 12) echo 'Bom dia';
                    elseif ($hora < 18) echo 'Boa tarde';
                    else echo 'Boa noite';
                @endphp, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-500 text-lg">Hoje é {{ now()->format('d/m/Y') }}</p>
            </div>
            <div class="mt-4 md:mt-0 md:ml-8 w-full md:w-1/2">
                <form method="POST" action="#" id="focus-form">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-1">Qual é o seu foco principal para hoje?</label>
                    <input type="text" name="focus" id="focus" value="{{ $focus ?? '' }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Digite seu foco do dia...">
                </form>
            </div>
        </div>

        <!-- Widget Minhas Tarefas Para Hoje e Atrasadas -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Suas Tarefas Para Hoje e Atrasadas</h3>
            <ul class="divide-y divide-gray-100">
                @forelse($todayTasks as $task)
                    <li class="flex items-center justify-between py-3">
                        <div class="flex items-center">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-green-600" data-task-id="{{ $task->id }}" @if($task->status === 'Concluído') checked disabled @endif>
                            <a href="{{ route('tasks.show', $task) }}" class="ml-3 font-medium text-gray-900 hover:underline">{{ $task->title }}</a>
                            @if($task->project)
                                <span class="ml-2 px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">{{ $task->project->name }}</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500">{{ $task->due_date->format('d/m/Y') }}</span>
                    </li>
                @empty
                    <li class="text-gray-500 py-4 text-center">Nenhuma tarefa para hoje ou atrasada!</li>
                @endforelse
            </ul>
        </div>

        <!-- Widget Progresso da Semana -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tarefas Concluídas nos Últimos 7 Dias</h3>
            <canvas id="weekProgressChart" height="120"></canvas>
        </div>

        <!-- Widget Atividade Recente -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Atividade Recente nos Projetos</h3>
            <ul class="divide-y divide-gray-100">
                @forelse($recentActivities as $activity)
                    <li class="py-3 text-gray-700">{{ $activity }}</li>
                @empty
                    <li class="text-gray-500 py-4 text-center">Nenhuma atividade recente!</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Coluna Lateral -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Widget Acesso Rápido -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Acesso Rápido</h3>
            <div class="flex flex-col space-y-3 mb-4">
                <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold shadow hover:bg-blue-700 transition">
                    + Nova Tarefa
                </a>
                <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg font-semibold shadow hover:bg-green-700 transition">
                    + Nova Anotação
                </a>
                <a href="{{ route('snippets.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold shadow hover:bg-purple-700 transition">
                    + Salvar Snippet
                </a>
            </div>
            <h4 class="text-sm font-semibold text-gray-600 mb-2">Acessados Recentemente</h4>
            <ul class="space-y-2">
                @foreach($recentNotes as $note)
                    <li><a href="{{ route('notes.show', $note) }}" class="text-blue-600 hover:underline">{{ $note->title }}</a></li>
                @endforeach
                @foreach($recentSnippets as $snippet)
                    <li><a href="{{ route('snippets.show', $snippet) }}" class="text-purple-600 hover:underline">{{ $snippet->title }}</a></li>
                @endforeach
                @if($recentNotes->isEmpty() && $recentSnippets->isEmpty())
                    <li class="text-gray-500">Nenhum acesso recente.</li>
                @endif
            </ul>
        </div>
        <!-- Widget Caixa de Ideias -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h.01"></path>
                </svg>
                Caixa de Ideias
            </h3>
            <form action="{{ route('ideas.store') }}" method="POST" class="flex mb-4">
                @csrf
                <input name="content" type="text" placeholder="Digite uma ideia..." class="flex-1 px-3 py-2 border rounded-l focus:outline-none" required>
                <button class="px-4 py-2 bg-yellow-500 text-white rounded-r hover:bg-yellow-600">Adicionar</button>
            </form>
            <ul class="space-y-2 text-sm">
                @foreach(\App\Models\Idea::where('user_id', Auth::id())->latest()->take(4)->get() as $idea)
                    <li class="text-gray-700">{{ $idea->content }}</li>
                @endforeach
            </ul>
            <a href="{{ route('ideas.index') }}" class="block mt-4 text-yellow-600 hover:underline text-sm">Ver todas as ideias</a>
        </div>
        <!-- Widget Atividade do GitHub (com dados reais) -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 17v1a3 3 0 01-6 0v-1"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v4m0 0a4 4 0 014 4v1a4 4 0 01-8 0V11a4 4 0 014-4z"></path>
                </svg>
                Atividade do GitHub
            </h3>
            @if(Auth::user()->github_token)
                @if($githubData)
                    <ul class="space-y-2 text-sm mb-2">
                        <li>
                            <span class="font-semibold">Notificações não lidas:</span>
                            <span class="text-blue-600">{{ $githubData['notifications'] }}</span>
                        </li>
                        <li>
                            <span class="font-semibold">PRs para revisar:</span>
                            <span class="text-blue-600">{{ $githubData['review_requests'] }}</span>
                        </li>
                        <li>
                            <span class="font-semibold">Últimos builds:</span>
                            <ul class="ml-2">
                                @forelse($githubData['last_builds'] as $build)
                                    <li>
                                        <a href="{{ $build['url'] }}" target="_blank" class="text-blue-700 hover:underline">{{ $build['repo'] }}</a>:
                                        <span class="font-semibold {{ $build['status'] === 'success' ? 'text-green-600' : ($build['status'] === 'failure' ? 'text-red-600' : 'text-gray-600') }}">{{ $build['status'] }}</span>
                                    </li>
                                @empty
                                    <li class="text-gray-500">Nenhum build recente.</li>
                                @endforelse
                            </ul>
                        </li>
                    </ul>
                @else
                    <div class="text-gray-500 text-sm mb-2">Não foi possível buscar dados do GitHub.</div>
                @endif
                <div class="text-green-600 font-semibold mb-2">GitHub conectado!</div>
            @else
                <a href="{{ route('github.login') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900 transition">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.387.6.113.82-.263.82-.582 0-.288-.012-1.243-.018-2.25-3.338.726-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.745.083-.729.083-.729 1.205.085 1.84 1.237 1.84 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.305.762-1.605-2.665-.304-5.466-1.332-5.466-5.93 0-1.31.468-2.38 1.236-3.22-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.96-.267 1.98-.399 3-.404 1.02.005 2.04.137 3 .404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.12 3.176.77.84 1.235 1.91 1.235 3.22 0 4.61-2.803 5.624-5.475 5.921.43.372.823 1.102.823 2.222 0 1.606-.015 2.898-.015 3.293 0 .322.216.699.825.58C20.565 21.796 24 17.297 24 12c0-6.63-5.37-12-12-12z"/></svg>
                    Conectar com GitHub
                </a>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js para o gráfico de progresso semanal -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('weekProgressChart').getContext('2d');
    const weekProgressChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($weekLabels ?? []),
            datasets: [{
                label: 'Tarefas Concluídas',
                data: @json($weekData ?? []),
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderRadius: 8,
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endsection
