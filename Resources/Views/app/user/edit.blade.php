@extends('app.layout.theme')

@section('content')
<section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="icon-pencil">Editar Usuário</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="{{ route('app.dashboard.index') }}">Dashboard</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="{{ route('app.user.index') }}">Usuários</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="{{ route('app.user.edit', $user->id) }}" class="text-primary">Editar Usuário</a></li>
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

            @if(session()->exists('message'))
                @message(['color' => session()->get('color')])
                    <p class="icon-check">{{ session()->get('message') }}</p>
                @endmessage
            @endif

            <ul class="nav_tabs">
                <li class="nav_tabs_item">
                    <a href="#data" class="nav_tabs_item_link active">Dados Cadastrais</a>
                </li>
            </ul>

            <form class="app_form" action="{{ route('app.user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="nav_tabs_content">
                    <div id="data">
                        <label class="label">
                            <span class="legend">*Nome:</span>
                            <input type="text" name="name" placeholder="Nome Completo" value="{{ old('name') ?? $user->name }}"/>
                        </label>

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">*Usuário:</span>
                                <input type="text" name="username" placeholder="Usuário de Acesso"
                                       value="{{ old('username') ?? $user->username }}"/>
                            </label>

                            <label class="label">
                                <span class="legend">*E-Mail:</span>
                                <input type="text" name="email" placeholder="E-mail de Acesso"
                                        value="{{ old('email') ?? $user->email }}"/>
                            </label>
                        </div>

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">*Senha:</span>
                                <input type="password" name="password" placeholder="Senha de Acesso" />
                            </label>

                            <label class="label">
                                <span class="legend">*Confirmar Senha:</span>
                                <input type="password" name="password_confirmation" placeholder="Confirme a Senha" />
                            </label>
                        </div>
                        <label class="label">
                            <span class="legend">Foto</span>
                            <input type="file" name="profile_file">
                        </label>
                    </div>

                    <div class="app_collapse mt-2">
                        <div class="app_collapse_header collapse">
                            <h3>Perfis</h3>
                            <span class="icon-plus-circle icon-notext"></span>
                        </div>

                        <div class="app_collapse_content d-none">
                            @foreach($roles as $role)
                                <div class="label">
                                    <label class="label">
                                        <input type="checkbox" name="{{ $role->id }}" {{ ($role->can) ? 'checked' : '' }}><span>{{ $role->name }}</span>
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
