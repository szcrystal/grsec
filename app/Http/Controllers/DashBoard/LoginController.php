<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Auth;
use Closure;

class LoginController extends Controller
{
    public function __construct(Admin $admin)
    {
        //$this->middleware('adminGuest', ['except' => 'getLogout']);
        //$this->middleware('auth:admin', ['except' => 'index']);
        
        $this->admin = $admin;
    }
    
    public function index()
    {
//        echo session('beforePath');
//        exit();
        if(Auth::guard('admin')->check())
            return redirect('dashboard');
        else
            return view('dashboard.login');
    }
    
    public function postLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
        ];
        
        
        $this->validate($request, $rules); //errorなら自動で$errorが返されてリダイレクト、通過で自動で次の処理へ
        
        $data = $request->all();
        
        $remember = isset($data['remember']) ? true : false;
        
        
        
        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
            
            return redirect()->intended('dashboard');
        }
        else {
            $error[] = 'メールアドレスとパスワードを確認して下さい。';
            //return redirect('dashboard/login') -> withErrors('メールアドレスとパスワードを確認して下さい。');
            return redirect() -> back() -> withErrors($error);
        }
    }
}
