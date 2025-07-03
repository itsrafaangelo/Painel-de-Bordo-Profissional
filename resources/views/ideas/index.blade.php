@extends('layouts.app')

@section('title', 'Caixa de Ideias')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Caixa de Ideias</h1>
    <ul class="space-y-3">
        @forelse($ideas as $idea)
            <li class="bg-white rounded-lg shadow p-4 border border-yellow-100 text-gray-800">{{ $idea->content }}</li>
        @empty
            <li class="text-gray-500">Nenhuma ideia cadastrada ainda.</li>
        @endforelse
    </ul>
    <div class="mt-6">
        {{ $ideas->links() }}
    </div>
</div>
@endsection 