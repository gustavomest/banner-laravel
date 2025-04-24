@extends('layouts.app')
@section('content')

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Produtora Inside</title>
    <style>
        /* Estilos gerais */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Isso garante que a altura da página ocupe toda a tela */
        }

        /* Estilo para o título principal */
        h1 {
            text-align: center;
            margin-top: 50px;
            font-size: 2.5em;
            color: white;
        }

        /* Estilo para o texto principal */
        .main-text {
            text-align: center;
            font-size: 1.2em;
            margin: 20px;
            color: white; /* Texto em branco */
        }

        /* Estilos do footer */
        footer {
            margin-top: 580px; /* Espaçamento entre o conteúdo e o rodapé */
           
            background-color: #34495e;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 1em;
        }

        footer a {
            color: #1abc9c;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Responsividade para telas menores */
        @media (max-width: 600px) {
            h1 {
                font-size: 2em;
            }

            .main-text {
                font-size: 1em;
            }

            footer {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>

    <!-- Título Principal -->
    <h1>Bem-vindo ao Sistema da Produtora Inside</h1>

    <!-- Texto principal -->
    <div class="main-text">
        Este sistema é feito para a produtora Inside, trazendo soluções inovadoras para o mercado de produção de conteúdo.
    </div>

    <!-- Rodapé -->
    <footer>
        Desenvolvimento <a href="https://r3tech.com.br" target="_blank">R3Tech</a>.
    </footer>
</body>
</html>

@endsection
