
@extends('layouts.app')

@section('title', 'Editar Objeto')
@section('page-title', 'Editar Objeto')

@section('content')

<div class="form-container">

    <div class="form-heading">

        <div class="form-icon">✏️</div>

        <h1>Editar objeto</h1>

        <p>Atualize as informações do objeto cadastrado.</p>

    </div>

    <form
        action="{{ route('objetos.update', $objeto->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group full-width">
                <label>Título</label>

                <input
                    type="text"
                    name="titulo"
                    value="{{ old('titulo', $objeto->titulo) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Categoria</label>

                <select name="categoria" required>

                    @foreach([
                        'Material escolar',
                        'Eletrônicos',
                        'Roupas e acessórios',
                        'Garrafas e lancheiras',
                        'Documentos',
                        'Outros'
                    ] as $categoria)

                        <option
                            value="{{ $categoria }}"
                            {{ old('categoria', $objeto->categoria) == $categoria ? 'selected' : '' }}
                        >
                            {{ $categoria }}
                        </option>

                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label>Local</label>

                <input
                    type="text"
                    name="local"
                    value="{{ old('local', $objeto->local) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Turno</label>

                <select name="turno" required>

                    @foreach(['Matutino', 'Vespertino', 'Noturno'] as $turno)

                        <option
                            value="{{ $turno }}"
                            {{ old('turno', $objeto->turno) == $turno ? 'selected' : '' }}
                        >
                            {{ $turno }}
                        </option>

                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label>Status</label>

                <select name="status" required>

                    <option value="disponível"
                        {{ old('status', $objeto->status) == 'disponível' ? 'selected' : '' }}>
                        Disponível
                    </option>

                    <option value="devolvido"
                        {{ old('status', $objeto->status) == 'devolvido' ? 'selected' : '' }}>
                        Devolvido
                    </option>

                </select>
            </div>

            <div class="form-group full-width">
                <label>Descrição</label>

                <textarea name="descricao" rows="5" required>{{ old('descricao', $objeto->descricao) }}</textarea>
            </div>

            <div class="form-group full-width">
                <label>Foto atual</label>

                @if($objeto->foto)

                    <img
                        src="{{ asset('storage/' . $objeto->foto) }}"
                        class="preview-image"
                        alt="Foto do objeto"
                    >

                @endif

                <label>Escolher nova foto</label>

                <input
                    type="file"
                    name="foto"
                    accept="image/*"
                >

            </div>

        </div>

        <div class="form-buttons">

            <a href="{{ route('objetos.index') }}" class="btn-cancel">
                Cancelar
            </a>

            <button type="submit" class="btn-primary">
                Salvar alterações
            </button>

        </div>

    </form>

</div>

@endsection
