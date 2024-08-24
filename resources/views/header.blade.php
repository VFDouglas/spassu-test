<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>@yield('title', 'Spassu')</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <script src="https://kit.fontawesome.com/c5bf00d259.js" crossorigin="anonymous"></script>
        @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
        @yield('scripts')
    </head>
    <body>
        @yield('modal')
        <nav class="navbar navbar-expand-sm bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="{{asset('img/spassu.jpg')}}" alt="Logo da Spassu" width="35" class="rounded-circle">
                    Spassu
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link @if (request()->is('livros')) text-white disabled @endif"
                               aria-current="page"
                               href="/livros">Livros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (request()->is('autores')) text-white disabled @endif"
                               href="/autores">Autores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (request()->is('assuntos')) text-white disabled @endif"
                               href="/assuntos">Assuntos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @yield('page_content')
    </body>
</html>
