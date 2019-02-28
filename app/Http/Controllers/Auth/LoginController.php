<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

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
    //protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
	public function login(Request $request)
    {
//        print_r(session()->all());
//         exit;   
        
    	$rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8', 
        ];
        
         $messages = [
            //'title.required' => '「商品名」を入力して下さい。',
        ];
        
        $this->validate($request, $rules, $messages);
        $data = $request->all();
        
        $credentials = $request->only('email', 'password');
        $credentials['active'] = 1;
        
        $remember = $request->has('remember') ? 1 : 0;
        
        $prevUrl = $request->has('to_cart') ? '/shop/cart' : $data['previous'];

        if (Auth::attempt($credentials, $remember)) { // 認証に成功した
            return redirect()->intended($prevUrl);
            
        }
        else {
        	$errors = ['認証できません。メールアドレス・パスワードを確認して下さい。'];
        	return redirect()->back()->withInput()->withErrors($errors);
        }
    }
    
    protected function redirectTo()
    {    	
//        if(isset($_POST['to_cart'])) {
//             return '/shop/cart'; 
//          }
    }
    
    
}
