<style>
.htmlzip {
    overflow: hidden;
}
.htmlzip iframe {
    zoom: 0.50; /* Ajuste conforme necessário */
}    
    .modal-body .video, .modal-body .htmlzip {
        width: 1000;
        height: 150;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .video video, .htmlzip iframe {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transform: scale(1); /* Reduz mais para evitar rolagem */
    transform-origin: center center;
}
.htmlzip {
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
}
.htmlzip iframe {
    border: none;
    transform-origin: top left;
}
</style>


<div class="mt-10">
<h2 class="text-xl font-semibold text-gray-900 text-center">{{ $task->title }}</h2>
    <h2 class="text-xl font-semibold text-gray-600 text-center">Banners</h2>
    <div class="mt-10">
        <div class="flex justify-between font-semibold text-gray-800 border-b pb-6">
            <div class="flex-1">Arquivo</div>
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
        <div class="flex justify-between items-center py-3 border-a">
            <div class="flex-1">{{ $subtask->title }}</div>
            <div class="flex-1">{{ $subtask->subtitle }}</div>
            <div class="flex-1">{{ $subtask->platform }}</div>
            <div class="flex-1">{{ $subtask->campaign }}</div>
            <div class="flex-1">{{ $subtask->resolution }}</div>
            <div class="flex-1">{{ number_format($subtask->weight / 1024, 2) }} MB</div>
            <div class="flex-1">{{ $subtask->time }}</div>
            <div class="flex-1">{{ $subtask->format }}</div>
            <div class="flex-1">{{ $subtask->company }}</div>
            <div class="flex-1">{{ $subtask->type }}</div>
            <div class="flex-1 text-right">
                @if($subtask->file_path)
                    @php
                        $fileExtension = pathinfo($subtask->file_path, PATHINFO_EXTENSION);
                    @endphp
                    @if ($fileExtension === 'zip')
                    <button onclick="openModal('{{ asset('storage/uploads/extracted/' . $subtask->title . '/index.html') }}', false, '{{ $subtask->title }}', 'html', '{{ number_format($subtask->weight / 1024, 2) }} MB', '{{ $subtask->resolution }}', '00:00:00', '{{ $subtask->title }}')" class="text-blue-600 hover:underline">
                    <i class="fas fa-eye"></i>
                    </button>
                    @elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                        <button onclick="openModal('{{ asset('storage/' . $subtask->file_path) }}', false, '{{ $subtask->title }}', '{{ $fileExtension }}', '{{ number_format($subtask->weight / 1024, 2) }} MB', '{{ $subtask->resolution }}', '00:00:00')" class="text-blue-600 hover:underline">
                            <i class="fas fa-eye"></i>
                        </button>
                    @elseif ($fileExtension === 'mp4')
                        <button onclick="openModal('{{ asset('storage/' . $subtask->file_path) }}', true, '{{ $subtask->title }}', 'mp4', '{{ number_format($subtask->weight / 1024, 2) }} MB', '{{ $subtask->resolution }}', '{{ $subtask->time }}')" class="text-blue-600 hover:underline">
                            <i class="fas fa-eye"></i>
                        </button>
                    @endif
                @endif

                @if(Auth::check())
                    <form action="{{ route('subtasks.destroy', [$task, $subtask]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline transition ml-2" aria-label="Excluir">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal de Pré-Visualização -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="previewModalLabel">Pré-Visualizar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Conteúdo Dinâmico (Imagem, Vídeo ou HTML) -->
                <div class="image" style="display: none">
                    <div class="w-100 d-flex bg-black justify-content-center align-items-center text-center p-2" style="aspect-ratio: 1/1;">
                        <img id="imagePreview" style="max-width: 100%; max-height: 100%;" alt="Pré-Visualização">
                    </div>
                </div>
                <div class="video" style="display: none">
                    <div class="w-100 d-flex bg-black justify-content-center align-items-center text-center p-2" style="aspect-ratio: 1/1;">
                        <video id="videoPreview" style="object-fit: contain; max-width: 100%; max-height: 100%" controls autoplay muted></video>
                    </div>
                </div>
                <div class="htmlzip" style="display: none;">
                    <div class="w-100 d-flex bg-black justify-content-center align-items-center text-center p-5" style="aspect-ratio: 4/3; flex-grow: 5;">
                      <iframe id="htmlPreview" style="width: 100%; height: 100%; border: none;"></iframe>
                    </div>
                </div>
                <div class="zoom-controls" style="text-align: center; display: none;">
                     <label for="zoomSlider" style="color: white;">Zoom</label>
                         <input id="zoomSlider" type="range" min="0.5" max="2" step="0.05" value="1" style="width: 100%;"/>
                <div id="zoomValue" style="color: white;">1x</div>
                    </div>




                <!-- Informações do Arquivo -->
                <div class="m-2">
                    <h6>Arquivo: <span id="arquivoNome"></span></h6>
                    <h6>Formato: <span id="arquivoFormato"></span></h6>
                    <h6>Dimensões: <span id="arquivoDimensao"></span></h6>
                    <h6>Duração: <span id="arquivoDuracao"></span></h6>
                    <h6>Peso: <span id="arquivoPeso"></span></h6>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Botões -->
                <button class="btn btn-success download" id="downloadBtn">Baixar</button>

                <!-- Botão de Pedir Alteração -->
                <button class="btn btn-warning" id="requestChangeBtn">Pedir Alteração</button>
            </div>

        </div>
    </div>
</div>

<script>
function openModal(fileUrl, isVideo, title, fileFormat, fileSize, fileDimensions, fileDuration, extractedFolderName) {
    var modal = new bootstrap.Modal(document.getElementById('previewModal'));
    modal.show();

    document.querySelector('.video').style.display = 'none';
    document.querySelector('.htmlzip').style.display = 'none';
    document.querySelector('.image').style.display = 'none';
    document.querySelector('.zoom-controls').style.display = 'none'; // Inicialmente oculta o controle de zoom

    if (fileFormat === 'jpg' || fileFormat === 'jpeg' || fileFormat === 'png' || fileFormat === 'gif') {
        document.querySelector('.image').style.display = 'block';
        var imageElement = document.getElementById('imagePreview');
        imageElement.src = fileUrl;
    } else if (isVideo) {
        document.querySelector('.video').style.display = 'block';
        var videoElement = document.getElementById('videoPreview');
        videoElement.src = fileUrl;
        videoElement.load();
    } else if (fileFormat === 'html') {
        document.querySelector('.htmlzip').style.display = 'block';
        var iframeElement = document.getElementById('htmlPreview');
        
        // Definir o src do iframe com a URL correta
        iframeElement.src = "{{ asset('storage/uploads/extracted') }}/" + encodeURIComponent(extractedFolderName.replace('.zip', '')) + "/index.html";

        // Adapte o iframe conforme a resolução do subtask
        adjustIframeSize(iframeElement, fileDimensions);

        // Exibir controles de zoom
        document.querySelector('.zoom-controls').style.display = 'block';

        // Inicializar o slider com valor 1 (zoom original)
        var zoomLevel = 1;

        // Atualizar o valor do zoom ao mover o slider
        document.getElementById('zoomSlider').addEventListener('input', function() {
            zoomLevel = parseFloat(this.value);
            adjustIframeScale(iframeElement, zoomLevel);
            document.getElementById('zoomValue').textContent = `${zoomLevel.toFixed(2)}x`; // Exibe o valor do zoom
        });
    }

    document.getElementById('arquivoNome').textContent = title;
    document.getElementById('arquivoFormato').textContent = fileFormat;
    document.getElementById('arquivoDimensao').textContent = fileDimensions;
    document.getElementById('arquivoDuracao').textContent = fileDuration;
    document.getElementById('arquivoPeso').textContent = fileSize;

    document.getElementById('downloadBtn').onclick = function() {
    var zipFileName = title;  // Assume-se que o nome do arquivo ZIP seja baseado no título da subtask
    var zipFilePath = "/storage/uploads/originals/" + zipFileName;  // Caminho para o arquivo ZIP

    // Criando um link temporário para o arquivo ZIP
    var link = document.createElement('a');
    link.href = zipFilePath;  // O caminho do arquivo
    link.download = zipFileName;  // Nome do arquivo para download

    // Aciona o download
    link.click();
};



    document.getElementById('requestChangeBtn').onclick = function() {
        var subject = "Pedido de Alteração - " + title;
        var body = "alterações para o arquivo: " + title;
        var mailtoLink = "https://mail.google.com/mail/?view=cm&fs=1&to=gustavomesquita0712@gmail.com&su=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);
        window.location.href = mailtoLink;
    };
}

function adjustIframeSize(iframe, dimensions) {
    const [width, height] = dimensions.split('x').map(Number);
    const containerWidth = 1000; // Ajuste este valor se o modal precisar ser mais largo ou estreito
    const scale = containerWidth / width;

    iframe.style.width = `${width}px`;
    iframe.style.height = `${height}px`;
    iframe.style.transform = `scale(${scale})`;
}

function adjustIframeScale(iframe, scale) {
    iframe.style.transform = `scale(${scale})`;
}


</script>