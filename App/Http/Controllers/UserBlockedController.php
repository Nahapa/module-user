<?php

namespace Modules\User\App\Http\Controllers;

use App\Crud\Index;
use App\Crud\Table;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserBlockedController extends Controller
{
    public function index()
    {
        $this->verifyPermission('Bloqueio');
        if (Table::isAjax()) return Table::data(User::where('inactive', '>', 0)->orWhere('inactive_admin', '>', 0));

        $index = new Index();
        $index = $index
            ->icon('icon-ban')
            ->name('Bloqueados')
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
                        'label' => 'Nome',
                        'data' => 'name'
                    ]
                ],
                'actions' => [
                    'delete' => true,
                    'custom' => [
                        'icon' => 'icon-check icon-notext',
                        'color' => 'green',
                        'method' => 'PUT',
                        'action' => 'update',
                        'confirm' => 'Tem certeza que deseja desbloquear?',
                        'permission' => 'Desbloquear'
                    ]
                ],
                'permission' => 'Bloqueio'
            ])
            ->init();
        return $index;
    }

    public function update($id)
    {
        $userBlocked = User::find($id);
        $userBlocked->inactive = 0;
        $userBlocked->save();

        return redirect()->route('admin.user.index');
    }

    public function destroy($id)
    {
        $userBlocked = User::find($id);
        $userBlocked->delete();

        return redirect()->route('admin.blocked.index');
    }
}
