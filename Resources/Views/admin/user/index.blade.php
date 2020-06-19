@extends('admin.layout.theme')

@section('content')
<section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="icon-users">Usuários</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="{{ route('admin.user.index') }}" class="text-primary">Usuários</a></li>
                </ul>
            </nav>

            <a href="{{ route('admin.user.create') }}" class="btn btn-primary icon-plus ml-1">Criar Usuário</a>
            <button class="btn btn-green icon-search icon-notext ml-1 search_open"></button>
        </div>
    </header>

    @include('admin.user.filter')

    <div class="dash_content_app_box">
        <div class="dash_content_app_box_stage">
            <table id="dataTable" class="nowrap stripe" width="100" style="width: 100% !important;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuário</th>
                        <th>Nome Completo</th>
                        <th>E-mail</th>
                        <th>Último Acesso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><a href="{{ route('admin.user.edit', $user->id) }}" class="text-primary">{{ $user->username }}</a></td>
                            <td>{{ $user->name }}</td>
                            <td><a href="mailto:{{ $user->email }}" class="text-primary">{{ $user->email }}</a></td>
                            <td>{{ $user->last_login_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
