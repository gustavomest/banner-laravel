<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class FileService
{
    /**
     * Armazena o arquivo e garante que o nome seja único.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string|null
     */
    public function storeFile($file)
    {
        // Obter o nome original do arquivo sem a extensão
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // Obter a extensão do arquivo
        $extension = $file->getClientOriginalExtension();
        // Caminho inicial do arquivo (sem sufixo numérico)
        $filePath = 'uploads/originals/' . $originalName . '.' . $extension;

        // Verificar se o arquivo já existe e renomear se necessário
        $counter = 1;
        while (Storage::disk('public')->exists($filePath)) {
            // Se o arquivo já existe, adicionar um sufixo numérico
            $filePath = 'uploads/originals/' . $originalName . '_' . $counter . '.' . $extension;
            $counter++;
        }

        // Salvar o arquivo e retornar o caminho se o upload for bem-sucedido
        if (Storage::disk('public')->put($filePath, file_get_contents($file))) {
            return $filePath;
        }

        // Caso ocorra algum erro ao salvar, retornar null
        Log::error('Falha ao salvar o arquivo: ' . $file->getClientOriginalName());
        return null;
    }

    /**
     * Extrai um arquivo ZIP e armazena o caminho extraído.
     *
     * @param  string  $filePath
     * @param  array  $subtaskData
     * @return void
     */
    public function extractZip($filePath, &$subtaskData)
    {
        $zip = new ZipArchive;
        
        // Definir o caminho de extração, garantindo que o nome do diretório seja o mesmo que o do arquivo ZIP
        $extractedPath = 'uploads/extracted/' . pathinfo($filePath, PATHINFO_FILENAME); 

        // Tentar abrir e extrair o arquivo ZIP
        if ($zip->open(storage_path('app/public/' . $filePath)) === true) {
            // Extrair os arquivos para o diretório especificado
            $zip->extractTo(storage_path('app/public/' . $extractedPath));
            $zip->close();
    
            // Inicializar um array para armazenar os arquivos extraídos
            $extractedFiles = [];
    
            // Iterar sobre os arquivos extraídos e registrar as URLs
            $files = File::allFiles(storage_path('app/public/' . $extractedPath));
            foreach ($files as $file) {
                // Armazenar a URL de cada arquivo
                $extractedFiles[] = asset('storage/' . $extractedPath . '/' . $file->getRelativePathname());
            }
    
            // Salvar as informações de extração no array
            $subtaskData['extracted_files'] = $extractedFiles;
            $subtaskData['index_path'] = asset('storage/' . $extractedPath . '/index.html');
        } else {
            // Log de erro e lançamento de exceção
            Log::error('Falha ao descompactar o arquivo ZIP: ' . $filePath);
            throw new \Exception('Falha ao descompactar o arquivo ZIP.');
        }
    }

    /**
     * Exclui um arquivo.
     *
     * @param  string  $filePath
     * @return void
     */
    public function deleteFile($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            if (!Storage::disk('public')->delete($filePath)) {
                Log::error('Falha ao excluir o arquivo: ' . $filePath);
            }
        } else {
            Log::warning('Arquivo não encontrado para exclusão: ' . $filePath);
        }
    }

    /**
     * Exclui um diretório.
     *
     * @param  string  $directoryPath
     * @return void
     */
    public function deleteDirectory($directoryPath)
    {
        if ($directoryPath && Storage::disk('public')->exists($directoryPath)) {
            if (!Storage::disk('public')->deleteDirectory($directoryPath)) {
                Log::error('Falha ao excluir o diretório: ' . $directoryPath);
            }
        } else {
            Log::warning('Diretório não encontrado para exclusão: ' . $directoryPath);
        }
    }
}
