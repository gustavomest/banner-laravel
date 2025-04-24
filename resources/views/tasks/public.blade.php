@extends('layouts.app')

@section('content')
<div class="mt-6">
    <h2 class="text-xl font-semibold text-gray-800">Banners</h2>
    <div class="mt-4">
        <div class="flex justify-between font-semibold text-gray-600 border-b pb-2">
            <div class="flex-1">Título</div>
            <div class="flex-1">Plataforma</div>
            <div class="flex-1">Campanha</div>
            <div class="flex-1">Resolução</div>
            <div class="flex-1">Peso</div>
            <div class="flex-1">Duração</div>
            <div class="flex-1">Formato</div>
            <div class="flex-1">Empresa</div>
            <div class="flex-1">Tipo</div>
            <div class="flex-1 text-right">Opções</div>
        </div>

        @foreach ($task->subtasks as $subtask)
            <div class="flex justify-between items-center py-2 border-b">
                <div class="flex-1">{{ $subtask->title }}</div>
                <div class="flex-1">{{ $subtask->platform }}</div>
                <div class="flex-1">{{ $subtask->campaign }}</div>
                <div class="flex-1">{{ $subtask->resolution }}</div>
                <div class="flex-1">{{ $subtask->weight }}</div>
                <div class="flex-1">{{ $subtask->time }}</div>
                <div class="flex-1">{{ $subtask->format }}</div>
                <div class="flex-1">{{ $subtask->company }}</div>
                <div class="flex-1">{{ $subtask->type }}</div>
                <div class="flex-1 text-right">
                    @if($subtask->file_path)
                        <a href="{{ asset('storage/' . $subtask->file_path) }}" class="text-blue-600 hover:underline">Ver Arquivo</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="mt-4 text-center">
    <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:underline transition">Voltar para as listas</a>
</div>
</div>
@endsection