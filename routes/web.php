<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubtaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui você pode registrar as rotas para sua aplicação.
|
*/

// Rota para acessar arquivos em storage
Route::get('storage/uploads/{any}', function ($any) {
    $path = storage_path('app/public/uploads/' . $any);
    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
})->where('any', '.*');

// Rotas públicas
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas de autenticação
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    // Rotas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de tarefas
    Route::resource('tasks', TaskController::class);

    // Rotas de subtarefas
    Route::prefix('tasks/{task}')->group(function () {
        // Subtarefas dentro de uma tarefa
        Route::post('subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
        Route::delete('subtasks/{subtask}', [SubtaskController::class, 'destroy'])->name('subtasks.destroy');
        Route::get('subtasks/{subtask}/preview', [SubtaskController::class, 'previewBanner'])->name('subtasks.preview');
    });
});

// Rotas para visualização de tarefas
Route::get('/task/{url}', [TaskController::class, 'showByUrl'])->name('tasks.showByUrl');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('tasks/{task}/subtasks/{subtask}/approve', [SubtaskController::class, 'approve'])->name('subtasks.approve');

// Carregar rotas de autenticação
require __DIR__.'/auth.php';
