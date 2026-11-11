<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Achados e Perdidos Escolar')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <aside class="sidebar">

        <div class="logo">
            <span>🔎</span>
            <h2>Achados<span>&</span>Perdidos</h2>
        </div>

        <nav>
            <a href="{{ route('inicio') }}" class="nav-link">
                🏠 Início
            </a>

            <a href="{{ route('objetos.index') }}" class="nav-link">
                📦 Mural de objetos
            </a>

            <a href="{{ route('objetos.create') }}" class="nav-link">
                ➕ Cadastrar objeto
            </a>
        </nav>

        <div class="sidebar-footer">
            <p>Sistema Escolar</p>
            <small>Achados e Perdidos © 2026</small>
        </div>

    </aside>

    <div class="main-content">

        <header class="topbar">
            <div>
                <h3>@yield('page-title', 'Bem-vindo!')</h3>
                <p>Portal de Achados e Perdidos Escolar</p>
            </div>

            <div class="user-icon">👤</div>
        </header>

        <main class="content">
            @yield('content')
        </main>

        <footer class="footer">
            <p>© 2026 - Achados e Perdidos Escolar</p>
        </footer>

    </div>

</body>
</html>