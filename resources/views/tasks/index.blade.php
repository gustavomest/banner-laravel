@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold text-gray-700 text-center">Lista de Clientes</h1>
        
        <div class="text-right">
            <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Criar Lista</a>
        </div>

        @if (session('success'))
            <div class="mt-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-6">
            <div class="flex justify-between font-semibold text-gray-600 border-b pb-2">
                <div class="flex-1">Título</div>
                <div class="flex-1">Descrição</div>
                <div class="flex-1 text-right">Opções</div>
            </div>
            @foreach ($tasks as $task)
                <div class="flex justify-between items-center py-2 border-b">
                    <div class="flex-1">
                        <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:underline">{{ $task->title }}</a>
                    </div>
                    <div class="flex-1 text-gray-500">
                        {{ $task->description }}
                    </div>
                    <div class="flex-1 text-right">
                        <!-- Ícone de editar -->
                        <a href="{{ route('tasks.edit', $task) }}" class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Formulário de exclusão -->
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
