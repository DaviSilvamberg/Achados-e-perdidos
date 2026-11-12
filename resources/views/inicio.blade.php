
@extends('layouts.app')

@section('title', 'Início | Achados e Perdidos')
@section('page-title', 'Página Inicial')

@section('content')

<section class="welcome-banner">

    <div>
        <span class="welcome-label">PORTAL ESCOLAR</span>

        <h1>Perdeu algo na escola?</h1>

        <p>
            Consulte os objetos encontrados na escola. O cadastro e a atualização
            dos itens são feitos somente pela equipe administradora.
        </p>

        <div class="welcome-buttons">

            <a href="{{ route('objetos.index') }}" class="btn-white">
                Procurar objetos
            </a>

            <a href="{{ route('login') }}" class="btn-outline">
                Área do administrador
            </a>

        </div>
    </div>

    <div class="banner-icon">🎒</div>

</section>

<section class="stats-container">

    <div class="stat-card">
        <div class="stat-icon blue">📦</div>

        <div>
            <p>Objetos cadastrados</p>
            <h2>{{ $totalObjetos ?? 0 }}</h2>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">✅</div>

        <div>
            <p>Objetos devolvidos</p>
            <h2>{{ $totalDevolvidos ?? 0 }}</h2>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">🔍</div>

        <div>
            <p>Objetos disponíveis</p>
            <h2>{{ $totalDisponiveis ?? 0 }}</h2>
        </div>
    </div>

</section>

<section class="section">

    <div class="section-header">
        <h2>Como funciona?</h2>
        <p>Encontre ou devolva objetos de maneira simples.</p>
    </div>

    <div class="steps-grid">

        <div class="step-card">
            <span>01</span>
            <div class="step-icon">📝</div>

            <h3>Cadastre</h3>

            <p>
                A equipe administradora registra as informações
                e uma foto do objeto encontrado.
            </p>
        </div>

        <div class="step-card">
            <span>02</span>
            <div class="step-icon">🔎</div>

            <h3>Localize</h3>

            <p>
                Consulte o mural e utilize os filtros
                para encontrar o objeto desejado.
            </p>
        </div>

        <div class="step-card">
            <span>03</span>
            <div class="step-icon">🤝</div>

            <h3>Devolva</h3>

            <p>
                O objeto poderá ser retirado e seu status
                atualizado para devolvido.
            </p>
        </div>

    </div>

</section>

@endsection