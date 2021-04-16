<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Social;
use Socialite;
use App\Login;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if(!$user->active) {
            auth()->logout();
            return back()->withInput()->with(['alert' => [
                'type' => 'warning',
                'title' => 'Tài khoản chưa được kích hoạt!',
                'content' => 'Hãy kiểm tra email để kích hoạt tài khoản.'
            ]]);
        } else if($user->admin) {
            return redirect()->route('admin.dashboard')->with(['alert' => [
                'type' => 'success',
                'title' => 'Đăng nhập thành công',
                'content' => 'Chào mừng bạn đến với trang quản trị website'
            ]]);
        } else {
            return redirect()->route('home_page')->with(['alert' => [
                'type' => 'success',
                'title' => 'Đăng nhập thành công',
                'content' => 'Chào mừng bạn đến với website của chúng tôi'
            ]]);
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()->withInput()->with('message', trans('auth.failed'));
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('home_page')->with(['alert' => [
            'type' => 'success',
            'title' => 'Đăng xuất thành công',
            'content' => 'Chúc bạn một ngày vui vẻ.'
        ]]);
    }


//=================================================
    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            //login in vao trang quan tri  
            $account_name = Login::where('aid',$account->user)->first();
            Session::put('name',$account_name->admin_name);
            Session::put('id',$account_name->id);
            return redirect('/admin/dashboard')->with('message', 'Đăng nhập thành công');
        }else{

            $hieu = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Login::create([
                    'name' => $provider->getName(),
                    'email' => $provider->getEmail(),
                    'password' => '',
                    'phone' => ''

                ]);
            }
            $hieu->login()->associate($orang);
            $hieu->save();

            $account_name = Login::where('id',$account->user)->first();

            Session::put('name',$account_name->name);
            Session::put('id',$account_name->id);
            return redirect('/admin/dashboard')->with('message', 'Đăng nhập thành công');
        } 
    }

}
