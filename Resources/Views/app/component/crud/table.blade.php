<div class="dash_content_app_box_table_header_action">
    @if(!empty($table['actions']['create']))
        <a href="{{ Request::url() }}/create" class="btn btn-primary icon-plus ml-1">Criar {{ $table['name'] }}</a>
    @endif
</div>
<div class="dash_content_app_box_table_body">
    <table id="dataTable" class="nowrap stripe" width="100" style="width: 100% !important;">
        <thead>
            <tr>
                @foreach($table['columns'] as $column)
                    @if($column['label'] == '#') <th width='1'>{{ $column['label'] }}</th>
                    @else <th>{{ $column['label'] }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

@section('js')
    <script>
        // DATATABLES
        $('#dataTable').DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': {
                'url': "{{ Request::url() }}"
            },
            'columns': {!! json_encode($table['columns']) !!},
            @if($table['actions'])
            "columnDefs": [
                {
                    "targets": -1,
                    "render": function(data, type, row) {
                        return `
                            <div style="display:flex; width:auto;">
                                @if(!empty($table['actions']['update']))
                                    @if(Auth::user()->getAdminAttribute()->first()->getHasPermission($table['permission'].' Editar'))
                                        <a href='{{ Request::url() }}/${data.id}/edit'
                                            class='btn btn-blue'>
                                            <i class="icon-pencil icon-notext"></i>
                                        </a>
                                    @endif
                                @endif
                                @if(!empty($table['actions']['custom']))
                                    @foreach($table['actions']['custom'] as $action)
                                        @if(Auth::user()->getAdminAttribute()->first()->getHasPermission($table['permission'].' '.$action['permission']))
                                            @if($action['method'] == 'GET')
                                                <a href='{{ Request::url() }}/${data.id}/{{ $action['action'] }}'
                                                    class='btn btn-{{ $action['color'] }}'>
                                                    <i class="{{ $action['icon'] }}"></i>
                                                    {{ $action['label'] }}
                                                </a>
                                            @else
                                                <form action="{{ Request::url() }}/${data.id}{{ $action['action'] }}" method="POST">
                                                    @csrf
                                                    @method($action['method'])
                                                    <button type="submit" class='btn btn-{{ $action['color'] }}'
                                                        onclick="return confirm('{{ $action['confirm'] }}');" >
                                                        <i class="{{ $action['icon'] }}"></i>
                                                        {{ $action['label'] }}
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                                @if(!empty($table['actions']['delete']))
                                    @if(Auth::user()->getAdminAttribute()->first()->getHasPermission($table['permission'].' Deletar'))
                                        <form action="{{ Request::url() }}/${data.id}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class='btn btn-red'
                                                onclick="return confirm('Tem certeza que deseja deletar?');" >
                                                <i class="icon-times icon-notext"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        `;
                    }
                }
            ],
            @endif
            'responsive': true,
            'pageLength': 25,
            'language': {
                'sEmptyTable': "Nenhum registro encontrado",
                'sInfo': "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                'sInfoEmpty': "Mostrando 0 até 0 de 0 registros",
                'sInfoFiltered': "(Filtrados de _MAX_ registros)",
                'sInfoPostFix': "",
                'sInfoThousands': ".",
                'sLengthMenu': "_MENU_ resultados por página",
                'sLoadingRecords': "Carregando...",
                'sProcessing': "Processando...",
                'sZeroRecords': "Nenhum registro encontrado",
                'sSearch': "Pesquisar",
                'oPaginate': {
                    'sNext': "Próximo",
                    'sPrevious': "Anterior",
                    'sFirst': "Primeiro",
                    'sLast': "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
        });
    </script>
@endsection
