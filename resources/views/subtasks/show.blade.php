@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold text-gray-700">Subtask: {{ $subtask->title }}</h1>
        
        <p class="mt-4 text-gray-600">Plataforma: {{ $subtask->platform }}</p>
        <p class="mt-4 text-gray-600">Campanha: {{ $subtask->campaign }}</p>
        <p class="mt-4 text-gray-600">Resolution: {{ $subtask->resolution }}</p>
        <p class="mt-4 text-gray-600">Weight: {{ $subtask->weight }}</p>
        <p class="mt-4 text-gray-600">Time: {{ $subtask->time }}</p>
        <p class="mt-4 text-gray-600">Format: {{ $subtask->format }}</p>
        <p class="mt-4 text-gray-600">Company: {{ $subtask->company }}</p>
        <p class="mt-4 text-gray-600">tipo: {{ $subtask->type }}</p>

        @if($subtask->file_path)
            <div class="mt-4">
                <a href="{{ asset('storage/' . $subtask->file_path) }}" class="text-blue-600 hover:underline">View File</a>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('tasks.show', $subtask->task) }}" class="text-blue-600 hover:underline">Back to Task</a>
        </div>
    </div>
@endsection
