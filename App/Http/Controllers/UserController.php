<?php

namespace Modules\User\App\Http\Controllers;

use App\Crud\Index;
use App\Crud\Table;
use App\Models\User;
use App\Support\Cropper;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\UserRequest;

class UserController extends Controller
{

    public function index()
    {
        $this->verifyPermission('Usuário');
        if (Table::isAjax()) return Table::data(User::where('inactive', 0)->where('inactive_admin', 0));

        $index = new Index();
        $index = $index
            ->icon('icon-list')
            ->name('Usuários')
            ->breadcrumbs([
                [
                    'name' => 'Dashboard',
                    'route' => route('admin.dashboard.index')
                ]
            ])
            ->table([
                'name' => 'Usuário',
                'columns' => [
                    [
                        'label' => 'Nome Completo',
                        'data' => 'name'
                    ],
                    [
                        'label' => 'Usuário',
                        'data' => 'username'
                    ],
                    [
                        'label' => 'E-mail',
                        'data' => 'email'
                    ],
                    [
                        'label' => 'Último Acesso',
                        'data' => 'last_login_at',
                    ]
                ],
                'actions' => [
                    'create' => true,
                    'update' => true,
                    'custom' => [
                        'icon' => 'icon-ban icon-notext',
                        'color' => 'yellow',
                        'method' => 'DELETE',
                        'confirm' => 'Tem certeza que deseja bloquear?',
                        'permission' => 'Bloquear'
                    ]
                ]
            ])
            ->init();
        return $index;
    }

    public function create()
    {
        $this->verifyPermission('Usuário Cadastrar');

        $roles = Role::all();

        return view('admin.user.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $this->verifyPermission('Usuário Cadastrar');

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        if (!empty($request->file('profile_file'))) {
            $user->profile_file = $request->file('profile_file')->store('user');
        }

        $rolesRequest = $request->except(['_token', '_method', 'name', 'email', 'password', 'profile_file']);

        foreach ($rolesRequest as $key => $roleRequest) {
            $roles[] = Role::find($key);
        }

        if (!empty($roles)) {
            $user->userable()->first()->syncRoles($roles);
        } else {
            $user->userable()->first()->syncRoles(null);
        }

        $user->save();

        return redirect()->route('admin.user.edit', [
            'user' => $user->id
        ])->with(['color' => 'green', 'message' => 'Usuário Criado com sucesso']);
    }

    public function show($id)
    {
        $this->verifyPermission('Usuário Ler');
    }

    public function edit($id)
    {
        $this->verifyPermission('Usuário Editar');

        $user = User::find($id);

        $roles = Role::all();

        foreach ($roles as $role) {
            if ($user->userable()->first()->hasRole($role->name)) {
                $role->can = true;
            } else {
                $role->can = false;
            }
        }

        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request, $id)
    {
        $this->verifyPermission('Usuário Editar');

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) $user->password = $request->password;
        if (!empty($request->file('profile_file'))) {
            Storage::delete($user->profile_file);
            Cropper::flush($user->profile_file);
            $user->profile_file = $request->file('profile_file')->store('user');
        }

        $rolesRequest = $request->except(['_token', '_method', 'name', 'email', 'password', 'profile_file']);

        foreach ($rolesRequest as $key => $roleRequest) {
            $roles[] = Role::find($key);
        }

        if (!empty($roles)) {
            $user->userable()->first()->syncRoles($roles);
        } else {
            $user->userable()->first()->syncRoles(null);
        }

        $user->save();

        return redirect()->route('admin.user.edit', [
            'user' => $user->id
        ])->with(['color' => 'green', 'message' => 'Usuário Atualizado com sucesso']);
    }

    public function destroy($id)
    {
        $this->verifyPermission('Usuário Bloquear');

        $user = User::find($id);
        $user->inactive = 1;
        $user->save();

        return redirect()->route('admin.blocked.index');
    }
}
