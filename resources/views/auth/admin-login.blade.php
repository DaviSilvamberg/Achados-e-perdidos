@extends('layouts.app')

@section('title', 'Acesso do administrador')
@section('page-title', 'Acesso do administrador')

@section('content')
    <div class="form-container login-container">
        <div class="form-heading">
            <div class="form-icon">🔐</div>
            <h1>Entrar na administração</h1>
            <p>Informe a senha para acessar o painel de administração.</p>
        </div>

        <form action="{{ route('admin.login.store') }}" method="POST">
            @csrf

            <div class="form-group login-password">
                <label for="password">Senha</label>
                <input id="password" type="password" name="password" autocomplete="current-password" required autofocus>
            </div>

            <label class="remember-option">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                Manter conectado
            </label>

            <div class="form-buttons">
                <a href="{{ route('objetos.index') }}" class="btn-cancel">Voltar ao mural</a>
                <button type="submit" class="btn-primary">Entrar</button>
            </div>
        </form>
    </div>
@endsection
