<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Http\Controllers\GlobalController;

use Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        new GlobalController;
    }

    public function showLoginForm() {

        $themes = GlobalController::get_themes();

        $view   = 'templates.'.$themes.'.protected.login';

        return view($view);

    }

    public function checkLogin(Request $request) {

        if($request->ajax())  {
            $username   = $request->username;
            $password   = $request->userpass;
        }

        $login = [
            'name'      => $username,
            'password'  => $password
        ];

        $result = '';

        if(Auth::attempt($login)) {

            $themes = GlobalController::get_themes();

            $result = [
                'status'    => 'success',
                'alert'     => 'Đăng nhập thành công'
            ];
            

        } else {

            $result = [
                'status'    => 'warning',
                'alert'     => 'Lỗi! Tên đăng nhập hoặc mật khẩu không đúng'
            ];

        }

        return response()->json($result);

    }

    public function logout() {
        Auth::logout();
        $baseUrl = GlobalController::get_url(['login']);
        return redirect($baseUrl);
    }

}
