<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    // Construtor para aplicar middleware de autenticação
    public function __construct()
    {
        $this->middleware('auth')->except('showByUrl');
    }

    // Exibir a lista de tarefas
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    // Mostrar o formulário para criar uma nova tarefa
    public function create()
    {
        return view('tasks.create');
    }

    // Armazenar uma nova tarefa
    public function store(Request $request)
    {
        // Apenas usuários autenticados podem criar tarefas
        $this->authorize('create', Task::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Criação da nova tarefa
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => Str::random(10), // Gera uma URL aleatória
            'is_public' => true, // Define como público
        ]);

        // Redireciona para a rota com a URL da tarefa
        return redirect()->route('tasks.showByUrl', $task->url)->with('success', 'Lista criada com sucesso!');
    }

    // Exibir uma tarefa específica
    public function show(Task $task)
    {
        $task->load('subtasks'); // Carrega subtarefas
        return redirect()->route('tasks.showByUrl', $task->url)->with('success', 'Lista criada com sucesso!');
    }

    // Mostrar o formulário para editar uma tarefa
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Atualizar uma tarefa existente
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($request->all());
        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso.');
    }

    // Deletar uma tarefa
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarefa deletada com sucesso.');
    }

    // Mostrar tarefa pela URL
    public function showByUrl($url)
    {
        $task = Task::where('url', $url)->firstOrFail();
        
        // Verifica se a tarefa é pública
        if (!$task->is_public) {
            abort(403); // Acesso negado se não for público
        }

        return view('tasks.show', compact('task'));
    }
}
