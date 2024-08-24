@extends('header')
@section('title', 'Cadastro')
@section('scripts')
    @vite(['resources/js/assuntos.js'])
@endsection
@section('modal')
    <div class="modal fade" id="modal_cadastro" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_cadastro">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Assunto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_cadastro">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="descricao_cadastro" required maxlength="40">
                                    <label for="descricao_cadastro">Descri&ccedil;&atilde;o</label>
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
    <div class="container mt-5">
        <div class="row justify-content-end">
            <div class="col-10 col-sm-5 text-end">
                <button class="btn btn-primary px-4 mb-4" id="btn_add_user" data-bs-toggle="modal"
                        data-bs-target="#modal_cadastro" onclick="document.getElementById('id_cadastro').value = ''">
                    <i class="fa-solid fa-plus"></i>
                    Novo Assunto
                </button>
            </div>
        </div>
        <div class="row justify-content-center" id="div_assuntos"></div>
    </div>
@endsection
