@extends('app.layout.theme')

@section('content')
<section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="{{ $form['icon'] }}">{{ $form['name'] }}</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    @foreach($form['breadcrumbs'] as $breadcrumb)
                            <li><a href="{{ $breadcrumb['route'] }}">{{ $breadcrumb['name'] }}</a></li>
                            <li class="separator icon-angle-right icon-notext"></li>
                    @endforeach
                    <li><a class="text-primary" href="{{ Request::url() }}">{{ $form['name'] }}</a></li>
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
            <div class="nav">
                <ul class="nav_tabs">
                    @foreach ($form['tabs'] as $tab)
                    <li class="nav_tabs_item">
                        <a href="#{{ $tab['id'] }}" class="nav_tabs_item_link
                            @if ($loop->first) active @endif">{{ $tab['label'] }}</a>
                    </li>
                    @endforeach
                </ul>
                <form action="{{ route($form['route']) }}" method="{{ $form['method'] }}" class="app_form" enctype="multipart/form-data">
                    @csrf
                    <div class="nav_tabs_content">
                        @if(!empty($form['tenant']))
                            @component('app.component.crud.input', ['input' => $form['tenant']])
                            @endcomponent
                        @endif
                        @foreach ($form['tabs'] as $tab)
                            <div id="{{ $tab['id'] }}">
                                @foreach ($form['inputs'] as $input)
                                    @if(!is_array(array_first($input)))
                                        @if($input['tab'] == $tab['id'])
                                            @component('app.component.crud.input', ['input' => $input])
                                            @endcomponent
                                        @endif
                                    @else
                                        @if($input[0]['tab'] == $tab['id'])
                                            <div class="label_g2">
                                                @component('app.component.crud.input', ['input' => $input[0]])
                                                @endcomponent
                                                @component('app.component.crud.input', ['input' => $input[1]])
                                                @endcomponent
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <div class="text-right mt-2">
                        <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar
                        </button>
                    </div>
                </form>
            </div>


            {{-- <ul class="nav_tabs">
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
                    </div>
                </div>

                <div class="text-right mt-2">
                    <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                    </button>
                </div>
            </form> --}}
        </div>
    </div>
</section>
@endsection
