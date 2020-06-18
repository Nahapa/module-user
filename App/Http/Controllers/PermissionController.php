<?php

namespace Modules\User\App\Http\Controllers;

use App\Crud\Index;
use App\Crud\Table;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\PermissionRequest;

class PermissionController extends Controller
{

    public function index()
    {
        $this->verifyPermission('Permissão');
        if (Table::isAjax()) return Table::data(Permission::all());

        $index = new Index();
        $index = $index
            ->icon('icon-lock')
            ->name('Permissões')
            ->breadcrumbs([
                [
                    'name' => 'Dashboard',
                    'route' => route('admin.dashboard.index')
                ]
            ])
            ->table([
                'name' => 'Permissão',
                'columns' => [
                    [
                        'label' => 'Nome',
                        'data' => 'name'
                    ]
                ],
                'actions' => [
                    'create' => true,
                    'update' => true,
                    'delete' => true
                ]
            ])
            ->init();
        return $index;
    }

    public function create()
    {
        $this->verifyPermission('Permissão Cadastrar');

        return view('admin.permission.create');
    }

    public function store(PermissionRequest $request)
    {
        $this->verifyPermission('Permissão Cadastrar');

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('admin.permission.index');
    }

    public function show($id)
    {
        $this->verifyPermission('Permissão Ler');
    }

    public function edit($id)
    {
        $this->verifyPermission('Permissão Editar');

        $permission = Permission::find($id);
        return view('admin.permission.edit', compact('permission'));
    }

    public function update(PermissionRequest $request, $id)
    {
        $this->verifyPermission('Permissão Editar');

        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('admin.permission.index');
    }

    public function destroy($id)
    {
        $this->verifyPermission('Permissão Deletar');

        $permission = Permission::find($id);
        $permission->delete();

        return redirect()->route('admin.permission.index');
    }
}
