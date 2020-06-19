<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">

    <link rel="stylesheet" href="{{ asset(mix('assets/admin/css/reset.css')) }}"/>
    <link rel="stylesheet" href="{{ asset(mix('assets/admin/css/libs.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('assets/admin/css/boot.css')) }}"/>
    <link rel="stylesheet" href="{{ asset(mix('assets/admin/css/style.css')) }}"/>

    @hasSection('css')
        @yield('css')
    @endif

    <link rel="icon" type="image/png" href="{{ asset('assets/admin/images/favicon.png') }}" />

    <title>{{ config('app.name') }} - Site Control</title>
</head>

<body>

    <div class="ajax_load">
        <div class="ajax_load_box">
            <div class="ajax_load_box_circle"></div>
            <p class="ajax_load_box_title">Aguarde, carregando...</p>
        </div>
    </div>

    <div class="ajax_response"></div>

    <div class="dash">
        <aside class="dash_sidebar">
            <article class="dash_sidebar_user">
                <img class="dash_sidebar_user_thumb" src="{{ Auth::check() ? asset(Auth::user()->profile_file) : asset('assets\admin\images\avatar.jpg') }}" alt="" title="" />

                <h1 class="dash_sidebar_user_name">
                    <a href="">{{ Auth::check() ? Auth::user()->name : 'Visitante' }}</a>
                </h1>
            </article>

            <ul class="dash_sidebar_nav">
                <li class="dash_sidebar_nav_item {{ isActive('admin.dashboard') }}">
                    <a class="icon-tachometer" href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                </li>
                <li class="dash_sidebar_nav_item {{ isActive(['admin.category', 'admin.product']) }}"><a class="icon-clipboard" href="{{ route('admin.product.index') }}">Cadastros</a>
                    <ul class="dash_sidebar_nav_submenu">
                        <li class="{{ isActive('admin.product') }}"><a class="icon-barcode" href="{{ route('admin.product.index') }}">Produtos</a></li>
                        <li class="{{ isActive('admin.category') }}"><a class="icon-table" href="{{ route('admin.category.index') }}">Categorias</a></li>
                    </ul>
                </li>
                <li class="dash_sidebar_nav_item {{ isActive(['admin.user', 'admin.blocked', 'admin.role', 'admin.permission']) }}"><a class="icon-users" href="{{ route('admin.user.index') }}">Usuários</a>
                    <ul class="dash_sidebar_nav_submenu">
                        <li class="{{ isActive(['admin.user.index', 'admin.user.edit']) }}"><a class="icon-list" href="{{ route('admin.user.index') }}">Ver Todos</a></li>
                        <li class="{{ isActive('admin.user.create') }}"><a class="icon-plus"href="{{ route('admin.user.create') }}">Criar Novo</a></li>
                        <li class="{{ isActive('admin.blocked') }}"><a class="icon-ban" href="{{ route('admin.blocked.index') }}">Bloqueados</a></li>
                        <li class="{{ isActive('admin.role') }}"><a class="icon-file-text" href="{{ route('admin.role.index') }}">Perfis</a></li>
                        <li class="{{ isActive('admin.permission') }}"><a class="icon-lock" href="{{ route('admin.permission.index') }}">Permissões</a></li>
                    </ul>
                </li>
                <li class="dash_sidebar_nav_item"><a class="icon-reply" href="">Ver Site</a></li>
                <li class="dash_sidebar_nav_item">
                    <form action="{{ route('admin.logout') }}" method="post">
                        @csrf
                        <a class="icon-sign-out on_mobile" href="#"
                            onclick="this.closest('form').submit();return false;" >Sair</a>
                    </form>
                </li>
            </ul>

        </aside>

        <section class="dash_content">

            <div class="dash_userbar">
                <div class="dash_userbar_box">
                    <div class="dash_userbar_box_content">
                        <span class="icon-align-justify icon-notext mobile_menu transition btn btn-green"></span>
                        <h1 class="transition">
                            <i class="icon-imob text-primary"></i><a href=""><b>{{ config('app.name') }}</b></a>
                        </h1>
                        <div class="dash_userbar_box_bar no_mobile">
                            <form action="{{ route('admin.logout') }}" method="post">
                                @csrf
                                <a href="#" class="text-red icon-sign-out"
                                    onclick="this.closest('form').submit();return false;" >Sair</a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="dash_content_box">
                @yield('content')
            </div>
        </section>
    </div>


    <script src="{{ asset(mix('assets/admin/js/libs.js')) }}"></script>
    <script src="{{ asset(mix('assets/admin/js/scripts.js')) }}"></script>

    @hasSection('js')
        @yield('js')
    @endif

</body>

</html>
