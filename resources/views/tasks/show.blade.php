@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-10 lg:px- ">
    <div class="bg-white shadow-xl rounded-lg p-6">
        <h1 class="text-3xl font-semibold text-center">{{ $task->name }}</h1>

        <!-- Componente de Upload -->
        <x-form-upload :task="$task" />

        <!-- Banners -->
        @include('tasks.partials.banners')

    </div>
</div>
@endsection
