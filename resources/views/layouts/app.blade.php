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

            @can('administrar-objetos')
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    🛠️ Administração
                </a>

                <a href="{{ route('objetos.create') }}" class="nav-link">
                    ➕ Cadastrar objeto
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-link">
                    🔐 Acesso do administrador
                </a>
            @endcan
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

            @can('administrar-objetos')
                <div class="account-actions">
                    <span>{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">Sair</button>
                    </form>
                </div>
            @else
                <div class="user-icon">👤</div>
            @endcan
        </header>

        <main class="content">
            @if (session('success'))
                <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning" role="alert">{{ session('warning') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <p>Verifique os dados informados:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="footer">
            <p>© 2026 - Achados e Perdidos Escolar</p>
        </footer>

    </div>

</body>
</html>