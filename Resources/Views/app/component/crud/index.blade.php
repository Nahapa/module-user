@extends('app.layout.theme')

@section('content')
<section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="{{ $index['icon'] }}">{{ $index['name'] }}</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    @foreach($index['breadcrumbs'] as $breadcrumb)
                            <li><a href="{{ $breadcrumb['route'] }}">{{ $breadcrumb['name'] }}</a></li>
                            <li class="separator icon-angle-right icon-notext"></li>
                    @endforeach
                    <li><a class="text-primary" href="{{ Request::url() }}">{{ $index['name'] }}</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="dash_content_app_box">
        <div class="dash_content_app_box_stage">
            @component('app.component.crud.table', ['table' => $index['table']])
            @endcomponent
        </div>
    </div>
</section>
@endsection
