<?php

namespace Modules\User\App\Http\Controllers;

use App\Crud\Index;
use App\Crud\Table;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\RoleRequest;

class RoleController extends Controller
{

    public function index()
    {
        $this->verifyPermission('Perfil');
        if (Table::isAjax()) return Table::data(Role::all());

        $index = new Index();
        $index = $index
            ->icon('icon-file-text')
            ->name('Perfis')
            ->breadcrumbs([
                [
                    'name' => 'Dashboard',
                    'route' => route('admin.dashboard.index')
                ]
            ])
            ->table([
                'name' => 'Perfil',
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
        $this->verifyPermission('Perfil Cadastrar');

        $permissions = Permission::all()->sortBy('name');

        return view('admin.role.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $this->verifyPermission('Perfil Cadastrar');

        $role = new Role();
        $role->name = $request->name;
        $role->save();

        $permissionsRequest = $request->except(['_token', '_method', 'name']);

        foreach ($permissionsRequest as $key => $permissionRequest) {
            $permissions[] = Permission::find($key);
        }

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions(null);
        }

        return redirect()->route('admin.role.index');
    }

    public function show($id)
    {
        $this->verifyPermission('Perfil Ler');
    }

    public function edit($id)
    {
        $this->verifyPermission('Perfil Editar');

        $role = Role::find($id);

        $permissions = Permission::all()->sortBy('name');

        foreach ($permissions as $permission) {
            if ($role->hasPermissionTo($permission->name)) {
                $permission->can = true;
            } else {
                $permission->can = false;
            }
        }

        return view('admin.role.edit', compact('role', 'permissions'));
    }


    public function update(RoleRequest $request, $id)
    {
        $this->verifyPermission('Perfil Editar');
        $this->verifyPermission('Perfil Permissões');

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        $permissionsRequest = $request->except(['_token', '_method', 'name']);

        foreach ($permissionsRequest as $key => $permissionRequest) {
            $permissions[] = Permission::find($key);
        }

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions(null);
        }

        return redirect()->route('admin.role.edit', $role->id);
    }

    public function destroy($id)
    {
        $this->verifyPermission('Perfil Deletar');

        $role = Role::find($id);
        $role->delete();

        return redirect()->route('admin.role.index');
    }
}
