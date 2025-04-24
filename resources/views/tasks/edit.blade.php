@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold text-gray-700 text-center">Edit Task</h1>
        
        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mt-4">
                <label for="title" class="block text-sm font-medium text-gray-600">Titulo da lista</label>
                <input type="text" name="title" id="title" value="{{ $task->title }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 p-2">
            </div>

            <div class="mt-4">
                <label for="description" class="block text-sm font-medium text-gray-600">Descrição da lista</label>
                <textarea name="description" id="description" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 p-2">{{ $task->description }}</textarea>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Atualizar
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:underline">voltar para Lista</a>
        </div>
    </div>
@endsection
