
@include('bootstrap_links')
@if(Auth::check())
@endif
    <style>
        .card { 
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            background-color: #f8f9fa;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .container {
        margin-top: 25px; /* Ajuste o valor conforme necessário */
    }
    </style>
</head>
<body>
@if(Auth::check())
<form action="{{ route('subtasks.store', ['task' => $task->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="container mt-5">
        <!-- Usando o card com cores personalizadas -->
        <div class="card shadow-lg p-4 bg-light">
            <h3 class="text-center mb-4 text-primary">{{ $task->title }}</h3>
            <h5 class="text-center mb-2">{{ $task->description }}</h5>

            <!-- Linha para a organização dos inputs -->
            <div class="row">
                <!-- Título do Arquivo -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title" class="text-muted">Arquivo</label>
                        <input type="text" id="title" name="title" class="form-control border-primary" value="{{ old('title') }}" placeholder="Nome do Arquivo" readonly>
                    </div>
                </div>

                <!-- Subtítulo -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="subtitle" class="text-muted">Título</label>
                        <input type="text" id="subtitle" name="subtitle" class="form-control border-primary" value="{{ old('subtitle') }}" placeholder="Título" required>
                    </div>
                </div>
            </div>

            <!-- Linha para plataforma e campanha -->
            <div class="row">
                <!-- Plataforma -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="platform" class="text-muted">Plataforma</label>
                        <input type="text" id="platform" name="platform" class="form-control border-primary" value="{{ old('platform') }}" placeholder="Plataforma">
                    </div>
                </div>

                <!-- Campanha -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="campaign" class="text-muted">Campanha</label>
                        <input type="text" id="campaign" name="campaign" class="form-control border-primary" value="{{ old('campaign') }}" placeholder="Campanha">
                    </div>
                </div>
            </div>

            <!-- Linha para resolução e peso -->
            <div class="row">
                <!-- Resolução -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="resolution" class="text-muted">Resolução</label>
                        <input type="text" id="resolution" name="resolution" class="form-control border-primary" value="{{ old('resolution') }}" placeholder="Resolução" readonly>
                    </div>
                </div>

                <!-- Peso -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="weight" class="text-muted">Peso</label>
                        <input type="number" id="weight" name="weight" class="form-control border-primary" value="{{ old('weight') }}" placeholder="Peso" readonly>
                    </div>
                </div>
            </div>

            <!-- Linha para tempo e formato -->
            <div class="row">
                <!-- Tempo -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="time" class="text-muted">Tempo</label>
                        <input type="text" id="time" name="time" class="form-control border-primary" value="{{ old('time') }}" placeholder="Tempo (mm:ss)" readonly>
                    </div>
                </div>

                <!-- Formato -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="format" class="text-muted">Formato</label>
                        <input type="text" id="format" name="format" class="form-control border-primary" value="{{ old('format') }}" placeholder="Formato" readonly>
                    </div>
                </div>
            </div>

            <!-- Linha para empresa e tipo -->
            <div class="row">
                <!-- Empresa -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company" class="text-muted">Empresa</label>
                        <input type="text" id="company" name="company" class="form-control border-primary" value="{{ old('company') }}" placeholder="Empresa">
                    </div>
                </div>

                <!-- Tipo -->
                <div class="col-md-6">
    <div class="form-group">
        <label for="type" class="text-muted">Status</label>
        <select id="type" name="type" class="form-control border-primary">
            <option value="Desenvolvimento" {{ old('type') == 'Desenvolvimento' ? 'selected' : '' }}>Desenvolvimento</option>
            <option value="Aprovado" {{ old('type') == 'Aprovado' ? 'selected' : '' }}>Aprovado</option>
            <option value="Pedir Alteração" {{ old('type') == 'Pedir Alteração' ? 'selected' : '' }}>Pedir Alteração</option>
        </select>
    </div>
</div>

            <div class="container mt-7">
          <!-- Arquivo -->
<div class="form-group">
    <label for="file" class="text-muted">Arquivo</label>
    <input type="file" id="file" name="file" class="form-control-file border-primary" accept="image/*,video/*,application/zip" required>
</div>
</div>

            <!-- Botão de Envio -->
            <button type="submit" class="btn btn-success btn-block mt-4">Adicionar Banner</button>
        </div>
    </div>
</form>
<script>
document.getElementById('file').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        document.getElementById('title').value = file.name;
        document.getElementById('weight').value = (file.size / 1024).toFixed(2);
        document.getElementById('format').value = file.type === 'application/zip' ? 'HTML' : file.type.split('/')[1]?.toUpperCase() || 'N/A';

        // Configuração para resolução e tempo
        document.getElementById('resolution').value = 'N/A';
        document.getElementById('time').value = '0:00';
        document.getElementById('resolution').readOnly = file.type !== 'application/zip';
        document.getElementById('time').readOnly = file.type !== 'application/zip';

        if (file.type.startsWith('image/')) {
            const img = new Image();
            img.onload = function() {
                document.getElementById('resolution').value = `${img.width}x${img.height}`;
            };
            img.src = URL.createObjectURL(file);
        } else if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.onloadedmetadata = function() {
                const minutes = Math.floor(video.duration / 60);
                const seconds = Math.floor(video.duration % 60);
                document.getElementById('time').value = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                document.getElementById('resolution').value = `${video.videoWidth}x${video.videoHeight}`;
            };
            video.src = URL.createObjectURL(file);
        }
    }
});

</script>
@endif