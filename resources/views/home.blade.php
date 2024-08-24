@extends('header')
@section('page_content')
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12 mt-5 text-center">
                <h5>Escolha uma das páginas para acessar</h5>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-12 col-sm-4 col-md-3 col-xl-2 my-2">
                <a class="btn btn-primary w-100 py-4" href="/livros">
                    <i class="fa-solid fa-book"></i>
                    Livros
                </a>
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-2 my-2">
                <a class="btn btn-primary w-100 py-4" href="/autores">
                    <i class="fa-solid fa-user"></i>
                    Autores
                </a>
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-2 my-2">
                <a class="btn btn-primary w-100 py-4" href="/assuntos">
                    <i class="fa-solid fa-comment"></i>
                    Assuntos
                </a>
            </div>
        </div>
    </div>
@endsection
