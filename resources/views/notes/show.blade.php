@extends('layouts.app')

@section('title', 'Visualizar Anotação')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $note->title }}</h1>
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ $note->created_at->format('d/m/Y H:i') }}
        </div>
        @if($note->project)
            <div class="mb-4">
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">{{ $note->project->name }}</span>
            </div>
        @endif
    </div>
    <div class="bg-white rounded-lg shadow p-6 prose max-w-none">
        {!! $note->content !!}
    </div>
    <div class="mt-6 flex justify-end">
        <a href="{{ url()->previous() }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">Voltar</a>
    </div>
</div>
@endsection 