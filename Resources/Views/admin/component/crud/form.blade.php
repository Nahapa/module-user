@extends('admin.layout.theme')

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
                <form action="{{ $form['route'] }}" method="POST" class="app_form" enctype="multipart/form-data">
                    @csrf
                    @if($form['method'] != "POST") @method($form['method']) @endif
                    <div class="nav_tabs_content">
                        @if(!empty($form['tenant']))
                            @component('admin.component.crud.input', ['input' => $form['tenant']])
                            @endcomponent
                        @endif
                        @foreach ($form['tabs'] as $tab)
                            <div id="{{ $tab['id'] }}">
                                @foreach ($form['inputs'] as $input)
                                    @if(!is_array(array_first($input)))
                                        @if($input['tab'] == $tab['id'])
                                            @component('admin.component.crud.input', ['input' => $input])
                                            @endcomponent
                                        @endif
                                    @else
                                        @if($input[0]['tab'] == $tab['id'])
                                            <div class="label_g2">
                                                @component('admin.component.crud.input', ['input' => $input[0]])
                                                @endcomponent
                                                @component('admin.component.crud.input', ['input' => $input[1]])
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
        </div>
    </div>
</section>
@endsection
