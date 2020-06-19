@extends('app.layout.theme')

@section('content')
<section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="icon-plus">Novo Perfil</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="{{ route('app.dashboard.index') }}">Dashboard</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="{{ route('app.role.index') }}">Perfis</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="{{ route('app.role.create') }}" class="text-primary">Novo Perfil</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="dash_content_app_box">
        <div class="nav">

            @if($errors->all())
                @foreach($errors->all() as $error)
                    @message(['color' => 'red'])
                        <p class="icon-asterisk"> {{ $error }}</p>
                    @endmessage
                @endforeach
            @endif
            <ul class="nav_tabs">
                <li class="nav_tabs_item">
                    <a href="#data" class="nav_tabs_item_link active">Dados Cadastrais</a>
                </li>
            </ul>

            <form class="app_form" action="{{ route('app.role.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="nav_tabs_content">
                    <div id="data">
                        <label class="label">
                            <span class="legend">*Nome:</span>
                            <input type="text" name="name" placeholder="Nome Completo" value="{{ old('name') }}"/>
                        </label>
                    </div>
                    <div class="app_collapse mt-2">
                        <div class="app_collapse_header collapse">
                            <h3>Permissões</h3>
                            <span class="icon-plus-circle icon-notext"></span>
                        </div>

                        <div class="app_collapse_content d-none">
                            @foreach($permissions as $permission)
                                <div class="label">
                                    <label class="label">
                                        <input type="checkbox" name="{{ $permission->id }}" {{ old($permission->id) ? 'checked' : '' }}><span>{{ $permission->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="text-right mt-2">
                    <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
