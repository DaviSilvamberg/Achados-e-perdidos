
@extends('layouts.app')

@section('title', 'Mural de Objetos')
@section('page-title', 'Mural de Objetos')

@section('content')

<div class="page-heading">

    <div>
        <h1>Objetos encontrados</h1>
        <p>Confira os objetos registrados na escola.</p>
    </div>

    @can('administrar-objetos')
        <a href="{{ route('objetos.create') }}" class="btn-primary">
            + Novo cadastro
        </a>
    @endcan

</div>

<form action="{{ route('objetos.index') }}" method="GET" class="filter-box">

    <div class="filter-field search-field">
        <label>Pesquisar objeto</label>

        <input
            type="text"
            name="busca"
            placeholder="Digite o nome do objeto..."
            value="{{ request('busca') }}"
        >
    </div>

    <div class="filter-field">
        <label>Categoria</label>

        <select name="categoria">

            <option value="">Todas as categorias</option>

            @foreach([
                'Material escolar',
                'Eletrônicos',
                'Roupas e acessórios',
                'Garrafas e lancheiras',
                'Documentos',
                'Outros'
            ] as $categoria)
                <option value="{{ $categoria }}" {{ request('categoria') === $categoria ? 'selected' : '' }}>
                    {{ $categoria }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="filter-field">
        <label>Turno</label>

        <select name="turno">

            <option value="">Todos os turnos</option>
            @foreach(['Matutino', 'Vespertino', 'Noturno'] as $turno)
                <option value="{{ $turno }}" {{ request('turno') === $turno ? 'selected' : '' }}>
                    {{ $turno }}
                </option>
            @endforeach

        </select>
    </div>

    <button type="submit" class="btn-primary filter-button">
        Filtrar
    </button>

</form>

<div class="objects-grid">

    @forelse($objetos as $objeto)

        <div class="object-card">

            <div class="object-image">

                @if($objeto->foto)

                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($objeto->foto) }}"
                        alt="{{ $objeto->titulo }}"
                    >

                @else

                    <div class="no-image">📦</div>

                @endif

                <span class="status-badge {{ $objeto->status == 'devolvido' ? 'returned' : '' }}">
                    {{ ucfirst($objeto->status) }}
                </span>

            </div>

            <div class="object-info">

                <span class="category-tag">{{ $objeto->categoria }}</span>

                <h3>{{ $objeto->titulo }}</h3>

                <p>{{ $objeto->descricao }}</p>

                <div class="object-details">
                    <span>📍 {{ $objeto->local }}</span>
                    <span>🕒 {{ $objeto->turno }}</span>
                </div>

                @can('administrar-objetos')
                    <div class="object-actions">
                        <a
                            href="{{ route('objetos.edit', $objeto->id) }}"
                            class="btn-edit"
                        >
                            Editar
                        </a>

                        <form
                            action="{{ route('objetos.destroy', $objeto->id) }}"
                            method="POST"
                            onsubmit="return confirm('Deseja excluir este objeto?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn-delete">
                                Excluir
                            </button>
                        </form>
                    </div>
                @endcan

            </div>

        </div>

    @empty

        <div class="empty-state">
            <div>🔎</div>

            <h3>Nenhum objeto encontrado</h3>

            <p>Não existem objetos cadastrados com esses filtros.</p>
        </div>

    @endforelse

</div>

<div class="pagination">
    {{ $objetos->links() }}
</div>

@endsection
