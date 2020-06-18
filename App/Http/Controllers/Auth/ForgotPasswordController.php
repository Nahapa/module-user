<?php

namespace Modules\User\App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Modules\User\App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $config = \Section::get('login');
        $guard = $config['guard'];
        $this->middleware("guest:$guard");
    }

    protected function validateEmail(Request $request)
    {
        $rule = \Section::getSection() == 'admin' ? 'is_admin' : 'is_user_tenant';
        $request->validate(['email' => "required|email|$rule"]);
    }
}
