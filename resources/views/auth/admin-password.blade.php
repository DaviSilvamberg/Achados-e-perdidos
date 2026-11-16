@extends('layouts.app')

@section('title', 'Alterar senha do administrador')
@section('page-title', 'Alterar senha')

@section('content')
    <div class="form-container login-container">
        <div class="form-heading">
            <div class="form-icon">🔑</div>
            <h1>Alterar senha do painel</h1>
            <p>Confirme sua senha atual e informe uma nova senha com pelo menos 8 caracteres.</p>
        </div>

        <form action="{{ route('admin.password.update') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="current_password">Senha atual</label>
                <input id="current_password" type="password" name="current_password" autocomplete="current-password" required autofocus>
            </div>

            <div class="form-group login-password">
                <label for="password">Nova senha</label>
                <input id="password" type="password" name="password" autocomplete="new-password" required>
            </div>

            <div class="form-group login-password">
                <label for="password_confirmation">Confirme a nova senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
            </div>

            <div class="form-buttons">
                <a href="{{ route('objetos.index') }}" class="btn-cancel">Voltar ao mural</a>
                <button type="submit" class="btn-primary">Salvar nova senha</button>
            </div>
        </form>
    </div>
@endsection
