<?php

namespace Modules\User\App\Http\Controllers\Auth;

use Socialite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\User\App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $sectionConfig = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sectionConfig = \Section::get('login'); // LOGIN CUSTOM
        $guard = $this->sectionConfig['guard']; // LOGIN CUSTOM
        $this->middleware("guest:$guard")->except('logout'); // LOGIN CUSTOM
        $this->redirectTo = route($this->sectionConfig['redirect_login']); // LOGIN CUSTOM
        $this->username = $this->findUsername(); // LOGIN USERNAME OR EMAIL
    }

    //////////////////
    // LOGIN CUSTOM //
    //////////////////

    public function showLoginForm()
    {
        return view($this->sectionConfig['show_login_form']);
    }

    protected function loggedOut(Request $request)
    {
        return redirect($this->sectionConfig['logged_out']);
    }

    protected function guard()
    {
        return \Auth::guard($this->sectionConfig['guard']);
    }

    public function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);
    }

    /////////////////////////////
    // LOGIN USERNAME OR EMAIL //
    /////////////////////////////

    public function findUsername()
    {
        $username = request()->input('username');

        $fieldType = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $username]);

        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }


    //////////////////
    // LOGIN SOCIAL //
    //////////////////

    public function redirectToProviderFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallbackFacebook()
    {
        $user = Socialite::driver('facebook')->user();
        // $user->token;
    }

    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallbackGoogle()
    {
        $user = Socialite::driver('google')->user();
        // $user->token;
    }
}
