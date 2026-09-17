<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/pagina-entrar.css">
    <title>Gerenciador de Carros</title>
</head>
<body>

<main class="welcome-container">
    <div class="access-card">
        <h1>Gerenciador de Carros</h1>
        <p class="card-description">
            Gerencie seus veículos e locações de forma simples e rápida.
        </p>

        @if (Route::has('login'))
            <nav class="access-buttons">
                @auth
                    <a class="custom-button dashboard-button"
                       href="{{ url('/dashboard') }}">
                        Dashboard
                    </a>
                @else
                    <a class="custom-button"
                       href="{{ route('login') }}">
                        Login
                    </a>

                    @if (Route::has('register'))
                        <a class="custom-button"
                           href="{{ route('register') }}">
                            Registrar
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </div>
</main>

@if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
@endif
</body>
</html>
