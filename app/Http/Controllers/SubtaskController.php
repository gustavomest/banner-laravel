<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtask;
use App\Models\Task;
use App\Services\FileService;
use Illuminate\Support\Facades\File;
use ZipArchive;

class SubtaskController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function store(Request $request, Task $task)
    {
        // Validação do arquivo
        $request->validate([
            'file' => 'required|mimes:zip,jpg,jpeg,png,gif,mp4,avi,mov|max:20480',
            'type' => 'required|in:Desenvolvimento,Aprovado,Pedir Alteração',
            
        ]);
    
        $file = $request->file('file');
        $fileExtension = $file->getClientOriginalExtension();
        $path = $this->fileService->storeFile($file); // Armazenamento do arquivo original
    
        $htmlFilePath = null;
    
        // Verificar se o arquivo é um ZIP e extrair
        if ($fileExtension === 'zip') {
            // Usar o nome do arquivo ZIP para o diretório de extração
            $subtaskData = [];
            $this->fileService->extractZip($path, $subtaskData);
    
            // Verificar se o caminho do arquivo HTML extraído foi retornado
            if (isset($subtaskData['index_path'])) {
                $htmlFilePath = $subtaskData['index_path']; // Caminho do arquivo HTML extraído
            }
        }
    
        // Criar a subtarefa no banco de dados
        $subtask = Subtask::create([
            'task_id' => $task->id,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'platform' => $request->platform,
            'campaign' => $request->campaign,
            'resolution' => $request->resolution,
            'weight' => $request->weight,
            'time' => $request->time,
            'format' => $request->format,
            'company' => $request->company,
            'type' => $request->type,
            'file_path' => $path,
            'extracted_path' => $htmlFilePath, // Caminho do HTML extraído
        ]);
    
        return redirect()->route('tasks.show', $task)->with('success', 'Subtarefa criada com sucesso!');
    }
    

    public function destroy(Task $task, Subtask $subtask)
    {
        // Deletar arquivos relacionados
        if ($subtask->file_path) {
            $this->fileService->deleteFile($subtask->file_path);
        }
        if ($subtask->extracted_path) {
            $this->fileService->deleteDirectory($subtask->extracted_path);
        }

        // Deletar a subtarefa
        $subtask->delete();

        return redirect()->route('tasks.show', $task)->with('success', 'Subtarefa excluída com sucesso!');
    }
}
