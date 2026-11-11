
@extends('layouts.app')

@section('title', 'Cadastrar Objeto')
@section('page-title', 'Cadastrar Objeto')

@section('content')

<div class="form-container">

    <div class="form-heading">

        <div class="form-icon">📦</div>

        <h1>Cadastrar objeto encontrado</h1>

        <p>
            Preencha as informações do objeto encontrado na escola.
        </p>

    </div>

    <form
        action="{{ route('objetos.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        <div class="form-grid">

            <div class="form-group full-width">
                <label>Título do objeto *</label>

                <input
                    type="text"
                    name="titulo"
                    placeholder="Ex: Mochila preta"
                    value="{{ old('titulo') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Categoria *</label>

                <select name="categoria" required>

                    <option value="">Selecione uma categoria</option>
                    <option value="Material escolar">Material escolar</option>
                    <option value="Eletrônicos">Eletrônicos</option>
                    <option value="Roupas e acessórios">Roupas e acessórios</option>
                    <option value="Garrafas e lancheiras">Garrafas e lancheiras</option>
                    <option value="Documentos">Documentos</option>
                    <option value="Outros">Outros</option>

                </select>
            </div>

            <div class="form-group">
                <label>Local encontrado *</label>

                <input
                    type="text"
                    name="local"
                    placeholder="Ex: Biblioteca"
                    value="{{ old('local') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Turno *</label>

                <select name="turno" required>

                    <option value="">Selecione o turno</option>
                    <option value="Matutino">Matutino</option>
                    <option value="Vespertino">Vespertino</option>
                    <option value="Noturno">Noturno</option>

                </select>
            </div>

            <div class="form-group">
                <label>Foto do objeto</label>

                <input
                    type="file"
                    name="foto"
                    accept="image/*"
                >
            </div>

            <div class="form-group full-width">
                <label>Descrição *</label>

                <textarea
                    name="descricao"
                    rows="5"
                    placeholder="Descreva as características do objeto..."
                    required
                >{{ old('descricao') }}</textarea>
            </div>

        </div>

        <div class="form-buttons">

            <a href="{{ route('objetos.index') }}" class="btn-cancel">
                Cancelar
            </a>

            <button type="submit" class="btn-primary">
                Salvar objeto
            </button>

        </div>

    </form>

</div>

@endsection
