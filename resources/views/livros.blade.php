@extends('header')
@section('title', 'Cadastro')
@section('scripts')
    @vite(['resources/js/livros.js'])
@endsection
@section('modal')
    <div class="modal fade" id="modal_cadastro" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_cadastro">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Livro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_cadastro">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="titulo_cadastro" required maxlength="40">
                                    <label for="titulo_cadastro">T&iacute;tulo</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="autor_cadastro"
                                        {{count($autores) == 0 ? 'disabled' : ''}}>
                                        <option value="">&rarr; Escolha &larr;</option>
                                        @foreach($autores as $autor)
                                            <option value="{{$autor['id']}}">{{$autor['nome']}}</option>
                                        @endforeach
                                    </select>
                                    <label for="autor_cadastro">Autor</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="assunto_cadastro"
                                        {{count($assuntos) == 0 ? 'disabled' : ''}}>
                                        <option value="">&rarr; Escolha &larr;</option>
                                        @foreach($assuntos as $assunto)
                                            <option value="{{$assunto['id']}}">{{$assunto['descricao']}}</option>
                                        @endforeach
                                    </select>
                                    <label for="autor_cadastro">Assunto</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="editora_cadastro" required maxlength="40">
                                    <label for="editora_cadastro">Editora</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="edicao_cadastro" required>
                                    <label for="edicao_cadastro">Edi&ccedil;&atilde;o</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="ano_cadastro" required max="9999">
                                    <label for="ano_cadastro">Ano</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="valor_cadastro" required step="0.01">
                                    <label for="valor_cadastro">Valor</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page_content')
    {{--@TODO: Implementar a busca das associações de asssuntos e autores--}}
    <div class="container mt-5">
        <div class="row justify-content-end">
            <div class="col-10 col-sm-5 text-end">
                <button class="btn btn-primary px-4 mb-4" id="btn_add_user" data-bs-toggle="modal"
                        data-bs-target="#modal_cadastro" onclick="exibeModal()">
                    <i class="fa-solid fa-plus"></i>
                    Novo Livro
                </button>
            </div>
        </div>
        <div class="row justify-content-center" id="div_livros"></div>
    </div>
@endsection
