<?php

namespace Modules\User\App\Http\Controllers;

use App\Support\Message;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $message;

    public function __construct()
    {
        // Tem acesso a o Support de message em todos controllers
        $this->message = new Message();
    }

    protected function verifyPermission($permission)
    {
        if (!Auth::user()->getAdminAttribute()->getHasPermission($permission)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
    }
}
